<?php

// src/AppBundle/Security/PostVoter.php

namespace PlanificacionesBundle\Security;

use AppBundle\Entity\Usuario;
use AppBundle\Seguridad\Permisos;
use DocentesBundle\Entity\DocenteAdscripto;
use DocentesBundle\Entity\DocenteGrado;
use DocentesBundle\Repository\DocenteAdscriptoRepository;
use DocentesBundle\Repository\DocenteGradoRepository;
use Doctrine\ORM\EntityManager;
use LogicException;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use function dump;


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
            Permisos::PLANIF_VER
        );
       
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, $permisos_soportados)) {
            return false;
        }         
        //dump($attribute, !is_array($subject), !isset($subject['data']));exit;
 //dump($attribute, $permisos_soportados, in_array($attribute, $permisos_soportados), !is_array($subject) || isset($subject['data']));exit;
        // only vote on Post objects inside this voter        
        if (!is_array($subject) || !array_key_exists('data', $subject) ) {
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
        }

        throw new LogicException('This code should not be reached!');
    }

    private function puedeVer(Planificacion $planif, Usuario $user) {         
        // if they can edit, they can view
        if ($this->puedeEditar($planif, $user)) {
            return true;
        }

        // the Post object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        return false;
    }

    private function puedeEditar(Planificacion $planif, Usuario $user) {

        if( $planif->getOwner() == $user &&  $user->tienePermiso(Permisos::PLANIF_EDITAR)){
            //para editar el usuario debe ser el owner y tener el permiso
            return true;
        }
        
        return false;
    }

    private function puedeCrear(Usuario $user) {
        
        //puede hacerlo si tiene el rol asignado
        if($user->tienePermiso(Permisos::PLANIF_CREAR)){
            return true;
        }
        
        $docenteAdscripto = $this->repoDocenteAdscripto->findByPersona($user->getPersona());        
        if($docenteAdscripto instanceof DocenteAdscripto){
            //Docentes adscriptos no pueden dar de alta planificaciones
            return false;
        }
        
        $docenteGrado = $this->repoDocenteGrado->findByPersona($user->getPersona()); 
        
        if($docenteGrado instanceof DocenteGrado){
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
        if($user->tienePermiso(Permisos::PLANIF_LISTAR)){
            return true;
        }
        
        
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        //return $user === $post->getOwner();
        return false;
    }

    private function puedeBorrar(Planificacion $planif, Usuario $user) {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        //return $user === $post->getOwner();
        return false;
    }

}
