<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Resultados
 *
 * @ORM\Table(name="planif_resultados_aprendizajes")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\ResultadosAprendizajeRepository")
 */
class ResultadosAprendizajes {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     * @var string
     *
     * @ORM\Column(name="resultado", type="text", nullable=true)
     */
    private $resultado;

    /**
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="resultados")
     * @ORM\JoinColumn(name="planif_planificaciones_id", referencedColumnName="id") 
     */
    private $planificacion;

    /**
     * @ORM\Column(name="posicion", type="integer")
     */
    private $posicion;

    public function __construct() {
        ;
    }

    public function __toString() {
        return 'Resultado ' . $this->resultado;
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
     * Set resultado
     *
     * @param string $resultado
     *
     * @return Resultado
     */
    public function setResultado($resultado) {
        $this->resultado = $resultado;
        return $this;
    }

    /**
     * Get resultado
     *
     * @return string
     */
    public function getResultado() {
        return $this->resultado;
    }

    /**
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return Resultado
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
     * Set posicion
     *
     * @param integer $posicion
     *
     * @return Resultado
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer
     */
    public function getPosicion()
    {
        return $this->posicion;
    }
}
