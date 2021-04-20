<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Docente
 *
 * @ORM\Table(name="planif_docentes_colaboradores")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\PlanificacionDocenteColaboradorRepository")
 */
class PlanificacionDocenteColaborador {
    
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
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="docentesColaboradores")
     * @ORM\JoinColumn(name="planificacion_id", referencedColumnName="id") 
     */
    private $planificacion;
    
    /**
     *
     * @var DocentesBundle\Entity\DocenteGrado
     * 
     * @ORM\ManyToOne(targetEntity="DocentesBundle\Entity\DocenteGrado", inversedBy="planificacionesColaborador")
     * @ORM\JoinColumn(name="docente_grado_id", referencedColumnName="id")
     */
    private $docenteGrado;
    
    
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
        return $this->planificacion->getAnioAcad() . ' - ' . $this->planificacion->getCodigoAsignatura() . ' / ' . $this->docenteGrado;
    }
    
        /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return PlanificacionDocenteColaborador
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return PlanificacionDocenteColaborador
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
     * Set docenteGrado
     *
     * @param \DocentesBundle\Entity\DocenteGrado $docenteGrado
     *
     * @return PlanificacionDocenteColaborador
     */
    public function setDocenteGrado(\DocentesBundle\Entity\DocenteGrado $docenteGrado = null)
    {
        $this->docenteGrado = $docenteGrado;

        return $this;
    }

    /**
     * Get docenteGrado
     *
     * @return \DocentesBundle\Entity\DocenteGrado
     */
    public function getDocenteGrado()
    {
        return $this->docenteGrado;
    }
}
