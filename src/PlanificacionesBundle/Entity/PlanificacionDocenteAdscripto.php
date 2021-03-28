<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanificacionDocenteAdscripto
 *
 * @ORM\Table(name="planif_docentes_adscriptos")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\PlanificacionDocenteAdscriptoRepository")
 */
class PlanificacionDocenteAdscripto {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="docentesAdscriptos")
     * @ORM\JoinColumn(name="planificacion_id", referencedColumnName="id") 
     */
    private $planificacion;

    /**
     *
     * @var DocentesBundle\Entity\DocenteAdscripto
     * 
     * @ORM\ManyToOne(targetEntity="DocentesBundle\Entity\DocenteAdscripto", inversedBy="planificacionesColaborador")
     * @ORM\JoinColumn(name="docente_adscripto_id",referencedColumnName="id")
     */
    private $docenteAdscripto;
    

    /**
     *
     * @var integer 
     * 
     * @ORM\Column(name="orden", type="smallint")
     */
    private $orden;

    public function __construct() {
        
    }

    public function __toString() {
        return $this->planificacion->getAnioAcad() . ' - ' . $this->planificacion->getCodigoAsignatura() . ' / ' . $this->docenteAdscripto->getNombre();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return PlanificacionDocenteAdscripto
     */
    public function setOrden($orden) {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden() {
        return $this->orden;
    }

    /**
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return PlanificacionDocenteAdscripto
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

    /**
     * Set docenteAdscripto
     *
     * @param \DocentesBundle\Entity\DocenteAdscripto $docenteAdscripto
     *
     * @return PlanificacionDocenteAdscripto
     */
    public function setDocenteAdscripto(\DocentesBundle\Entity\DocenteAdscripto $docenteAdscripto = null) {
        $this->docenteAdscripto = $docenteAdscripto;

        return $this;
    }

    /**
     * Get docenteAdscripto
     *
     * @return \DocentesBundle\Entity\DocenteAdscripto
     */
    public function getDocenteAdscripto() {
        return $this->docenteAdscripto;
    }

}
