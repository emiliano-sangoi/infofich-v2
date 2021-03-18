<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/*
 * Docente
 *
 * @ORM\Table(name="planif_docentes_responsables")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\DocenteResponsablePlanificacionRepository")
 */
class DocenteResponsablePlanificacion extends DocentePlanificacion {

    /**
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="docenteResponsable")
     * @ORM\JoinColumn(name="planif_planificaciones_id", referencedColumnName="id") 
     */
    private $planificacion;
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return DocentePlanificacion
     */
    public function setPlanificacion(\PlanificacionesBundle\Entity\Planificacion $planificacion = null) {
        $this->planificacion = $planificacion;

        return $this;
    }

    /**
     * Get planificacion
     *
     * @return \PlanificacionesBundle\Entity\Planificacion
     */
    public function getPlanificacion() {
        return $this->planificacion;
    }

}
