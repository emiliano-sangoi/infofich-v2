<?php

namespace PlanificacionesBundle\Service;

use AppBundle\Repository\RolRepository;
use Doctrine\ORM\EntityManager;
use PlanificacionesBundle\Entity\Planificacion;

/**
 * Description of PlanificacionService
 *
 * @author emi88
 */
class PlanificacionService {

    /**
     *
     * @var string
     */
    private $ultimoError;

    /**
     *
     * @var EntityManager 
     */
    private $em;

    /**
     *
     * @var RolRepository 
     */
    private $repoRoles;

    /**
     *
     * @var array 
     */
    private $errores;
    

    public function __construct($entityManager) {

        $this->em = $entityManager;
        $this->errores = array();
        $this->repoRoles = $this->em->getRepository('AppBundle:Rol');
    }

    public function validar(Planificacion $planificacion) {

        $this->errores = array();
        
        return $this->validarInfoBasica($planificacion);
    }

    private function validarInfoBasica(Planificacion $planificacion) {
        $errores = array();

        //toda la validacion necesaria de info basica

        $this->errores['info_basica'] = $errores;
        return empty($errores);
    }

    public function getUltimoError() {
        return $this->ultimoError;
    }

    public function getErrores() {
        return $this->errores;
    }



}
