<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reserva
 *
 * @ORM\Entity
 * @ORM\Table(name="Reserva")
 * 
 */

class Reserva
{ 
     /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DocentesBundle\Entity\DocenteGrado
     *
     * @ORM\ManyToOne(targetEntity="\DocentesBundle\Entity\DocenteGrado", inversedBy="docente")
     * @ORM\JoinColumn(name="docente_id", referencedColumnName="id")
     */
    private $docente;

    /**
     * @var \VehiculosBundle\Entity\Vehiculo
     *
     * @ORM\ManyToOne(targetEntity="\VehiculosBundle\Entity\Vehiculo", inversedBy="vehiculo")
     * @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id")
     */
    private $vehiculo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=false)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="date", nullable=false)
     */
    private $fechaFin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_personas", type="integer", nullable=false)
     */
    private $cantidadPersonas;

    /**
     * @var string
     *
     * @ORM\Column(name="elementos_extras", type="text", nullable=true)
     * @Assert\Valid
     */
    private $elementosExtras;




    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return Reserva
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return Reserva
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Reserva
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set cantidadPersonas
     *
     * @param integer $cantidadPersonas
     *
     * @return Reserva
     */
    public function setCantidadPersonas($cantidadPersonas)
    {
        $this->cantidadPersonas = $cantidadPersonas;

        return $this;
    }

    /**
     * Get cantidadPersonas
     *
     * @return integer
     */
    public function getCantidadPersonas()
    {
        return $this->cantidadPersonas;
    }

    /**
     * Set elementosExtras
     *
     * @param string $elementosExtras
     *
     * @return Reserva
     */
    public function setElementosExtras($elementosExtras)
    {
        $this->elementosExtras = $elementosExtras;

        return $this;
    }

    /**
     * Get elementosExtras
     *
     * @return string
     */
    public function getElementosExtras()
    {
        return $this->elementosExtras;
    }

    /**
     * Set docente
     *
     * @param \DocentesBundle\Entity\DocenteGrado $docente
     *
     * @return Reserva
     */
    public function setDocente(\DocentesBundle\Entity\DocenteGrado $docente = null)
    {
        $this->docente = $docente;

        return $this;
    }

    /**
     * Get docente
     *
     * @return \DocentesBundle\Entity\DocenteGrado
     */
    public function getDocente()
    {
        return $this->docente;
    }

    /**
     * Set vehiculo
     *
     * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
     *
     * @return Reserva
     */
    public function setVehiculo(\VehiculosBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \VehiculosBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
