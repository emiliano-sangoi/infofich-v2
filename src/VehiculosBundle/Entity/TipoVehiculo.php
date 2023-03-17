<?php

namespace VehiculosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="vehiculo_tipo")
 * @ORM\Entity(repositoryClass="VehiculosBundle\Repository\TipoVehiculoRepository")
 */
class TipoVehiculo
{

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max = 255, maxMessage = "La descripción no puede superar los {{ limit }} caracteres.")
     */
    private $descripcion;

    /**
     * Indica cuando el tipo de vehiculo fue dado de baja (baja logica).
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoVehiculo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TipoVehiculo
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
     * @return DateTime
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    /**
     * @param DateTime $fechaBaja
     * @return TipoVehiculo
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
     * @return TipoVehiculo
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

    public function __toString()
    {
        return $this->nombre;
    }
}
