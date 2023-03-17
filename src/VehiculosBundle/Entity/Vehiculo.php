<?php

namespace VehiculosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="vehiculo_vehiculo")
 * @ORM\Entity(repositoryClass="VehiculosBundle\Repository\VehiculoRepository")
 */
class Vehiculo
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var tipo
     *
     * @ORM\ManyToOne(targetEntity="TipoVehiculo")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id", nullable=true)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $patente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     *
     * @var vehiculo
     *
     * @ORM\ManyToOne(targetEntity="Vehiculo")
     * @ORM\JoinColumn(name="asociado_id", referencedColumnName="id", nullable=true)
     */
    private $asociado;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $combustible;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $marca;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $modelo;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacidad;

    /**
     * @ORM\Column(type="string")
     */
    private $color;

    /**
     * @ORM\Column(type="string")
     */
    private $chasisCasco;

    /**
     * Indica cuando el vehiculo fue dado de baja (baja logica).
     *
     * @var DateTime
     *
     * @ORM\Column(name="fecha_baja", type="datetime", nullable=true)
     */
    protected $fechaBaja;

    /**
     * @var boolean
     *
     * @ORM\Column(name="habilitado", type="boolean", nullable=true)
     */
    protected $habilitado;


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
     * Set tipo
     *
     * @param \VehiculosBundle\Entity\TipoVehiculo $tipo
     *
     * @return Vehiculo
     */
    public function setTipo(\VehiculosBundle\Entity\TipoVehiculo $tipo = null) {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \VehiculosBundle\Entity\TipoVehiculo
     */
    public function getTipo() {
        return $this->tipo;
    }


    /**
     * Set patente
     *
     * @param string $patente
     *
     * @return Vehiculo
     */
    public function setPatente($patente)
    {
        $this->patente = $patente;

        return $this;
    }

    /**
     * Get patente
     *
     * @return string
     */
    public function getPatente()
    {
        return $this->patente;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Vehiculo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set asociado
     *
     * @param integer $asociado
     *
     * @return Vehiculo
     */
    public function setAsociado($asociado)
    {
        $this->asociado = $asociado;

        return $this;
    }

    /**
     * Get asociado
     *
     * @return integer
     */
    public function getAsociado()
    {
        return $this->asociado;
    }

    /**
     * Set combustible
     *
     * @param string $combustible
     *
     * @return Vehiculo
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;

        return $this;
    }

    /**
     * Get combustible
     *
     * @return string
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return Vehiculo
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modelo
     *
     * @param \DateTime $modelo
     *
     * @return Vehiculo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return \DateTime
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set capacidad
     *
     * @param integer $capacidad
     *
     * @return Vehiculo
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }


    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Vehiculo
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get chasisCasco
     *
     * @return string
     */
    public function getChasisCasco()
    {
        return $this->chasisCasco;
    }

    /**
     * Set chasisCasco
     *
     * @param string $chasisCasco
     *
     * @return Vehiculo
     */
    public function setChasisCasco($chasisCasco)
    {
        $this->chasisCasco = $chasisCasco;

        return $this;
    }

     /**
     * @return DateTime
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    /**
     * @param DateTime $fechaBaja
     * @return Vehiculo
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;
        return $this;
    }


    /**
     * @return bool
     */
    public function isHabilitado()
    {
        return $this->habilitado;
    }

    /**
     * @param bool $habilitado
     * @return Vehiculo
     */
    public function setHabilitado(bool $habilitado)
    {
        $this->habilitado = $habilitado;
        return $this;
    }

    public function __construct()
    {
        $this->habilitado = true;
    }

    public function __toString() {
        return $this->descripcion;
    }
}
