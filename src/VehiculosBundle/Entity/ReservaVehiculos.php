<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reserva
 *
 * @ORM\Table(name="vehiculo_reserva_vehiculos")
 * @ORM\Entity(repositoryClass="VehiculosBundle\Repository\ReservaVehiculosRepository")
 */
class ReservaVehiculos {

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
     * @var Reserva
     *
     * @ORM\ManyToOne(targetEntity="Reserva", inversedBy="vehiculos")
     * @ORM\JoinColumn(name="reserva_id", referencedColumnName="id", nullable=false)
     */
    private $reserva;

    /**
     *
     * @var Vehiculo
     *
     * @ORM\ManyToOne(targetEntity="Vehiculo", inversedBy="reservaVehiculos")
     * @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id", nullable=false)
     */
    private $vehiculo;

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
        return $this->vehiculo->getMarca();
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
     * @return ReservaVehiculos
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
     * Set reserva
     *
     * @param \VehiculosBundle\Entity\Reserva Reserva
     *
     * @return ReservaVehiculos
     */
    public function setReserva(\VehiculosBundle\Entity\Reserva $reserva = null)
    {
        $this->reserva = $reserva;

        return $this;
    }

    /**
     * Get reserva
     *
     * @return \VehiculosBundle\Entity\Reserva
     */
    public function getReserva()
    {
        return $this->reserva;
    }

    /**
     * Set vehiculo
     *
     * @param Vehiculo $vehiculo
     *
     * @return ReservaVehiculos
     */
    public function setVehiculo(Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
