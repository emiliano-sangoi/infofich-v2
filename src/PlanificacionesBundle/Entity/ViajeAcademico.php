<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ViajeAcademico
 *
 * @ORM\Table(name="planif_viajes_academicos")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\ViajeAcademicoRepository")
 */
class ViajeAcademico {

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
     * @ORM\Column(name="descripcion", type="text")
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivos", type="text")
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $objetivos;

    /**
     * @var string
     *
     * @ORM\Column(name="recorrido", type="text")
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $recorrido;

    /**
     * @var int
     *
     * @ORM\Column(name="cant_estudiantes", type="smallint")
     * @Assert\Type(
     *     type="int",
     *     message="Este campo debe ser un número entero")
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $cantEstudiantes;

    /**
     * @var int
     *
     * @ORM\Column(name="cant_docentes", type="smallint")
     * @Assert\Type(
     *     type="int",
     *     message="Este campo  debe ser un número entero")
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $cantDocentes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_tentativa", type="datetime")     
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     */
    private $fechaTentativa;

    /**
     * @var int
     *
     * @ORM\Column(name="cant_dias", type="smallint")
     * @Assert\Type(
     *     type="int",
     *     message="Este campo debe ser un número entero")
     */
    private $cantDias;

    /**
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="viajesAcademicos")
     * @ORM\JoinColumn(name="planif_planificaciones_id", referencedColumnName="id") 
     */
    private $planificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="asignaturas", type="text")
     */
    private $asignaturas;

    /**
     * @var Vehiculo
     * 
     * @ORM\ManyToOne(targetEntity="Vehiculo")
     * @ORM\JoinColumn(name="planif_vehiculo_id", referencedColumnName="id") 
     */
    private $vehiculo;

    /**
     * @ORM\Column(name="posicion", type="integer")
     */
    private $posicion;

    public function __construct() {
        $this->asignaturas = new ArrayCollection;
        $this->cantDocentes = 0;
        $this->cantEstudiantes = 0;
        //$this->vehiculos = new ArrayCollection;
    }
    
    public function getTotalPasajeros(){
        return $this->cantDocentes + $this->cantEstudiantes;
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return ViajeAcademico
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Set objetivos
     *
     * @param string $objetivos
     *
     * @return ViajeAcademico
     */
    public function setObjetivos($objetivos) {
        $this->objetivos = $objetivos;

        return $this;
    }

    /**
     * Get objetivos
     *
     * @return string
     */
    public function getObjetivos() {
        return $this->objetivos;
    }

    /**
     * Set recorrido
     *
     * @param string $recorrido
     *
     * @return ViajeAcademico
     */
    public function setRecorrido($recorrido) {
        $this->recorrido = $recorrido;

        return $this;
    }

    /**
     * Get recorrido
     *
     * @return string
     */
    public function getRecorrido() {
        return $this->recorrido;
    }

    /**
     * Set cantEstudiantes
     *
     * @param integer $cantEstudiantes
     *
     * @return ViajeAcademico
     */
    public function setCantEstudiantes($cantEstudiantes) {
        $this->cantEstudiantes = $cantEstudiantes;

        return $this;
    }

    /**
     * Get cantEstudiantes
     *
     * @return int
     */
    public function getCantEstudiantes() {
        return $this->cantEstudiantes;
    }

    /**
     * Set cantDocentes
     *
     * @param integer $cantDocentes
     *
     * @return ViajeAcademico
     */
    public function setCantDocentes($cantDocentes) {
        $this->cantDocentes = $cantDocentes;

        return $this;
    }

    /**
     * Get cantDocentes
     *
     * @return int
     */
    public function getCantDocentes() {
        return $this->cantDocentes;
    }

    /**
     * Set fechaTentativa
     *
     * @param \DateTime $fechaTentativa
     *
     * @return ViajeAcademico
     */
    public function setFechaTentativa($fechaTentativa) {
        $this->fechaTentativa = $fechaTentativa;

        return $this;
    }

    /**
     * Get fechaTentativa
     *
     * @return \DateTime
     */
    public function getFechaTentativa() {
        return $this->fechaTentativa;
    }

    /**
     * Set cantDias
     *
     * @param integer $cantDias
     *
     * @return ViajeAcademico
     */
    public function setCantDias($cantDias) {
        $this->cantDias = $cantDias;

        return $this;
    }

    /**
     * Get cantDias
     *
     * @return int
     */
    public function getCantDias() {
        return $this->cantDias;
    }

    /**
     * Set asignaturas
     *
     * @param string $asignaturas
     *
     * @return ViajeAcademico
     */
    public function setAsignaturas($asignaturas) {
        $this->asignaturas = $asignaturas;

        return $this;
    }

    /**
     * Get asignaturas
     *
     * @return string
     */
    public function getAsignaturas() {
        return $this->asignaturas;
    }

    /**
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return ViajeAcademico
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
     * Set vehiculo
     *
     * @param \PlanificacionesBundle\Entity\Vehiculo $vehiculo
     *
     * @return ViajeAcademico
     */
    public function setVehiculo(\PlanificacionesBundle\Entity\Vehiculo $vehiculo = null) {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \PlanificacionesBundle\Entity\Vehiculo
     */
    public function getVehiculo() {
        return $this->vehiculo;
    }


    /**
     * Set posicion
     *
     * @param integer $posicion
     *
     * @return ViajeAcademico
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
