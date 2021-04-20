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
class Planificacion {

    const PERMISO_LISTAR = 1;
    const PERMISO_CREAR = 2;
    const PERMISO_EDITAR = 3;
    const PERMISO_BORRAR = 4;
    const PERMISO_VER = 5;

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
     * @Assert\Valid
     */
    private $objetivosGral;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivos_especificos", type="text", nullable=true)
     * @Assert\Valid
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
     * @var string
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
     * Codigo guarani de la asignatura
     * 
     * @var Asignatura
     * 
     * @ORM\Column(name="codigo_asignatura", type="string", length=12)
     * @Assert\NotBlank(message="El campo Asignatura es obligatorio")
     */
    private $codigoAsignatura;

    /**
     * Nombre de la asignatura
     * 
     * @var Asignatura
     * 
     * @ORM\Column(name="nombre_asignatura", type="string", length=256)
     */
    private $nombreAsignatura;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToOne(targetEntity="DocenteResponsablePlanificacion", mappedBy="planificacion", cascade={"persist", "remove"})
     */
    private $docenteResponsable;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="DocenteColaboradorPlanificacion", mappedBy="planificacion", cascade={"persist","remove"})
     */
    private $docentesColaboradores;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="DocenteAdscriptoPlanificacion", mappedBy="planificacion", cascade={"persist","remove"})
     */
    private $docentesAdscriptos;

    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="HistoricoEstados", mappedBy="planificacion")
     */
    private $historicosEstado;

    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ActividadCurricular", mappedBy="planificacion", cascade={"persist","remove"})  
     * 
     */
    private $actividadCurricular;

    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="BibliografiaPlanificacion", mappedBy="planificacion", cascade={"persist","remove"})
     * @Assert\Valid 
     */
    private $bibliografiasPlanificacion;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="ViajeAcademico", mappedBy="planificacion", cascade={"persist","remove"})
     * @Assert\Valid 
     */
    private $viajesAcademicos;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="Temario", mappedBy="planificacion", cascade={"persist","remove"})
     * @Assert\Valid
     */
    private $temario;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="ResultadosAprendizajes", mappedBy="planificacion", cascade={"persist","remove"})
     * @Assert\Valid
     */
    private $resultados;


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

    /**
     *
     * @var \DateTime 
     * 
     * @ORM\Column(name="ultima_modif", type="datetime")
     */
    private $ultimaModif;

    public function __construct() {
        $this->docentesAdscriptos = new ArrayCollection;
        $this->docentesColaboradores = new ArrayCollection;
        $this->historicosEstado = new ArrayCollection;
        $this->actividadCurricular = new ArrayCollection;
        $this->bibliografiasPlanificacion = new ArrayCollection;
        $this->viajesAcademicos = new ArrayCollection;
        $this->temario = new ArrayCollection;
        $this->resultados = new ArrayCollection;
        $this->fechaCreacion = new \DateTime;
        $this->ultimaModif = new \DateTime;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->nombreAsignatura . ' ' . $this->anioAcad;
    }

    public function __toString() {
        return $this->getTitulo();
    }

    /**
     * Devuelve el total de horas de todas las actividades curriculares definidas.
     * 
     * @return type
     */
    public function getTotalCargaHorariaAula() {
        $sum = 0;
        foreach ($this->actividadCurricular as $a) {
            $sum += $a->getCargaHorariaAula();
        }
        return $sum;
    }

    public function getTotalCargaHorariaAutonomo() {
        $sum = 0;
        foreach ($this->actividadCurricular as $a) {
            $sum += $a->getCargaHorariaAutonomo();
        }
        return $sum;
    }

    public function getTotalTeoria() {
        $sum = 0;
        foreach ($this->actividadCurricular as $a) {
            if ($a->isTeoria())
                $sum += $a->getCargaHorariaAula();
        }
        return $sum;
    }

    public function getTotalColoquio() {
        $sum = 0;
        foreach ($this->actividadCurricular as $a) {
            if ($a->isColoquio()) {
                $sum += $a->getCargaHorariaAula();
            }
        }
        return $sum;
    }

    public function getTotalTeoricoPractica() {
        $sum = 0;
        foreach ($this->actividadCurricular as $a) {
            if ($a->isTeoricoPractica()) {
                $sum += $a->getCargaHorariaAula();
            }
        }
        return $sum;
    }

    public function getTotalFormacionPractica() {
        $sum = 0;
        foreach ($this->actividadCurricular as $a) {
            if ($a->isPractica()) {
                $sum += $a->getCargaHorariaAula();
            }
        }
        return $sum;
    }

    public function getTotalConsulta() {
        $sum = 0;
        foreach ($this->actividadCurricular as $a) {
            if ($a->isConsulta()) {
                $sum += $a->getCargaHorariaAula();
            }
        }
        return $sum;
    }
    
    public function getTotalEvaluacion() {
        $sum = 0;
        foreach ($this->actividadCurricular as $a) {
            if ($a->isEvaluacion()) {
                $sum += $a->getCargaHorariaAula();
            }
        }
        return $sum;
    }
    public function getTotalOtrasAct() {
        $sum = 0;
        foreach ($this->actividadCurricular as $a) {
            if ($a->isOtrasActividades()) {
                $sum += $a->getCargaHorariaAula();
            }
        }
        return $sum;
    }

    public function enPreparacion() {
        return $this->isEstado(Estado::PREPARACION);
    }

    public function enRevision() {
        return $this->isEstado(Estado::REVISION);
    }

    public function enCorreccion() {
        return $this->isEstado(Estado::CORRECCION);
    }

    public function isPublicada() {
        return $this->isEstado(Estado::PUBLICADA);
    }

    /**
     * Funcion auxiliar que compara el estado actual de la planificacion con el codigo pasado como argumento.
     * 
     * @param int $cod
     * @return boolean
     */
    private function isEstado($cod) {
        $hea = $this->getHistoricoEstadoActual();
        if ($hea instanceof HistoricoEstados) {
            return $this->getEstado()->getCodigo() == $cod;
        }
        return false;
    }

    /**
     * Devuelve el historico que contiene la informacion sobre el estado actual.
     * 
     * @return HistoricoEstados|null
     */
    public function getHistoricoEstadoActual() {
        $res = null;
        foreach ($this->historicosEstado as $historico) {
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
            return $hea->getEstado()->getNombre();
        }

        return null;
    }

    /**
     * Set anioAcad
     *
     * @param integer $anioAcad
     *
     * @return Planificacion
     */
    public function setAnioAcad($anioAcad) {
        $this->anioAcad = $anioAcad;

        return $this;
    }

    /**
     * Get anioAcad
     *
     * @return int
     */
    public function getAnioAcad() {
        return $this->anioAcad;
    }

    /**
     * Set contenidosMinimos
     *
     * @param string $contenidosMinimos
     *
     * @return Planificacion
     */
    public function setContenidosMinimos($contenidosMinimos) {
        $this->contenidosMinimos = $contenidosMinimos;

        return $this;
    }

    /**
     * Get contenidosMinimos
     *
     * @return string
     */
    public function getContenidosMinimos() {
        return $this->contenidosMinimos;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Planificacion
     */
    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    /**
     * Set objetivosGral
     *
     * @param string $objetivosGral
     *
     * @return Planificacion
     */
    public function setObjetivosGral($objetivosGral) {
        $this->objetivosGral = $objetivosGral;

        return $this;
    }

    /**
     * Get objetivosGral
     *
     * @return string
     */
    public function getObjetivosGral() {
        return $this->objetivosGral;
    }

    /**
     * Set objetivosEspecificos
     *
     * @param string $objetivosEspecificos
     *
     * @return Planificacion
     */
    public function setObjetivosEspecificos($objetivosEspecificos) {
        $this->objetivosEspecificos = $objetivosEspecificos;

        return $this;
    }

    /**
     * Get objetivosEspecificos
     *
     * @return string
     */
    public function getObjetivosEspecificos() {
        return $this->objetivosEspecificos;
    }

    /**
     * Set departamento
     *
     * @param \PlanificacionesBundle\Entity\Departamento $departamento
     *
     * @return Planificacion
     */
    public function setDepartamento(\PlanificacionesBundle\Entity\Departamento $departamento = null) {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \PlanificacionesBundle\Entity\Departamento
     */
    public function getDepartamento() {
        return $this->departamento;
    }

    /**
     * Add historicosEstado
     *
     * @param \PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado
     *
     * @return Planificacion
     */
    public function addHistoricosEstado(\PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado) {
        $this->historicosEstado[] = $historicosEstado;

        return $this;
    }

    /**
     * Remove historicosEstado
     *
     * @param \PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado
     */
    public function removeHistoricosEstado(\PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado) {
        $this->historicosEstado->removeElement($historicosEstado);
    }

    /**
     * Get historicosEstado
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistoricosEstado() {
        return $this->historicosEstado;
    }

    /**
     * Add bibliografiasPlanificacion
     *
     * @param \PlanificacionesBundle\Entity\BibliografiaPlanificacion $bibliografiasPlanificacion
     *
     * @return Planificacion
     */
    public function addBibliografiasPlanificacion(\PlanificacionesBundle\Entity\BibliografiaPlanificacion $bibliografiasPlanificacion) {

        $bibliografiasPlanificacion->setPlanificacion($this);

        $this->bibliografiasPlanificacion[] = $bibliografiasPlanificacion;

        return $this;
    }

    /**
     * Remove bibliografiasPlanificacion
     *
     * @param \PlanificacionesBundle\Entity\BibliografiaPlanificacion $bibliografiasPlanificacion
     */
    public function removeBibliografiasPlanificacion(\PlanificacionesBundle\Entity\BibliografiaPlanificacion $bibliografiasPlanificacion) {
        $this->bibliografiasPlanificacion->removeElement($bibliografiasPlanificacion);
    }

    /**
     * Get bibliografiasPlanificacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBibliografiasPlanificacion() {
        return $this->bibliografiasPlanificacion;
    }

    /**
     * Add viajesAcademico
     *
     * @param \PlanificacionesBundle\Entity\ViajeAcademico $viajesAcademico
     *
     * @return Planificacion
     */
    public function addViajesAcademico(\PlanificacionesBundle\Entity\ViajeAcademico $viajesAcademico) {
        $viajesAcademico->setPlanificacion($this);

        $this->viajesAcademicos[] = $viajesAcademico;

        return $this;
    }

    /**
     * Remove viajesAcademico
     *
     * @param \PlanificacionesBundle\Entity\ViajeAcademico $viajesAcademico
     */
    public function removeViajesAcademico(\PlanificacionesBundle\Entity\ViajeAcademico $viajesAcademico) {
        $this->viajesAcademicos->removeElement($viajesAcademico);
    }

    /**
     * Get viajesAcademicos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getViajesAcademicos() {
        return $this->viajesAcademicos;
    }

    /**
     * Set cargaHoraria
     *
     * @param \PlanificacionesBundle\Entity\CargaHoraria $cargaHoraria
     *
     * @return Planificacion
     */
    public function setCargaHoraria(\PlanificacionesBundle\Entity\CargaHoraria $cargaHoraria = null) {
        // Esto es para setear la planificacion en CargaHoraria:
        $cargaHoraria->setPlanificacion($this);

        $this->cargaHoraria = $cargaHoraria;

        return $this;
    }

    /**
     * Get cargaHoraria
     *
     * @return \PlanificacionesBundle\Entity\CargaHoraria
     */
    public function getCargaHoraria() {
        return $this->cargaHoraria;
    }

    /**
     * Set requisitosAprobacion
     *
     * @param \PlanificacionesBundle\Entity\RequisitosAprobacion $requisitosAprobacion
     *
     * @return Planificacion
     */
    public function setRequisitosAprobacion(\PlanificacionesBundle\Entity\RequisitosAprobacion $requisitosAprobacion = null) {
        // Esto es para setear la planificacion en RequisitoAprobacion:
        $requisitosAprobacion->setPlanificacion($this);

        $this->requisitosAprobacion = $requisitosAprobacion;

        return $this;
    }

    /**
     * Get requisitosAprobacion
     *
     * @return \PlanificacionesBundle\Entity\RequisitosAprobacion
     */
    public function getRequisitosAprobacion() {
        return $this->requisitosAprobacion;
    }

    /**
     * Set carrera
     *
     * @param string $carrera
     *
     * @return Planificacion
     */
    public function setCarrera($carrera) {
        $this->carrera = $carrera;

        return $this;
    }

    /**
     * Get carrera
     *
     * @return string
     */
    public function getCarrera() {
        return $this->carrera;
    }

    /**
     * Set plan
     *
     * @param integer $plan
     *
     * @return Planificacion
     */
    public function setPlan($plan) {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return integer
     */
    public function getPlan() {
        return $this->plan;
    }

    /**
     * Set versionPlan
     *
     * @param integer $versionPlan
     *
     * @return Planificacion
     */
    public function setVersionPlan($versionPlan) {
        $this->versionPlan = $versionPlan;

        return $this;
    }

    /**
     * Get versionPlan
     *
     * @return integer
     */
    public function getVersionPlan() {
        return $this->versionPlan;
    }

    /**
     * Add temario
     *
     * @param \PlanificacionesBundle\Entity\Temario $temario
     *
     * @return Planificacion
     */
    public function addTemario(\PlanificacionesBundle\Entity\Temario $temario) {
        $temario->setPlanificacion($this);

        $this->temario[] = $temario;

        return $this;
    }

    /**
     * Remove temario
     *
     * @param \PlanificacionesBundle\Entity\Temario $temario
     */
    public function removeTemario(\PlanificacionesBundle\Entity\Temario $temario) {
        $this->temario->removeElement($temario);
    }

    /**
     * Get temario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemario() {
        return $this->temario;
    }

    /**
     * Set docenteResponsable
     *
     * @param \PlanificacionesBundle\Entity\DocenteResponsablePlanificacion $docenteResponsable
     *
     * @return Planificacion
     */
    public function setDocenteResponsable(\PlanificacionesBundle\Entity\DocenteResponsablePlanificacion $docenteResponsable = null) {
        $docenteResponsable->setPlanificacion($this);

        $this->docenteResponsable = $docenteResponsable;

        return $this;
    }

    /**
     * Get docenteResponsable
     *
     * @return \PlanificacionesBundle\Entity\DocenteResponsablePlanificacion
     */
    public function getDocenteResponsable() {
        return $this->docenteResponsable;
    }

    /**
     * Add docentesColaboradore
     *
     * @param \PlanificacionesBundle\Entity\DocenteColaboradorPlanificacion $docentesColaboradore
     *
     * @return Planificacion
     */
    public function addDocentesColaboradore(\PlanificacionesBundle\Entity\DocenteColaboradorPlanificacion $docentesColaboradore) {
        $docentesColaboradore->setPlanificacion($this);

        $this->docentesColaboradores[] = $docentesColaboradore;

        return $this;
    }

    /**
     * Remove docentesColaboradore
     *
     * @param \PlanificacionesBundle\Entity\DocenteColaboradorPlanificacion $docentesColaboradore
     */
    public function removeDocentesColaboradore(\PlanificacionesBundle\Entity\DocenteColaboradorPlanificacion $docentesColaboradore) {
        $this->docentesColaboradores->removeElement($docentesColaboradore);
    }

    /**
     * Get docentesColaboradores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocentesColaboradores() {
        return $this->docentesColaboradores;
    }

    /**
     * Add docentesAdscripto
     *
     * @param \PlanificacionesBundle\Entity\DocenteAdscriptoPlanificacion $docentesAdscripto
     *
     * @return Planificacion
     */
    public function addDocentesAdscripto(\PlanificacionesBundle\Entity\DocenteAdscriptoPlanificacion $docentesAdscripto) {
        $docentesAdscripto->setPlanificacion($this);

        $this->docentesAdscriptos[] = $docentesAdscripto;

        return $this;
    }

    /**
     * Remove docentesAdscripto
     *
     * @param \PlanificacionesBundle\Entity\DocenteAdscriptoPlanificacion $docentesAdscripto
     */
    public function removeDocentesAdscripto(\PlanificacionesBundle\Entity\DocenteAdscriptoPlanificacion $docentesAdscripto) {
        $this->docentesAdscriptos->removeElement($docentesAdscripto);
    }

    /**
     * Get docentesAdscriptos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocentesAdscriptos() {
        return $this->docentesAdscriptos;
    }

    /**
     * Add actividadCurricular
     *
     * @param \PlanificacionesBundle\Entity\ActividadCurricular $actividadCurricular
     *
     * @return Planificacion
     */
    public function addActividadCurricular(\PlanificacionesBundle\Entity\ActividadCurricular $actividadCurricular) {
        $actividadCurricular->setPlanificacion($this);

        $this->actividadCurricular[] = $actividadCurricular;

        return $this;
    }

    /**
     * Remove actividadCurricular
     *
     * @param \PlanificacionesBundle\Entity\ActividadCurricular $actividadCurricular
     */
    public function removeActividadCurricular(\PlanificacionesBundle\Entity\ActividadCurricular $actividadCurricular) {
        $this->actividadCurricular->removeElement($actividadCurricular);
    }

    /**
     * Get actividadCurricular
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActividadCurricular() {
        return $this->actividadCurricular;
    }

    /**
     * Set codigoAsignatura
     *
     * @param string $codigoAsignatura
     *
     * @return Planificacion
     */
    public function setCodigoAsignatura($codigoAsignatura) {
        $this->codigoAsignatura = $codigoAsignatura;

        return $this;
    }

    /**
     * Get codigoAsignatura
     *
     * @return string
     */
    public function getCodigoAsignatura() {
        return $this->codigoAsignatura;
    }

    /**
     * Set nombreAsignatura
     *
     * @param string $nombreAsignatura
     *
     * @return Planificacion
     */
    public function setNombreAsignatura($nombreAsignatura) {
        $this->nombreAsignatura = $nombreAsignatura;

        return $this;
    }

    /**
     * Get nombreAsignatura
     *
     * @return string
     */
    public function getNombreAsignatura() {
        return $this->nombreAsignatura;
    }

    /**
     * Set ultimaModif
     *
     * @param \DateTime $ultimaModif
     *
     * @return Planificacion
     */
    public function setUltimaModif($ultimaModif) {
        $this->ultimaModif = $ultimaModif;

        return $this;
    }

    /**
     * Get ultimaModif
     *
     * @return \DateTime
     */
    public function getUltimaModif() {
        return $this->ultimaModif;
    }


    /**
     * Add resultado
     *
     * @param \PlanificacionesBundle\Entity\ResultadosAprendizajes $resultado
     *
     * @return Planificacion
     */
    public function addResultado(\PlanificacionesBundle\Entity\ResultadosAprendizajes $resultado)
    {
        $resultado->setPlanificacion($this);
        $this->resultados[] = $resultado;

        return $this;
    }

    /**
     * Remove resultado
     *
     * @param \PlanificacionesBundle\Entity\ResultadosAprendizajes $resultado
     */
    public function removeResultado(\PlanificacionesBundle\Entity\ResultadosAprendizajes $resultado)
    {
        $this->resultados->removeElement($resultado);
    }

    /**
     * Get resultados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResultados()
    {
        return $this->resultados;
    }
}
