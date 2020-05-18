<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docente
 *
 * @ORM\Table(name="planif_docentes_adscriptos")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\DocenteAdscriptoRepository")
 */
class DocenteAdscriptoPlanificacion extends DocentePlanificacion {

    /**
     * @var string
     *
     * @ORM\Column(name="resolucion", type="string", length=64)
     */
    private $resolucion;

    /**
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="docentesAdscriptos")
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
    public function setPlanificacion(\PlanificacionesBundle\Entity\Planificacion $planificacion = null)
    {
        $this->planificacion = $planificacion;

        return $this;
    }

    /**
     * Get planificacion
     *
     * @return \PlanificacionesBundle\Entity\Planificacion
     */
    public function getPlanificacion()
    {
        return $this->planificacion;
    }


    /**
     * Set resolucion
     *
     * @param string $resolucion
     *
     * @return DocenteAdscriptoPlanificacion
     */
    public function setResolucion($resolucion)
    {
        $this->resolucion = $resolucion;

        return $this;
    }

    /**
     * Get resolucion
     *
     * @return string
     */
    public function getResolucion()
    {
        return $this->resolucion;
    }
}
