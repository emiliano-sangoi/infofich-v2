<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RequisitosAprobacion
 *
 * @ORM\Table(name="planif_requisitos_aprobacion")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\RequisitosAprobacionRepository")
 */
class RequisitosAprobacion {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="preve_prom_parcial_teoria", type="boolean")
     */
    private $prevePromParcialTeoria;

    /**
     * @var bool
     *
     * @ORM\Column(name="preve_prom_parcial_practica", type="boolean")
     */
    private $prevePromParcialPractica;

    /**
     * @var bool
     *
     * @ORM\Column(name="preve_cfi", type="boolean")
     * @Assert\NotNull(message="Este campo no puede quedar vacio.")
     * 
     */
    private $preveCfi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_parcail_cfi", type="datetime", nullable=true)
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     * 
     */
    private $fechaParcailCfi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_recup_cfi", type="datetime", nullable=true)
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     */
    private $fechaRecupCfi;

    /**
     * @var string
     *
     * @ORM\Column(name="modalidad_cfi", type="string", length=512, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 512,
     *      minMessage = "Este campo debe tener como mínimo {{ limit }} caracteres",
     *      maxMessage = "Este campo debe tener como máximo {{ limit }} caracteres"
     * )
     */
    private $modalidadCfi;

    /**
     * @var string
     *
     * @ORM\Column(name="porcentaje_asistencia", type="integer")
     * @Assert\Range(
     *      min = "70",
     *      max = "100",
     *      minMessage = "El valor debe ser mayor o igual a {{ limit }}",
     *      maxMessage = "El valor debe ser menor  o igual a {{ limit }}"
     * )
     * @Assert\NotBlank(message="Este campo no puede quedar vacio.")
     */
    private $porcentajeAsistencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_primer_parcial", type="datetime")
     * @Assert\NotBlank(message="Este campo no puede quedar vacio.")
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     */
    private $fechaPrimerParcial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_segundo_parcial", type="datetime")
     * @Assert\NotBlank(message="Este campo no puede quedar vacio.")
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     * @Assert\Expression(
     *     "this.getFechaSegundoParcial() > this.getFechaPrimerParcial()",
     *     message="Este campo debe ser mayor a la fecha de primer parcial."
     * )
     */
    private $fechaSegundoParcial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_recup_primer_parcial", type="datetime")
     * @Assert\NotBlank(message="Este campo no puede quedar vacio.")
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     * @Assert\Expression(
     *     "this.getFechaRecupPrimerParcial() >= this.getFechaPrimerParcial()",
     *     message="Este campo debe ser mayor a la fecha de segundo parcial."
     * )
     */
    private $fechaRecupPrimerParcial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_recup_segundo_parcial", type="datetime")
     * @Assert\NotBlank(message="Este campo no puede quedar vacio.")
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     * @Assert\Expression(
     *     "this.getFechaRecupSegundoParcial() >= this.getFechaRecupPrimerParcial()",
     *     message="Este campo debe ser igual o mayor a la fecha del recuperatorio del primer parcial."
     * )
     */
    private $fechaRecupSegundoParcial;

    /**
     * @var string
     *
     * @ORM\Column(name="examen_final_modalidad_regulares", type="text", nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 512,
     *      minMessage = "Este campo debe tener como mínimo {{ limit }} caracteres",
     *      maxMessage = "Este campo debe tener como máximo {{ limit }} caracteres"
     * )
     */
    private $examenFinalModalidadRegulares;

    /**
     * @var string
     *
     * @ORM\Column(name="examen_final_modalidad_libres", type="text", nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 512,
     *      minMessage = "Este campo debe tener como mínimo {{ limit }} caracteres",
     *      maxMessage = "Este campo debe tener como máximo {{ limit }} caracteres"
     * )
     */
    private $examenFinalModalidadLibres;

    /**
     *
     * @var Planificacion
     * 
     * @ORM\OneToOne(targetEntity="Planificacion", inversedBy="requisitosAprobacion")
     */
    private $planificacion;
    
    public function __construct() {
        $this->prevePromParcialTeoria = true;
        $this->prevePromParcialPractica = true;        
    }
    
    public function __toString() {
        return 'Requisitos aprobación planificación: ' . $this->planificacion->getId();
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
     * Set prevePromParcialTeoria
     *
     * @param boolean $prevePromParcialTeoria
     *
     * @return RequisitosAprobacion
     */
    public function setPrevePromParcialTeoria($prevePromParcialTeoria) {
        $this->prevePromParcialTeoria = $prevePromParcialTeoria;

        return $this;
    }

    /**
     * Get prevePromParcialTeoria
     *
     * @return bool
     */
    public function getPrevePromParcialTeoria() {
        return $this->prevePromParcialTeoria;
    }

    /**
     * Set prevePromParcialPractica
     *
     * @param boolean $prevePromParcialPractica
     *
     * @return RequisitosAprobacion
     */
    public function setPrevePromParcialPractica($prevePromParcialPractica) {
        $this->prevePromParcialPractica = $prevePromParcialPractica;

        return $this;
    }

    /**
     * Get prevePromParcialPractica
     *
     * @return bool
     */
    public function getPrevePromParcialPractica() {
        return $this->prevePromParcialPractica;
    }

    /**
     * Set preveCfi
     *
     * @param boolean $preveCfi
     *
     * @return RequisitosAprobacion
     */
    public function setPreveCfi($preveCfi) {
        $this->preveCfi = $preveCfi;

        return $this;
    }

    /**
     * Get preveCfi
     *
     * @return bool
     */
    public function getPreveCfi() {
        return $this->preveCfi;
    }
    
    /**
     * Get preveCfi
     * 
     * @return bool
     */
    public function preveCfi() {
        return $this->preveCfi;
    }

    /**
     * Set fechaParcailCfi
     *
     * @param \DateTime $fechaParcailCfi
     *
     * @return RequisitosAprobacion
     */
    public function setFechaParcailCfi($fechaParcailCfi) {
        $this->fechaParcailCfi = $fechaParcailCfi;

        return $this;
    }

    /**
     * Get fechaParcailCfi
     *
     * @return \DateTime
     */
    public function getFechaParcailCfi() {
        return $this->fechaParcailCfi;
    }

    /**
     * Set fechaRecupCfi
     *
     * @param \DateTime $fechaRecupCfi
     *
     * @return RequisitosAprobacion
     */
    public function setFechaRecupCfi($fechaRecupCfi) {
        $this->fechaRecupCfi = $fechaRecupCfi;

        return $this;
    }

    /**
     * Get fechaRecupCfi
     *
     * @return \DateTime
     */
    public function getFechaRecupCfi() {
        return $this->fechaRecupCfi;
    }

    /**
     * Set modalidadCfi
     *
     * @param string $modalidadCfi
     *
     * @return RequisitosAprobacion
     */
    public function setModalidadCfi($modalidadCfi) {
        $this->modalidadCfi = $modalidadCfi;

        return $this;
    }

    /**
     * Get modalidadCfi
     *
     * @return string
     */
    public function getModalidadCfi() {
        return $this->modalidadCfi;
    }

    /**
     * Set porcentajeAsistencia
     *
     * @param string $porcentajeAsistencia
     *
     * @return RequisitosAprobacion
     */
    public function setPorcentajeAsistencia($porcentajeAsistencia) {
        $this->porcentajeAsistencia = $porcentajeAsistencia;

        return $this;
    }

    /**
     * Get porcentajeAsistencia
     *
     * @return string
     */
    public function getPorcentajeAsistencia() {
        return $this->porcentajeAsistencia;
    }

    /**
     * Set fechaPrimerParcial
     *
     * @param \DateTime $fechaPrimerParcial
     *
     * @return RequisitosAprobacion
     */
    public function setFechaPrimerParcial($fechaPrimerParcial) {
        $this->fechaPrimerParcial = $fechaPrimerParcial;

        return $this;
    }

    /**
     * Get fechaPrimerParcial
     *
     * @return \DateTime
     */
    public function getFechaPrimerParcial() {
        return $this->fechaPrimerParcial;
    }

    /**
     * Set fechaSegundoParcial
     *
     * @param \DateTime $fechaSegundoParcial
     *
     * @return RequisitosAprobacion
     */
    public function setFechaSegundoParcial($fechaSegundoParcial) {
        $this->fechaSegundoParcial = $fechaSegundoParcial;

        return $this;
    }

    /**
     * Get fechaSegundoParcial
     *
     * @return \DateTime
     */
    public function getFechaSegundoParcial() {
        return $this->fechaSegundoParcial;
    }

    /**
     * Set fechaRecupPrimerParcial
     *
     * @param \DateTime $fechaRecupPrimerParcial
     *
     * @return RequisitosAprobacion
     */
    public function setFechaRecupPrimerParcial($fechaRecupPrimerParcial) {
        $this->fechaRecupPrimerParcial = $fechaRecupPrimerParcial;

        return $this;
    }

    /**
     * Get fechaRecupPrimerParcial
     *
     * @return \DateTime
     */
    public function getFechaRecupPrimerParcial() {
        return $this->fechaRecupPrimerParcial;
    }

    /**
     * Set fechaRecupSegundoParcial
     *
     * @param \DateTime $fechaRecupSegundoParcial
     *
     * @return RequisitosAprobacion
     */
    public function setFechaRecupSegundoParcial($fechaRecupSegundoParcial) {
        $this->fechaRecupSegundoParcial = $fechaRecupSegundoParcial;

        return $this;
    }

    /**
     * Get fechaRecupSegundoParcial
     *
     * @return \DateTime
     */
    public function getFechaRecupSegundoParcial() {
        return $this->fechaRecupSegundoParcial;
    }

    /**
     * Set examenFinalModalidadRegulares
     *
     * @param string $examenFinalModalidadRegulares
     *
     * @return RequisitosAprobacion
     */
    public function setExamenFinalModalidadRegulares($examenFinalModalidadRegulares) {
        $this->examenFinalModalidadRegulares = $examenFinalModalidadRegulares;

        return $this;
    }

    /**
     * Get examenFinalModalidadRegulares
     *
     * @return string
     */
    public function getExamenFinalModalidadRegulares() {
        return $this->examenFinalModalidadRegulares;
    }

    /**
     * Set examenFinalModalidadLibres
     *
     * @param string $examenFinalModalidadLibres
     *
     * @return RequisitosAprobacion
     */
    public function setExamenFinalModalidadLibres($examenFinalModalidadLibres) {
        $this->examenFinalModalidadLibres = $examenFinalModalidadLibres;

        return $this;
    }

    /**
     * Get examenFinalModalidadLibres
     *
     * @return string
     */
    public function getExamenFinalModalidadLibres() {
        return $this->examenFinalModalidadLibres;
    }

    /**
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return RequisitosAprobacion
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

}
