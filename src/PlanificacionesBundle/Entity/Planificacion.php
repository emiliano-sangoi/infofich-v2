<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use \FICH\APIRectorado\Config\WSHelper;

/**
 * Planificacion
 *
 * @ORM\Table(name="planif_planificaciones", uniqueConstraints={@ORM\UniqueConstraint(name="planif_idx", columns={"carrera", "codigo_asignatura", "anio_acad"})})
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\PlanificacionRepository")
 * @UniqueEntity(
 *     fields={"carrera", "codigoAsignatura", "anioAcad"},
 *     errorPath="codigoAsignatura",
 *     message="Esta asignatura ya tiene creada una planificación."
 * )
 */
class Planificacion implements \JsonSerializable{

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
     * @ORM\Column(name="carrera", type="string", length=8)     
     */
    private $carrera;

    /**
     * Plan al que pertenece la carrera.
     *      
     * @var string
     * 
     * @ORM\Column(name="plan", type="string", length=6)
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
     * @ORM\Column(name="codigo_asignatura", type="string", length=24)     
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
     * @var \DocentesBundle\Entity\DocenteGrado
     * 
     * @ORM\ManyToOne(targetEntity="\DocentesBundle\Entity\DocenteGrado", inversedBy="planificacionesResponsable")
     * @ORM\JoinColumn(name="docente_responsable_id", referencedColumnName="id")
     */
    private $docenteResponsable;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="PlanificacionDocenteColaborador", mappedBy="planificacion", cascade={"persist","remove"})
     */     
    private $docentesColaboradores;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="PlanificacionDocenteAdscripto", mappedBy="planificacion", cascade={"persist","remove"})
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
     * @ORM\OneToMany(targetEntity="Bibliografia", mappedBy="planificacion", cascade={"persist","remove"})
     * @Assert\Valid 
     */
    private $bibliografias;

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
     * @ORM\OneToOne(targetEntity="RequisitosAprobacion", mappedBy="planificacion", cascade={"remove", "persist"})
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
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    
    public function getTitulo() {
        return mb_strtoupper($this->nombreAsignatura) . ' ' . $this->anioAcad;
    }

    public function __toString() {
        return $this->getTitulo();
    }
    
    /**
     * https://stackoverflow.com/questions/14158111/deep-clone-doctrine-entity-with-related-entities
     */
    public function __clone() {
        if ($this->id) {
            
            $this->setId(null);
            
            
            //------------------------------------------------------------------------------------
            // Copia de docentes colaboradores
            $dc = new ArrayCollection();
            foreach ($this->docentesColaboradores as $item){
                $itemCopia = clone $item;
                $itemCopia->setPlanificacion($this);
                $dc->add($itemCopia);                
            }
            
            $this->docentesColaboradores = $dc;
            
            //------------------------------------------------------------------------------------
            // Copia de docentes adscriptos
            $d_adsc = new ArrayCollection();
            foreach ($this->docentesAdscriptos as $item){
                $itemCopia = clone $item;
                $itemCopia->setPlanificacion($this);
                $d_adsc->add($itemCopia);                
            }
            
            $this->docentesAdscriptos = $d_adsc;
            
            //------------------------------------------------------------------------------------
            // Requisitos de aprobación
            if($this->requisitosAprobacion) {
                $r_aprob = clone $this->requisitosAprobacion;
                $r_aprob->setPlanificacion($this);
                $this->requisitosAprobacion = $r_aprob;
            }
            
            //------------------------------------------------------------------------------------
            // Resultados de aprendizaje
            $r_apren = new ArrayCollection();
            foreach ($this->resultados as $item){
                $itemCopia = clone $item;
                $itemCopia->setPlanificacion($this);
                $r_apren->add($itemCopia);                
            }
            
            $this->resultados = $r_apren;
            
            //------------------------------------------------------------------------------------
            // Temario
            $temarios = new ArrayCollection();
            foreach ($this->temario as $item){
                $itemCopia = clone $item;
                $itemCopia->setPlanificacion($this);
                $temarios->add($itemCopia);                
            }
            
            $this->temario = $temarios;
            
            //------------------------------------------------------------------------------------
            // Bibliografía
            $b_planif = new ArrayCollection();
            foreach ($this->bibliografias as $item){                                
                $itemCopia = clone $item;
                $itemCopia->setPlanificacion($this);
                $b_planif->add($itemCopia);                
            }
            
            $this->bibliografias = $b_planif;
            
            
            //------------------------------------------------------------------------------------
            // Actividades curriculares
            $a_curriculares = new ArrayCollection();
            foreach ($this->actividadCurricular as $item){                                
                $itemCopia = clone $item;
                $itemCopia->setPlanificacion($this);
                $a_curriculares->add($itemCopia);                
            }
            
            $this->actividadCurricular = $a_curriculares;
            
            //------------------------------------------------------------------------------------
            // Viajes academicos
            $viajes = new ArrayCollection();
            foreach ($this->viajesAcademicos as $item){                                
                $itemCopia = clone $item;
                $itemCopia->setPlanificacion($this);
                $viajes->add($itemCopia);                
            }
            
            $this->viajesAcademicos = $viajes;
            
            
            
        }
    }
    
    
    /**
     * Metodo que verifica si la persona pasada como parametro figura como 
     * docente en la planificacion
     * 
     * @param \AppBundle\Entity\Persona $persona
     * @return type
     */
    public function inEquipoDocente(\AppBundle\Entity\Persona $persona) {
        
        if($this->docenteResponsable && $this->docenteResponsable->getPersona() == $persona){
            return true;
        }
        
        if($this->docentesColaboradores){
            foreach ($this->docentesColaboradores as $dc){
                if($dc->getDocenteGrado()->getPersona() == $persona){
                    return true;
                }
            }
        }
        if($this->docentesColaboradores){
            foreach ($this->docentesAdscriptos as $planifDocAds){            
                if($planifDocAds->getDocenteAdscripto()->getPersona() == $persona){
                    return true;
                }
            }
        }
        return false;
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
     * Funcion auxiliar que permite saber si una planificacion puede ser editada por el docente.
     * 
     * @return boolean
     */
    public function puedeEditarse(){
        return $this->isEstado(Estado::PREPARACION) || $this->isEstado(Estado::CORRECCION);
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
            return $this->getEstadoActual()->getCodigo() == $cod;
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
     * Devuelve el dueño de la planificacion o usuario que lo creo.
     * 
     * 
     * @return \AppBundle\Entity\Usuario|null
     */
    public function getOwner(){
        $res = null;
        foreach ($this->historicosEstado as $historico) {
            if ($historico->getEstado()->getCodigo() == Estado::CREADA) {
                $res = $historico->getUsuario();
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
     * Set historicosEstado
     * 
     * @param ArrayCollection $historicosEstado
     * @return $this
     */
    public function setHistoricosEstado(ArrayCollection $historicosEstado) {
        $this->historicosEstado = $historicosEstado;
        return $this;
    }

        
    /**
     * Devuelve un arreglo con los historicos de cambios de estados ordenados de forma descendente
     * en función del campo fechaDesde.
     *
     * @return array
     */
    public function getHistoricosEstadoOrd() {
        
        $tmp = $this->historicosEstado->toArray();
        uasort($tmp, function($v1, $v2){
            return $v2->getFechaDesde()->getTimestamp() > $v1->getFechaDesde()->getTimestamp();
        });
        
        return $tmp;
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
    
    public function getCarreraAbrev() {
        switch ($this->carrera){
            case WSHelper::CARRERA_II:
                return 'II';
            case WSHelper::CARRERA_IRH:
                return 'IRH';
            case WSHelper::CARRERA_IAGR:
                return 'IAGR';
            case WSHelper::CARRERA_IAMB:
                return 'IAMB';
        }
        
        return null;
    }
    
    

    /**
     * Set plan
     *
     * @param string $plan
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
     * @return string
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
     * Set docenteResponsable
     *
     * @param \DocentesBundle\Entity\DocenteGrado $docenteResponsable
     *
     * @return Planificacion
     */
    public function setDocenteResponsable(\DocentesBundle\Entity\DocenteGrado $docenteResponsable = null)
    {
        $this->docenteResponsable = $docenteResponsable;

        return $this;
    }

    /**
     * Get docenteResponsable
     *
     * @return \DocentesBundle\Entity\DocenteGrado
     */
    public function getDocenteResponsable()
    {
        return $this->docenteResponsable;
    }

    /**
     * Add actividadCurricular
     *
     * @param \PlanificacionesBundle\Entity\ActividadCurricular $actividadCurricular
     *
     * @return Planificacion
     */
    public function addActividadCurricular(\PlanificacionesBundle\Entity\ActividadCurricular $actividadCurricular)
    {
        $actividadCurricular->setPlanificacion($this);
        $this->actividadCurricular[] = $actividadCurricular;

        return $this;
    }



    /**
     * Add docentesColaboradore
     *
     * @param \PlanificacionesBundle\Entity\PlanificacionDocenteColaborador $docentesColaboradore
     *
     * @return Planificacion
     */
    public function addDocentesColaboradore(\PlanificacionesBundle\Entity\PlanificacionDocenteColaborador $docentesColaboradore)
    {
        $docentesColaboradore->setPlanificacion($this);
        
        $this->docentesColaboradores[] = $docentesColaboradore;

        return $this;
    }

    /**
     * Remove docentesColaboradore
     *
     * @param \PlanificacionesBundle\Entity\PlanificacionDocenteColaborador $docentesColaboradore
     */
    public function removeDocentesColaboradore(\PlanificacionesBundle\Entity\PlanificacionDocenteColaborador $docentesColaboradore)
    {
        $this->docentesColaboradores->removeElement($docentesColaboradore);
    }

    /**
     * Get docentesColaboradores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocentesColaboradores()
    {
        return $this->docentesColaboradores;
    }
    
    /**
     * 
     * @param ArrayCollection $docentesColaboradores
     * @return $this
     */
    public function setDocentesColaboradores(ArrayCollection $docentesColaboradores) {
        $this->docentesColaboradores = $docentesColaboradores;
        return $this;
    }

    
    /**
     * Add docentesAdscripto
     *
     * @param \PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto $docentesAdscripto
     *
     * @return Planificacion
     */
    public function addDocentesAdscripto(\PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto $docentesAdscripto)
    {
        $docentesAdscripto->setPlanificacion($this);
        
        $this->docentesAdscriptos[] = $docentesAdscripto;

        return $this;
    }

    /**
     * Remove docentesAdscripto
     *
     * @param \PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto $docentesAdscripto
     */
    public function removeDocentesAdscripto(\PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto $docentesAdscripto)
    {
        $this->docentesAdscriptos->removeElement($docentesAdscripto);
    }

    /**
     * Get docentesAdscriptos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocentesAdscriptos()
    {
        return $this->docentesAdscriptos;
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

    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'anioAcad' => $this->anioAcad,
            'plan' => $this->plan,
            'codigoAsignatura' => $this->codigoAsignatura,
            'carrera' => $this->carrera,
            'historicoEstadoActual' => $this->getHistoricoEstadoActual(),
        );
    }


    /**
     * Add bibliografia
     *
     * @param \PlanificacionesBundle\Entity\Bibliografia $bibliografia
     *
     * @return Planificacion
     */
    public function addBibliografia(\PlanificacionesBundle\Entity\Bibliografia $bibliografia)
    {
        $bibliografia->setPlanificacion($this);

        $this->bibliografias[] = $bibliografia;

        return $this;
    }

    /**
     * Remove bibliografia
     *
     * @param \PlanificacionesBundle\Entity\Bibliografia $bibliografia
     */
    public function removeBibliografia(\PlanificacionesBundle\Entity\Bibliografia $bibliografia)
    {
        $this->bibliografias->removeElement($bibliografia);
    }

    /**
     * Get bibliografias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBibliografias()
    {
        return $this->bibliografias;
    }
}
