<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vehiculo
 * 
 * Transportes que pueden ser utilizados en los viajes academicos.
 *
 * @ORM\Table(name="planif_vehiculos")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\VehiculosRepository")
 */
class Vehiculo
{
    const AUTO = 'Automovil';
    const COLECTIVO = 'Colectivo';
    const AVION = 'Avion';
    const EMBARCACION1 = 'Embarcación Azimut';
    const EMBARCACION2 = 'Gomón FICH-1';
    const EMBARCACION3 = 'Embarcación pequeña FICH-2';
    
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
     * @ORM\Column(name="nombre", type="string", length=64, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=512, nullable=true)
     */
    private $descripcion;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoMovilidad
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
     * @return TipoMovilidad
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
    
    public function __toString() {
        return $this->nombre;
    }
}
