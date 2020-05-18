<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docente
 *
 * @ORM\Table(name="planif_docentes_colaboradores")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\DocenteColaboradorRepository")
 */
class DocenteColaboradorPlanificacion extends DocentePlanificacion {

    /**
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="docentesColaboradores")
     * @ORM\JoinColumn(name="planif_planificaciones_id", referencedColumnName="id") 
     */
    private $planificacion;

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
