<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoricoEstadosReserva
 *
 * @ORM\Table(name="vehiculo_historico_estados_reserva", uniqueConstraints={
 *        @ORM\UniqueConstraint(name="ak_historico_estados", 
 *            columns={"reserva_id", "reserva_estado_id", "fecha_desde"})
 *    })
 * @ORM\Entity(repositoryClass="VehiculosBundle\Repository\HistoricoEstadosReservaRepository")
 */


class HistoricoEstadosReserva implements \JsonSerializable
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_desde", type="datetime")
     */
    private $fechaDesde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hasta", type="datetime", nullable=true)
     */
    private $fechaHasta;
    
    /**
     *
     * @var EstadoReserva
     * 
     * @ORM\ManyToOne(targetEntity="EstadoReserva")
     * @ORM\JoinColumn(name="reserva_estado_id", referencedColumnName="id") 
     */
    private $estado;
    
    
    /**
     *
     * @var Reserva
     * 
     * @ORM\ManyToOne(targetEntity="Reserva", inversedBy="historicosEstado")
     * @ORM\JoinColumn(name="reserva_id", referencedColumnName="id") 
     */
    private $reserva;
    
    
    /**
     * 
     * @var AppBundle\Entity\Usuario
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;
    
    /**
     * 
     * @var string
     *      
     * @ORM\Column(name="comentario", type="string", nullable=true)
     */
    private $comentario;
    
    
    public function __construct() {
        $this->fechaDesde = new \DateTime();
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
     * Set fechaDesde
     *
     * @param \DateTime $fechaDesde
     *
     * @return HistoricoEstadosReserva
     */
    public function setFechaDesde($fechaDesde)
    {
        $this->fechaDesde = $fechaDesde;

        return $this;
    }

    /**
     * Get fechaDesde
     *
     * @return \DateTime
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * Set fechaHasta
     *
     * @param \DateTime $fechaHasta
     *
     * @return HistoricoEstadosReserva
     */
    public function setFechaHasta($fechaHasta)
    {
        $this->fechaHasta = $fechaHasta;

        return $this;
    }

    /**
     * Get fechaHasta
     *
     * @return \DateTime
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * Set estado
     *
     * @param \VehiculosBundle\Entity\EstadoReserva $estado
     *
     * @return HistoricoEstadosReserva
     */
    public function setEstado(\VehiculosBundle\Entity\EstadoReserva $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \VehiculosBundle\Entity\EstadoReserva
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set reserva
     *
     * @param \VehiculosBundle\Entity\Reserva $reserva
     *
     * @return HistoricoEstadosReserva
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
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return HistoricoEstadosReserva
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    public function getComentario() {
        return $this->comentario;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
        return $this;
    }

    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'fechaDesde' => $this->fechaDesde->getTimestamp(),
            'fechaHasta' => $this->fechaHasta ? $this->fechaHasta->getTimestamp() : null,
            'estado' => $this->estado,
            'comentario' => $this->comentario,
            'usuario' => $this->usuario
        );
    }
}

