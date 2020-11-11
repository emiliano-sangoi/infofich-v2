<?php

// src/AppBundle/Security/PostVoter.php

namespace PlanificacionesBundle\Security;

use AppBundle\Entity\Usuario;
use LogicException;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PlanificacionVoter extends Voter {

    /**
     * Esta funcion define si el voter debe decidir o abstenerse. 
     * 
     * @param type $attribute
     * @param Planificacion $subject
     * @return boolean
     */
    protected function supports($attribute, $subject) {
        
        $permisos_soportados = array(
            Planificacion::PERMISO_LISTAR,
            Planificacion::PERMISO_CREAR,
            Planificacion::PERMISO_EDITAR,
            Planificacion::PERMISO_BORRAR,
            Planificacion::PERMISO_VER
        );
       
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, $permisos_soportados)) {
            return false;
        }                
 //dump($attribute, $permisos_soportados, in_array($attribute, $permisos_soportados), !is_array($subject) || isset($subject['data']));exit;
        // only vote on Post objects inside this voter
        if (!is_array($subject) || isset($subject['data'])) {
            return false;
        }                

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) {
        $user = $token->getUser();

        if (!$user instanceof Usuario) {
            // the user must be logged in; if not, deny access
            return false;
        }
        
        

        // you know $subject is a Post object, thanks to supports
        /** @var Post $post */
        $planif = $subject['data'];

        switch ($attribute) {
            case Planificacion::PERMISO_VER:
                return $this->puedeVer($planif, $user);
            case Planificacion::PERMISO_EDITAR:
                return $this->puedeEditar($planif, $user);
            case Planificacion::PERMISO_CREAR:
                return $this->puedeCrear($user);
            case Planificacion::PERMISO_LISTAR:
                return $this->puedeListar($user);
            case Planificacion::PERMISO_BORRAR:
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
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        //return $user === $post->getOwner();
        return false;
    }

    private function puedeCrear(Usuario $user) {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        //return $user === $post->getOwner();
        return true;
    }

    private function puedeListar(Usuario $user) {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        //return $user === $post->getOwner();
        return true;
    }

    private function puedeBorrar(Planificacion $planif, Usuario $user) {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        //return $user === $post->getOwner();
        return false;
    }

}
