<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ViajeAcademico
 *
 * @ORM\Table(name="planif_viajes_academicos")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\ViajeAcademicoRepository")
 */
class ViajeAcademico
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivos", type="text")
     */
    private $objetivos;

    /**
     * @var string
     *
     * @ORM\Column(name="recorrido", type="text")
     */
    private $recorrido;

    /**
     * @var int
     *
     * @ORM\Column(name="cant_estudiantes", type="smallint")
     */
    private $cantEstudiantes;

    /**
     * @var int
     *
     * @ORM\Column(name="cant_docentes", type="smallint")
     */
    private $cantDocentes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_tentativa", type="datetime")
     */
    private $fechaTentativa;

    /**
     * @var int
     *
     * @ORM\Column(name="cant_dias", type="smallint")
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
     *
     * @var Asignatura
     * 
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Asignatura")
     * @ORM\JoinTable(name="planif_asignaturas_viajes_academicos",
     *      joinColumns={@ORM\JoinColumn(name="planif_viajes_academicos_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="planif_asignaturas_id", referencedColumnName="id")}
     * )
     */
    private $asignaturas;
    
    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Vehiculo")
     * @ORM\JoinTable(
     *      name="planif_viajes_academicos_vehiculos",
     *      joinColumns={
     *          @ORM\JoinColumn(name="planif_viajes_academicos_id", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="planif_transportes_id", referencedColumnName="id")
     *      }
     * 
     * )
     */
    private $vehiculos;
    

    public function __construct() {
        $this->asignaturas = new ArrayCollection;
        $this->vehiculos = new ArrayCollection;
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return ViajeAcademico
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
     * Set objetivos
     *
     * @param string $objetivos
     *
     * @return ViajeAcademico
     */
    public function setObjetivos($objetivos)
    {
        $this->objetivos = $objetivos;

        return $this;
    }

    /**
     * Get objetivos
     *
     * @return string
     */
    public function getObjetivos()
    {
        return $this->objetivos;
    }

    /**
     * Set recorrido
     *
     * @param string $recorrido
     *
     * @return ViajeAcademico
     */
    public function setRecorrido($recorrido)
    {
        $this->recorrido = $recorrido;

        return $this;
    }

    /**
     * Get recorrido
     *
     * @return string
     */
    public function getRecorrido()
    {
        return $this->recorrido;
    }

    /**
     * Set cantEstudiantes
     *
     * @param integer $cantEstudiantes
     *
     * @return ViajeAcademico
     */
    public function setCantEstudiantes($cantEstudiantes)
    {
        $this->cantEstudiantes = $cantEstudiantes;

        return $this;
    }

    /**
     * Get cantEstudiantes
     *
     * @return int
     */
    public function getCantEstudiantes()
    {
        return $this->cantEstudiantes;
    }

    /**
     * Set cantDocentes
     *
     * @param integer $cantDocentes
     *
     * @return ViajeAcademico
     */
    public function setCantDocentes($cantDocentes)
    {
        $this->cantDocentes = $cantDocentes;

        return $this;
    }

    /**
     * Get cantDocentes
     *
     * @return int
     */
    public function getCantDocentes()
    {
        return $this->cantDocentes;
    }

    /**
     * Set fechaTentativa
     *
     * @param \DateTime $fechaTentativa
     *
     * @return ViajeAcademico
     */
    public function setFechaTentativa($fechaTentativa)
    {
        $this->fechaTentativa = $fechaTentativa;

        return $this;
    }

    /**
     * Get fechaTentativa
     *
     * @return \DateTime
     */
    public function getFechaTentativa()
    {
        return $this->fechaTentativa;
    }

    /**
     * Set cantDias
     *
     * @param integer $cantDias
     *
     * @return ViajeAcademico
     */
    public function setCantDias($cantDias)
    {
        $this->cantDias = $cantDias;

        return $this;
    }

    /**
     * Get cantDias
     *
     * @return int
     */
    public function getCantDias()
    {
        return $this->cantDias;
    }

    /**
     * Add asignatura
     *
     * @param \PlanificacionesBundle\Entity\Asignatura $asignatura
     *
     * @return ViajeAcademico
     */
    public function addAsignatura(\PlanificacionesBundle\Entity\Asignatura $asignatura)
    {
        $this->asignaturas[] = $asignatura;

        return $this;
    }

    /**
     * Remove asignatura
     *
     * @param \PlanificacionesBundle\Entity\Asignatura $asignatura
     */
    public function removeAsignatura(\PlanificacionesBundle\Entity\Asignatura $asignatura)
    {
        $this->asignaturas->removeElement($asignatura);
    }

    /**
     * Get asignaturas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAsignaturas()
    {
        return $this->asignaturas;
    }

    /**
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return ViajeAcademico
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
     * Add vehiculo
     *
     * @param \PlanificacionesBundle\Entity\Vehiculo $vehiculo
     *
     * @return ViajeAcademico
     */
    public function addVehiculo(\PlanificacionesBundle\Entity\Vehiculo $vehiculo)
    {
        $this->vehiculos[] = $vehiculo;

        return $this;
    }

    /**
     * Remove vehiculo
     *
     * @param \PlanificacionesBundle\Entity\Vehiculo $vehiculo
     */
    public function removeVehiculo(\PlanificacionesBundle\Entity\Vehiculo $vehiculo)
    {
        $this->vehiculos->removeElement($vehiculo);
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
}
