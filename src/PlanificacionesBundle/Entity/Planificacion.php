<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Planificacion
 *
 * @ORM\Table(name="planif_planificaciones")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\PlanificacionRepository")
 */
class Planificacion
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
     * @var int
     *
     * @ORM\Column(name="anio_acad", type="smallint")
     * 
     */
    private $anioAcad;

    /**
     * @var string
     *
     * @ORM\Column(name="contenidos_minimos", type="text", nullable=true)
     * @Assert\NotBlank(message="Este campo no puede quedar vacío")
     */
    private $contenidosMinimos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fechaCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivos_gral", type="text", nullable=true)
     */
    private $objetivosGral;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivos_especificos", type="text", nullable=true)
     */
    private $objetivosEspecificos;
    
    /**
     *
     * @var Departamento
     * 
     * @ORM\ManyToOne(targetEntity="Departamento")
     * @ORM\JoinColumn(name="planif_departamentos_id",referencedColumnName="id")
     */
    private $departamento;
    
    /**
     *
     * @var Asignatura
     * 
     * @ORM\Column(name="carrera", type="string", length=4)
     * @Assert\NotBlank(message="El campo Carrera es obligatorio")
     */
    private $carrera;
    
    /**
     * Plan al que pertenece la carrera.
     *      
     * @var int
     * 
     * @ORM\Column(name="plan", type="integer")
     */
    private $plan;
    
    /**
     * Plan al que pertenece la carrera.
     *      
     * @var int
     * 
     * @ORM\Column(name="version_plan", type="integer")
     */
    private $versionPlan;
    
    /**
     *
     * @var Asignatura
     * 
     * @ORM\Column(name="asignatura", type="string", length=12)
     * @Assert\NotBlank(message="El campo Asignatura es obligatorio")
     */
    private $asignatura;
    
        
    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="DocentePlanificacion", mappedBy="planificacion")
     */
    private $docentesPlanificacion;
    
    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="HistoricoEstados", mappedBy="planificacion")
     */
    private $historicosEstado;
    
    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="ActividadCurricular", mappedBy="planificacion") 
     */
    private $actividadesCurriculares;
    
    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="BibliografiaPlanificacion", mappedBy="planificacion") 
     */
    private $bibliografiasPlanificacion;
    
    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Planificacion", mappedBy="planificacion")
     */
    private $viajesAcademicos;
    
    /**
     *
     * @var CargaHoraria
     * 
     * @ORM\OneToOne(targetEntity="CargaHoraria", mappedBy="planificacion")
     */
    private $cargaHoraria;
    
    /**
     *
     * @var RequisitosAprobacion
     * 
     * @ORM\OneToOne(targetEntity="RequisitosAprobacion", mappedBy="planificacion")
     */
    private $requisitosAprobacion;
    
    
    public function __construct() {
        $this->docentesPlanificacion = new ArrayCollection;
        $this->historicosEstado = new ArrayCollection;
        $this->actividadesCurriculares = new ArrayCollection;
        $this->bibliografiasPlanificacion = new ArrayCollection;
        $this->viajesAcademicos = new ArrayCollection;
        
        $this->fechaCreacion = new \DateTime;
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
     * Set anioAcad
     *
     * @param integer $anioAcad
     *
     * @return Planificacion
     */
    public function setAnioAcad($anioAcad)
    {
        $this->anioAcad = $anioAcad;

        return $this;
    }

    /**
     * Get anioAcad
     *
     * @return int
     */
    public function getAnioAcad()
    {
        return $this->anioAcad;
    }

    /**
     * Set contenidosMinimos
     *
     * @param string $contenidosMinimos
     *
     * @return Planificacion
     */
    public function setContenidosMinimos($contenidosMinimos)
    {
        $this->contenidosMinimos = $contenidosMinimos;

        return $this;
    }

    /**
     * Get contenidosMinimos
     *
     * @return string
     */
    public function getContenidosMinimos()
    {
        return $this->contenidosMinimos;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Planificacion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set objetivosGral
     *
     * @param string $objetivosGral
     *
     * @return Planificacion
     */
    public function setObjetivosGral($objetivosGral)
    {
        $this->objetivosGral = $objetivosGral;

        return $this;
    }

    /**
     * Get objetivosGral
     *
     * @return string
     */
    public function getObjetivosGral()
    {
        return $this->objetivosGral;
    }

    /**
     * Set objetivosEspecificos
     *
     * @param string $objetivosEspecificos
     *
     * @return Planificacion
     */
    public function setObjetivosEspecificos($objetivosEspecificos)
    {
        $this->objetivosEspecificos = $objetivosEspecificos;

        return $this;
    }

    /**
     * Get objetivosEspecificos
     *
     * @return string
     */
    public function getObjetivosEspecificos()
    {
        return $this->objetivosEspecificos;
    }

    /**
     * Set departamento
     *
     * @param \PlanificacionesBundle\Entity\Departamento $departamento
     *
     * @return Planificacion
     */
    public function setDepartamento(\PlanificacionesBundle\Entity\Departamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \PlanificacionesBundle\Entity\Departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Add docentesPlanificacion
     *
     * @param \PlanificacionesBundle\Entity\DocentePlanificacion $docentesPlanificacion
     *
     * @return Planificacion
     */
    public function addDocentesPlanificacion(\PlanificacionesBundle\Entity\DocentePlanificacion $docentesPlanificacion)
    {
        $this->docentesPlanificacion[] = $docentesPlanificacion;

        return $this;
    }

    /**
     * Remove docentesPlanificacion
     *
     * @param \PlanificacionesBundle\Entity\DocentePlanificacion $docentesPlanificacion
     */
    public function removeDocentesPlanificacion(\PlanificacionesBundle\Entity\DocentePlanificacion $docentesPlanificacion)
    {
        $this->docentesPlanificacion->removeElement($docentesPlanificacion);
    }

    /**
     * Get docentesPlanificacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocentesPlanificacion()
    {
        return $this->docentesPlanificacion;
    }


    /**
     * Add historicosEstado
     *
     * @param \PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado
     *
     * @return Planificacion
     */
    public function addHistoricosEstado(\PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado)
    {
        $this->historicosEstado[] = $historicosEstado;

        return $this;
    }

    /**
     * Remove historicosEstado
     *
     * @param \PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado
     */
    public function removeHistoricosEstado(\PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado)
    {
        $this->historicosEstado->removeElement($historicosEstado);
    }

    /**
     * Get historicosEstado
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistoricosEstado()
    {
        return $this->historicosEstado;
    }

    /**
     * Add actividadesCurriculare
     *
     * @param \PlanificacionesBundle\Entity\ActividadCurricular $actividadesCurriculare
     *
     * @return Planificacion
     */
    public function addActividadesCurriculare(\PlanificacionesBundle\Entity\ActividadCurricular $actividadesCurriculare)
    {
        $this->actividadesCurriculares[] = $actividadesCurriculare;

        return $this;
    }

    /**
     * Remove actividadesCurriculare
     *
     * @param \PlanificacionesBundle\Entity\ActividadCurricular $actividadesCurriculare
     */
    public function removeActividadesCurriculare(\PlanificacionesBundle\Entity\ActividadCurricular $actividadesCurriculare)
    {
        $this->actividadesCurriculares->removeElement($actividadesCurriculare);
    }

    /**
     * Get actividadesCurriculares
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActividadesCurriculares()
    {
        return $this->actividadesCurriculares;
    }

    /**
     * Add bibliografiasPlanificacion
     *
     * @param \PlanificacionesBundle\Entity\BibliografiaPlanificacion $bibliografiasPlanificacion
     *
     * @return Planificacion
     */
    public function addBibliografiasPlanificacion(\PlanificacionesBundle\Entity\BibliografiaPlanificacion $bibliografiasPlanificacion)
    {
        $this->bibliografiasPlanificacion[] = $bibliografiasPlanificacion;

        return $this;
    }

    /**
     * Remove bibliografiasPlanificacion
     *
     * @param \PlanificacionesBundle\Entity\BibliografiaPlanificacion $bibliografiasPlanificacion
     */
    public function removeBibliografiasPlanificacion(\PlanificacionesBundle\Entity\BibliografiaPlanificacion $bibliografiasPlanificacion)
    {
        $this->bibliografiasPlanificacion->removeElement($bibliografiasPlanificacion);
    }

    /**
     * Get bibliografiasPlanificacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBibliografiasPlanificacion()
    {
        return $this->bibliografiasPlanificacion;
    }

    /**
     * Add viajesAcademico
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $viajesAcademico
     *
     * @return Planificacion
     */
    public function addViajesAcademico(\PlanificacionesBundle\Entity\Planificacion $viajesAcademico)
    {
        $this->viajesAcademicos[] = $viajesAcademico;

        return $this;
    }

    /**
     * Remove viajesAcademico
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $viajesAcademico
     */
    public function removeViajesAcademico(\PlanificacionesBundle\Entity\Planificacion $viajesAcademico)
    {
        $this->viajesAcademicos->removeElement($viajesAcademico);
    }

    /**
     * Get viajesAcademicos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getViajesAcademicos()
    {
        return $this->viajesAcademicos;
    }

    /**
     * Set cargaHoraria
     *
     * @param \PlanificacionesBundle\Entity\CargaHoraria $cargaHoraria
     *
     * @return Planificacion
     */
    public function setCargaHoraria(\PlanificacionesBundle\Entity\CargaHoraria $cargaHoraria = null)
    {
        $this->cargaHoraria = $cargaHoraria;

        return $this;
    }

    /**
     * Get cargaHoraria
     *
     * @return \PlanificacionesBundle\Entity\CargaHoraria
     */
    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    /**
     * Set requisitosAprobacion
     *
     * @param \PlanificacionesBundle\Entity\RequisitosAprobacion $requisitosAprobacion
     *
     * @return Planificacion
     */
    public function setRequisitosAprobacion(\PlanificacionesBundle\Entity\RequisitosAprobacion $requisitosAprobacion = null)
    {
        $this->requisitosAprobacion = $requisitosAprobacion;

        return $this;
    }

    /**
     * Get requisitosAprobacion
     *
     * @return \PlanificacionesBundle\Entity\RequisitosAprobacion
     */
    public function getRequisitosAprobacion()
    {
        return $this->requisitosAprobacion;
    }

    /**
     * Set carrera
     *
     * @param string $carrera
     *
     * @return Planificacion
     */
    public function setCarrera($carrera)
    {
        $this->carrera = $carrera;

        return $this;
    }

    /**
     * Get carrera
     *
     * @return string
     */
    public function getCarrera()
    {
        return $this->carrera;
    }

    /**
     * Set plan
     *
     * @param integer $plan
     *
     * @return Planificacion
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return integer
     */
    public function getPlan()
    {
        return $this->plan;
    }



    /**
     * Set versionPlan
     *
     * @param integer $versionPlan
     *
     * @return Planificacion
     */
    public function setVersionPlan($versionPlan)
    {
        $this->versionPlan = $versionPlan;

        return $this;
    }

    /**
     * Get versionPlan
     *
     * @return integer
     */
    public function getVersionPlan()
    {
        return $this->versionPlan;
    }

    /**
     * Set asignatura
     *
     * @param string $asignatura
     *
     * @return Planificacion
     */
    public function setAsignatura($asignatura)
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    /**
     * Get asignatura
     *
     * @return string
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }
}
