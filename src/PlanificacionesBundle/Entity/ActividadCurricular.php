<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ActividadCurricular
 *
 * @ORM\Table(name="planif_actividad_curricular")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\ActividadCurricularRepository")
 */
class ActividadCurricular {

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
     * @ORM\Column(name="fecha", type="datetime")
     * @Assert\NotBlank(message="Este campo no puede quedar vacio.")
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha de la act debe ser mayor o igual al día de hoy.")
     * 
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="otras", type="text", nullable = true)
     */
    private $otras;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="text", nullable=true)
     * 
     */
    private $contenido;

    /**
     * @var string
     *
     * @ORM\Column(name="carga_horaria_aula", type="decimal", precision=6, scale=1, nullable=true)
     * @Assert\Type(
     *     type="double",
     *     message="La carga horaria debe ser un número decimal")
     */
    private $cargaHorariaAula;

    /**
     * @var string
     *
     * @ORM\Column(name="carga_horaria_autonomo", type="decimal", precision=6, scale=1, nullable=true)
     * @Assert\Type(
     *     type="double",
     *     message="La carga horaria debe ser un número decimal")
     */
    private $cargaHorariaAutonomo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="actividadesCurriculares")
     * @ORM\JoinColumn(name="planif_planificaciones_id", referencedColumnName="id", nullable=false)) 
     */
    private $planificacion;
    

    /**
     *
     * @var TipoActividadCurricular
     * 
     * @ORM\ManyToOne(targetEntity="TipoActividadCurricular")
     * @ORM\JoinColumn(name="planif_tipos_actividad_curricular_id", referencedColumnName="id") 
     */
    private $tipoActividadCurricular;
    
    /**
     *
     * @var Temario
     * 
     * @ORM\ManyToOne(targetEntity="Temario", inversedBy="actividades")
     * @ORM\JoinColumn(name="planif_temarios_id", referencedColumnName="id") 
     */
    private $temario;

    /**
     * @ORM\Column(name="posicion", type="integer", nullable=true)
     */
    private $posicion;

    public function __construct() {

        //$this->posicion = 1;
    }
    
    public function __toString() {
        return $this->descripcion;
    }

    /**
     * Devuelve true si la actividad es considerada como practica
     * 
     * 
     * 
     * @param type $cod_tipo
     * @return type
     */
    public function isPractica() {
        return TipoActividadCurricular::isPractica($this->tipoActividadCurricular->getCodigo());
    }

    /**
     * Devuelve true si la actividad es considerada como teoria
     * 
     * 
     * 
     * @param type $cod_tipo
     * @return type
     */
    public function isTeoria() {
        return TipoActividadCurricular::isTeoria($this->tipoActividadCurricular->getCodigo());
    }

    /**
     * Devuelve true si la actividad es considerada como coloquio
     * 
     * 
     * 
     * @param type $cod_tipo
     * @return type
     */
    public function isColoquio() {
        return TipoActividadCurricular::isColoquio($this->tipoActividadCurricular->getCodigo());
    }

    /**
     * Devuelve true si la actividad es considerada como teorico-practica
     * 
     * 
     * 
     * @param type $cod_tipo
     * @return type
     */
    public function isTeoricoPractica() {
        return TipoActividadCurricular::isTeoricoPractica($this->tipoActividadCurricular->getCodigo());
    }

    /**
     * Devuelve true si la actividad es considerada como consulta
     * 
     * 
     * 
     * @param type $cod_tipo
     * @return type
     */
    public function isConsulta() {
        return TipoActividadCurricular::isConsulta($this->tipoActividadCurricular->getCodigo());
    }

    /**
     * Devuelve true si la actividad es considerada como evaluacion
     * 
     * 
     * 
     * @param type $cod_tipo
     * @return type
     */
    public function isEvaluacion() {
        return TipoActividadCurricular::isEvaluacion($this->tipoActividadCurricular->getCodigo());
    }

    /**
     * Devuelve true si la actividad es considerada como consulta
     * 
     * 
     * 
     * @param type $cod_tipo
     * @return type
     */
    public function isOtrasActividades() {
        return TipoActividadCurricular::isOtrasActividades($this->tipoActividadCurricular->getCodigo());
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return ActividadCurricular
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set otras
     *
     * @param string $otras
     *
     * @return ActividadCurricular
     */
    public function setOtras($otras) {
        $this->otras = $otras;

        return $this;
    }

    /**
     * Get otras
     *
     * @return string
     */
    public function getOtras() {
        return $this->otras;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return ActividadCurricular
     */
    public function setContenido($contenido) {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido() {
        return $this->contenido;
    }

    /**
     * Set cargaHorariaAula
     *
     * @param string $cargaHorariaAula
     *
     * @return ActividadCurricular
     */
    public function setCargaHorariaAula($cargaHorariaAula) {
        $this->cargaHorariaAula = $cargaHorariaAula;

        return $this;
    }

    /**
     * Get cargaHorariaAula
     *
     * @return string
     */
    public function getCargaHorariaAula() {
        return $this->cargaHorariaAula;
    }

    /**
     * Set cargaHorariaAutonomo
     *
     * @param string $cargaHorariaAutonomo
     *
     * @return ActividadCurricular
     */
    public function setCargaHorariaAutonomo($cargaHorariaAutonomo) {
        $this->cargaHorariaAutonomo = $cargaHorariaAutonomo;

        return $this;
    }

    /**
     * Get cargaHorariaAutonomo
     *
     * @return string
     */
    public function getCargaHorariaAutonomo() {
        return $this->cargaHorariaAutonomo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return ActividadCurricular
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
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return ActividadCurricular
     */
    public function setPlanificacion(\PlanificacionesBundle\Entity\Planificacion $planificacion) {
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
     * Set tipoActividadCurricular
     *
     * @param \PlanificacionesBundle\Entity\TipoActividadCurricular $tipoActividadCurricular
     *
     * @return ActividadCurricular
     */
    public function setTipoActividadCurricular(\PlanificacionesBundle\Entity\TipoActividadCurricular $tipoActividadCurricular = null) {
        $this->tipoActividadCurricular = $tipoActividadCurricular;

        return $this;
    }

    /**
     * Get tipoActividadCurricular
     *
     * @return \PlanificacionesBundle\Entity\TipoActividadCurricular
     */
    public function getTipoActividadCurricular() {
        return $this->tipoActividadCurricular;
    }

    /**
     * Set temario
     *
     * @param \PlanificacionesBundle\Entity\Temario $temario
     *
     * @return ActividadCurricular
     */
    public function setTemario(\PlanificacionesBundle\Entity\Temario $temario = null) {
        $this->temario = $temario;

        return $this;
    }

    /**
     * Get temario
     *
     * @return \PlanificacionesBundle\Entity\Temario
     */
    public function getTemario() {
        return $this->temario;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     *
     * @return ActividadCurricular
     */
    public function setPosicion($posicion) {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer
     */
    public function getPosicion() {
        return $this->posicion;
    }

}
