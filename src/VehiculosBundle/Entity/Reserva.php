<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Usuario;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Reserva
 *
 * @ORM\Entity
 * @ORM\Table(name="vehiculo_reserva")
 * @ORM\Entity(repositoryClass="VehiculosBundle\Repository\ReservaRepository")
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
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ReservaVehiculos", mappedBy="reserva", cascade={"persist","remove"})
     */
    private $vehiculos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="datetime", nullable=false)
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="datetime", nullable=false)
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     * @Assert\Expression(
     *     "this.getFechaFin() >= this.getFechaInicio()",
     *     message="Este campo debe ser igual o mayor a la fecha de inicio de la reserva.")
     */
    private $fechaFin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=false)
     */
   // private $estado;

    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="HistoricoEstadosReserva", mappedBy="reserva")
     */
    private $historicosEstadosReserva;

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
     * @var string
     *
     * @ORM\Column(name="motivo", type="text", nullable=true)
     * @Assert\Valid
     */
    private $motivo;

    /**
     * Indica cuando la reserva fue creada.
     *
     * @var DateTime
     *
     * @ORM\Column(name="fecha_alta", type="datetime", nullable=true)
     */
    protected $fechaAlta;

    /**
     *
     * @var AppBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_alta_id", referencedColumnName="id")
     */
    private $usuarioAlta;

    /**
    * Indica cuando la reserva fue dada de baja (baja logica).
    *
    * @var DateTime
     *
     * @ORM\Column(name="fecha_baja", type="datetime", nullable=true)
     */
    protected $fechaBaja;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_proyecto", type="text", nullable=true)
     * @Assert\Valid
     */
    private $tipoProyecto;


    public function __construct()
    {
        $this->vehiculos = new ArrayCollection;
        $this->historicosEstadosReserva = new ArrayCollection;
    }

    public function __toString(){
        return 'Reserva #' . $this->id;
    }

    public function getListadoVehiculos(){
        return implode(', ', $this->vehiculos->toArray());
    }

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
     * Set motivo
     *
     * @param string $motivo
     *
     * @return Reserva
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }



    /**
     * Set tipoProyecto
     *
     * @param string $motivo
     *
     * @return Reserva
     */
    public function setTipoProyecto($tipoProyecto)
    {
        $this->tipoProyecto = $tipoProyecto;

        return $this;
    }

    /**
     * Get tipoProyecto
     *
     * @return string
     */
    public function getTipoProyecto()
    {
        return $this->tipoProyecto;
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
     * Get vehiculos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehiculos()
    {
        return $this->vehiculos;
    }

    /**
     *
     * @param ArrayCollection $vehiculos
     * @return $this
     */
    public function setVehiculos(ArrayCollection $vehiculos) {
        $this->vehiculos = $vehiculos;
        return $this;
    }


    /**
     * @return DateTime
     */
    public function getFechaBaja(): DateTime
    {
        return $this->fechaBaja;
    }

    /**
     * @param DateTime $fechaBaja
     * @return Reserva
     */
    public function setFechaBaja(\DateTime $fechaBaja): Reserva
    {
        $this->fechaBaja = $fechaBaja;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * @param DateTime $fechaAlta
     * @return Reserva
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;
        return $this;
    }

    /**
     * @return Usuario
     */
    public function getUsuarioAlta()
    {
        return $this->usuarioAlta;
    }

    /**
     * @param Usuario $usuarioAlta
     * @return Reserva
     */
    public function setUsuarioAlta(Usuario $usuarioAlta): Reserva
    {
        $this->usuarioAlta = $usuarioAlta;
        return $this;
    }

    public function esNueva() {
        return $this->isEstado(EstadoReserva::NUEVA);
    }

   /* public function enRevision() {
        return $this->isEstado(Estado::REVISION);
    }

    public function enCorreccion() {
        return $this->isEstado(Estado::CORRECCION);
    }

    public function isPublicada() {
        return $this->isEstado(Estado::PUBLICADA);
    }*/


    /**
     * Funcion auxiliar que compara el estado actual de la planificacion con el codigo pasado como argumento.
     *
     * @param int $cod
     * @return boolean
     */
    private function isEstado($cod) {
        $hea = $this->getHistoricoEstadoActual();
        if ($hea instanceof HistoricoEstadosReserva) {
            return $this->getEstadoActual()->getCodigo() == $cod;
        }
        return false;
    }

     /**
     * Devuelve el historico que contiene la informacion sobre el estado actual.
     *
     * @return HistoricoEstadosReserva|null
     */
    public function getHistoricoEstadoActual() {
        $res = null;
        foreach ($this->historicosEstadosReserva as $historico) {
            if ($historico->getFechaHasta() == null) {
                $res = $historico;
                break;
            }
        }

        return $res;
    }


    /**
     * Devuelve un texto indicando el estado actual
     */
    public function getEstadoActual() {
        $hea = $this->getHistoricoEstadoActual();
        if ($hea) {
            return $hea->getEstado();
        }

        return null;
    }


    /**
     * Add vehiculo
     *
     * @param \VehiculosBundle\Entity\ReservaVehiculos $vehiculo
     *
     * @return Reserva
     */
    public function addVehiculo(\VehiculosBundle\Entity\ReservaVehiculos $vehiculo)
    {
        $vehiculo->setReserva($this);

        $this->vehiculos[] = $vehiculo;

        return $this;
    }

    /**
     * Remove vehiculo
     *
     * @param \VehiculosBundle\Entity\ReservaVehiculos $vehiculo
     */
    public function removeVehiculo(\VehiculosBundle\Entity\ReservaVehiculos $vehiculo)
    {
        $this->vehiculos->removeElement($vehiculo);
    }

    /**
     * Add historicosEstadosReserva
     *
     * @param \VehiculosBundle\Entity\HistoricoEstadosReserva $historicosEstadosReserva
     *
     * @return Reserva
     */
    public function addHistoricosEstadosReserva(\VehiculosBundle\Entity\HistoricoEstadosReserva $historicosEstadosReserva)
    {
        $historicosEstadosReserva->setReserva($this);

        $this->historicosEstadosReserva[] = $historicosEstadosReserva;

        return $this;
    }

    /**
     * Remove historicosEstadosReserva
     *
     * @param \VehiculosBundle\Entity\HistoricoEstadosReserva $historicosEstadosReserva
     */
    public function removeHistoricosEstadosReserva(\VehiculosBundle\Entity\HistoricoEstadosReserva $historicosEstadosReserva)
    {
        $this->historicosEstadosReserva->removeElement($historicosEstadosReserva);
    }

    /**
     * Get historicosEstadosReserva
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistoricosEstadosReserva()
    {
        return $this->historicosEstadosReserva;
    }
}
