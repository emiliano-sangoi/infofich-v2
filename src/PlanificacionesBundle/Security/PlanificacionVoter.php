<?php

// src/AppBundle/Security/PostVoter.php

namespace PlanificacionesBundle\Security;

use AppBundle\Entity\Rol;
use AppBundle\Entity\Usuario;
use AppBundle\Seguridad\Permisos;
use DocentesBundle\Entity\DocenteAdscripto;
use DocentesBundle\Entity\DocenteGrado;
use DocentesBundle\Repository\DocenteAdscriptoRepository;
use DocentesBundle\Repository\DocenteGradoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use LogicException;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Este voter implementa los requerimientos definidos en:
 *  - https://docs.google.com/document/d/1KJqVKcsQsLEeshYLGWQRCe88MKgMmL9HtB25Gdw5A_E/edit#
 * 
 */
class PlanificacionVoter extends Voter {

    /**
     *
     * @var EntityManager
     */
    private $em;

    /**
     *
     * @var DocenteGradoRepository
     */
    private $repoDocenteGrado;

    /**
     *
     * @var DocenteAdscriptoRepository
     */
    private $repoDocenteAdscripto;

    public function __construct(EntityManager $em) {

        $this->em = $em;
        $this->repoDocenteGrado = $this->em->getRepository(DocenteGrado::class);
        $this->repoDocenteAdscripto = $this->em->getRepository(DocenteAdscripto::class);
    }

    /**
     * Esta funcion define si el voter debe decidir o abstenerse. 
     * 
     * @param type $attribute
     * @param Planificacion $subject
     * @return boolean
     */
    protected function supports($attribute, $subject) {

        $permisos_soportados = array(
            Permisos::PLANIF_LISTAR,
            Permisos::PLANIF_CREAR,
            Permisos::PLANIF_EDITAR,
            Permisos::PLANIF_BORRAR,
            Permisos::PLANIF_VER,
            Permisos::PLANIF_DUPLICAR,
            Permisos::PLANIF_ENVIAR_CORRECCION,
            Permisos::PLANIF_PUBLICAR
        );

        // if the attribute isn't one we support, return false
        if (!in_array($attribute, $permisos_soportados)) {
            return false;
        }
        //dump($attribute, !is_array($subject), !isset($subject['data']));exit;
        //dump($attribute, $permisos_soportados, in_array($attribute, $permisos_soportados), !is_array($subject) || isset($subject['data']));exit;
        // only vote on Post objects inside this voter        
        if (!is_array($subject) || !array_key_exists('data', $subject)) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();

        if (!$user instanceof Usuario) {
            // el usuario debe estar logueado
            return false;
        }

        //Si es secretaria academica o el admin tienen todos los permisos sobre la planificacion:        
        if ($user->tieneRol(Rol::ROLE_ADMIN) || $user->tieneRol(Rol::ROLE_SEC_ACADEMICA)) {
            return true;
        }

        /** @var Post $post */
        $planif = $subject['data'];

        switch ($attribute) {
            case Permisos::PLANIF_VER:
                return $this->puedeVer($planif, $user);
            case Permisos::PLANIF_EDITAR:
                return $this->puedeEditar($planif, $user);
            case Permisos::PLANIF_CREAR:
                return $this->puedeCrear($user);
            case Permisos::PLANIF_LISTAR:
                return $this->puedeListar($user);
            case Permisos::PLANIF_BORRAR:
                return $this->puedeBorrar($planif, $user);
            case Permisos::PLANIF_DUPLICAR:
                return $this->puedeDuplicar($planif, $user);
            case Permisos::PLANIF_ENVIAR_CORRECCION:
                return $this->puedeEnviarACorreccion($planif, $user);
            case Permisos::PLANIF_PUBLICAR:
                return $this->puedeAprobar($planif, $user);
        }

        throw new LogicException('This code should not be reached!');
    }

    private function puedeVer(Planificacion $planif, Usuario $user) {
        // si puede editar, puede ver
        if ($this->puedeEditar($planif, $user)) {
            return true;
        }

        // the Post object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return false;
    }    

    private function puedeEditar(Planificacion $planif, Usuario $user) {        
        
        if($planif->getOwner() == $user){
            return true;
        }

        //Planificaciones del usuario $user:
        $planificaciones = $this->em->getRepository(Planificacion::class)->getPlanificacionesUsuario($user);

        if ($planificaciones instanceof Query) {
            $planificaciones = $planificaciones->getResult();
        }

        $ok = false;
        foreach ($planificaciones as $p) {
            if ($planif == $p) {
                $ok = true;
                break;
            }
        }       
        
        //Si $ok es true es porque la planificacion es una en la que el usuario figura relacionado de alguna
        //forma, o es responsable, colaborador o adscripto.
        
        //si tiene permiso de edicion entonces podrá modificar la planificacion:
        return $ok && $user->tienePermiso(Permisos::PLANIF_EDITAR);        
    }
    
    private function puedeAprobar(Planificacion $planificacion, Usuario $user) {
        
        $hea = $planificacion->getHistoricoEstadoActual();
        if(!$hea){
            return false;
        }
        
        $ea = $hea->getEstado();
        if(in_array($ea->getCodigo(), array(Estado::PUBLICADA, Estado::PREPARACION))){
           return false; 
        }
        
        return $user->tienePermiso(Permisos::PLANIF_PUBLICAR);
    }

    private function puedeCrear(Usuario $user) {

        //puede hacerlo si tiene el rol asignado
        if ($user->tienePermiso(Permisos::PLANIF_CREAR)) {
            return true;
        }

        $docenteAdscripto = $this->repoDocenteAdscripto->findByPersona($user->getPersona());
//        dump($docenteAdscripto);exit;
        if ($docenteAdscripto instanceof DocenteAdscripto) {
            //Docentes adscriptos no pueden dar de alta planificaciones
            return false;
        }

        $docenteGrado = $this->repoDocenteGrado->findByPersona($user->getPersona());

        if ($docenteGrado instanceof DocenteGrado) {
            //Docentes de grado pueden dar de alta planificaciones
            return true;
        }

        //Si se llego hasta este punto, el usuario no tiene el permiso ni tampoco es docente,
        //en este caso, se prohibe la creacion
        return false;

        //dump($user, $docente, "dsds");exit;
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        //return $user === $post->getOwner();        
    }

    private function puedeListar(Usuario $user) {

        //puede hacerlo si tiene el rol asignado
        if ($user->tienePermiso(Permisos::PLANIF_LISTAR)) {
            return true;
        }


        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        //return $user === $post->getOwner();
        return false;
    }

    private function puedeBorrar(Planificacion $planif, Usuario $user) {

        // si puede editar, puede borrar
        if ($this->puedeEditar($planif, $user)) {
            return true;
        }

        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        //return $user === $post->getOwner();
        return false;
    }

    private function puedeDuplicar(Planificacion $planif, Usuario $user) {

        // si puede editar, puede duplicar
        if ($this->puedeEditar($planif, $user)) {
            return true;
        }

        return false;
    }
    
    private function puedeEnviarACorreccion(Planificacion $planif, Usuario $user) {
        
        $eActual = $planif->getEstadoActual();
        if($eActual && $eActual->getCodigo() == Estado::REVISION){
            return false;
        }

        return $user->tienePermiso(Permisos::PLANIF_ENVIAR_CORRECCION);
        
    }

}
