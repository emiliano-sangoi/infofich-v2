<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Asignatura
 *
 * Campos devueltos por el web service:
 *      #codigoAsignatura: "FICHIF021"
 *      #nombreAsignatura: "COMPUTACIÓN GRÁFICA"
 *      #tipoAsignatura: "N"
 *      #horasSemanales: "7.00"
 *      #cargaHoraria: "105.00"
 *      #valorAsignatura: "7.00"
 *      #promediable: true
 *      #obligatoria: false
 *      #anioCursada: "3"
 *      #periodoCursada: "2do Cuatrimestre"
 *      #tipoCursada: "cuatrimestre"
 *
 * @ORM\Table(name="planif_asignaturas", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="ak_planif_asignaturas", columns={"carrera_id", "codigo_asignatura", "nro_modulo", "es_recursada"})
 * })
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\AsignaturaRepository")
 */
class Asignatura implements \JsonSerializable
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
     *
     * @var Carrera
    *
    * @ORM\ManyToOne(targetEntity="Carrera", inversedBy="asignaturas")
    * @ORM\JoinColumn(name="carrera_id", referencedColumnName="id")
    */
    private $carrera;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_asignatura", type="string", length=12)
     */
    private $codigoAsignatura;

    /**
     * Nombre de la asignatura
     *
     * @var string
     *
     * @ORM\Column(name="nombre_asignatura", type="string", length=256)
     */
    private $nombreAsignatura;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_asignatura", type="string", length=1)
     */
    private $tipoAsignatura;

    /**
     * @var float
     *
     * @ORM\Column(name="hs_semanales", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $hsSemanales;

    /**
     * @var float
     *
     * @ORM\Column(name="hs_carga_horaria", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $cargaHoraria;

    /**
     * @var float
     *
     * @ORM\Column(name="hs_valor_asignatura", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $valorAsignatura;

    /**
     * @var bool
     *
     * @ORM\Column(name="promediable", type="boolean", nullable=true)
     */
    private $promediable;

    /**
     * @var bool
     *
     * @ORM\Column(name="obligatoria", type="boolean")
     */
    private $obligatoria;

    /**
     * @var int
     *
     * @ORM\Column(name="anio_cursada", type="integer", nullable=true)
     */
    private $anioCursada;

    /**
     * @var string
     *
     * @ORM\Column(name="periodo_cursada", type="string", length=24, nullable=true)
     */
    private $periodoCursada;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_cursada", type="string", length=24, nullable=true)
     */
    private $tipoCursada;

    /**
     * @var int
     *
     * Indica un orden para las asignaturas que sean modulos.
     * Por ejemplo:
     * Para comunicaciòn tecnica I:
     *      1 - Sistemas de representación
     *      2 - Comunicación eletrónica
     * Si la asignatura no es un modulo puede estar como null
     *
     *
     * @ORM\Column(name="nro_modulo", type="integer", nullable=true)
     */
    private $nroModulo;

    /**
     * @var boolean
     *
     * Indica si es una asignatura que se dicta para recursantes
     * Si la asignatura no es para recursantes puede estar como null
     *
     *
     * @ORM\Column(name="es_recursada", type="boolean")
     */
    private $esRecursada;

    /**
     * @var bool
     *
     * @ORM\Column(name="origen_ws", type="boolean", nullable=true)
     * @Assert\NotNull(message="Este campo no puede quedar vacio.")
     */
    private $origenWs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_actualizacion", type="datetime")
     */
    private $fechaActualizacion;

    public function __construct()
    {
        $this->origenWs = false;
        $this->esRecursada = false;
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

   public function __toString()
   {
       return $this->nombreAsignatura;
   }

    /**
     * Set codigoAsignatura
     *
     * @param string $codigoAsignatura
     *
     * @return Asignatura
     */
    public function setCodigoAsignatura($codigoAsignatura)
    {
        $this->codigoAsignatura = $codigoAsignatura;

        return $this;
    }

    /**
     * Get codigoAsignatura
     *
     * @return string
     */
    public function getCodigoAsignatura()
    {
        return $this->codigoAsignatura;
    }

    /**
     * Set nombreAsignatura
     *
     * @param string $nombreAsignatura
     *
     * @return Asignatura
     */
    public function setNombreAsignatura($nombreAsignatura)
    {
        $this->nombreAsignatura = $nombreAsignatura;

        return $this;
    }

    /**
     * Get nombreAsignatura
     *
     * @return string
     */
    public function getNombreAsignatura()
    {
        return $this->nombreAsignatura;
    }

    /**
     * Set tipoAsignatura
     *
     * @param string $tipoAsignatura
     *
     * @return Asignatura
     */
    public function setTipoAsignatura($tipoAsignatura)
    {
        $this->tipoAsignatura = $tipoAsignatura;

        return $this;
    }

    /**
     * Get tipoAsignatura
     *
     * @return string
     */
    public function getTipoAsignatura()
    {
        return $this->tipoAsignatura;
    }

    /**
     * Set hsSemanales
     *
     * @param string $hsSemanales
     *
     * @return Asignatura
     */
    public function setHsSemanales($hsSemanales)
    {
        $this->hsSemanales = $hsSemanales;

        return $this;
    }

    /**
     * Get hsSemanales
     *
     * @return string
     */
    public function getHsSemanales()
    {
        return $this->hsSemanales;
    }

    /**
     * Set cargaHoraria
     *
     * @param string $cargaHoraria
     *
     * @return Asignatura
     */
    public function setCargaHoraria($cargaHoraria)
    {
        $this->cargaHoraria = $cargaHoraria;

        return $this;
    }

    /**
     * Get cargaHoraria
     *
     * @return string
     */
    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    /**
     * Set valorAsignatura
     *
     * @param string $valorAsignatura
     *
     * @return Asignatura
     */
    public function setValorAsignatura($valorAsignatura)
    {
        $this->valorAsignatura = $valorAsignatura;

        return $this;
    }

    /**
     * Get valorAsignatura
     *
     * @return string
     */
    public function getValorAsignatura()
    {
        return $this->valorAsignatura;
    }

    /**
     * Set promediable
     *
     * @param boolean $promediable
     *
     * @return Asignatura
     */
    public function setPromediable($promediable)
    {
        $this->promediable = $promediable;

        return $this;
    }

    /**
     * Get promediable
     *
     * @return boolean
     */
    public function getPromediable()
    {
        return $this->promediable;
    }

    /**
     * Set obligatoria
     *
     * @param boolean $obligatoria
     *
     * @return Asignatura
     */
    public function setObligatoria($obligatoria)
    {
        $this->obligatoria = $obligatoria;

        return $this;
    }

    /**
     * Get obligatoria
     *
     * @return boolean
     */
    public function getObligatoria()
    {
        return $this->obligatoria;
    }

    /**
     * Set anioCursada
     *
     * @param integer $anioCursada
     *
     * @return Asignatura
     */
    public function setAnioCursada($anioCursada)
    {
        $this->anioCursada = $anioCursada;

        return $this;
    }

    /**
     * Get anioCursada
     *
     * @return integer
     */
    public function getAnioCursada()
    {
        return $this->anioCursada;
    }

    /**
     * Set periodoCursada
     *
     * @param string $periodoCursada
     *
     * @return Asignatura
     */
    public function setPeriodoCursada($periodoCursada)
    {
        $this->periodoCursada = $periodoCursada;

        return $this;
    }

    /**
     * Get periodoCursada
     *
     * @return string
     */
    public function getPeriodoCursada()
    {
        return $this->periodoCursada;
    }

    /**
     * Set tipoCursada
     *
     * @param string $tipoCursada
     *
     * @return Asignatura
     */
    public function setTipoCursada($tipoCursada)
    {
        $this->tipoCursada = $tipoCursada;

        return $this;
    }

    /**
     * Get tipoCursada
     *
     * @return string
     */
    public function getTipoCursada()
    {
        return $this->tipoCursada;
    }

    /**
     * Get esModulo
     *
     * @return boolean
     */
    public function isModulo()
    {
        return is_null($this->nroModulo);
    }

    /**
     * Set nroModulo
     *
     * @param integer $nroModulo
     *
     * @return Asignatura
     */
    public function setNroModulo($nroModulo)
    {
        $this->nroModulo = $nroModulo;

        return $this;
    }

    /**
     * Get nroModulo
     *
     * @return integer
     */
    public function getNroModulo()
    {
        return $this->nroModulo;
    }

    /**
     * Set carrera
     *
     * @param string $carrera
     *
     * @return Asignatura
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

    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'text' => $this->nombreAsignatura,
            'codigoAsignatura' => $this->codigoAsignatura,
            'nombreAsignatura' => $this->nombreAsignatura,
            'tipoAsignatura' => $this->tipoAsignatura,
            'horasSemanales' => $this->hsSemanales,
            'cargaHoraria' => $this->cargaHoraria,
            'valorAsignatura' => $this->valorAsignatura,
            'obligatoria' => $this->obligatoria,
            'promediable' => $this->promediable,
            'anioCursada' => $this->anioCursada,
            'planCarrera' => $this->carrera->getPlanCarrera(),
            'periodoCursada' => $this->periodoCursada,
            'tipoCursada' => $this->tipoCursada,
            'nroModulo' => $this->nroModulo,
            'esRecursada' => $this->esRecursada,
            'origenWs' => $this->origenWs,
        );
    }

    /**
     * Set origenWs
     *
     * @param boolean $origenWs
     *
     * @return Asignatura
     */
    public function setOrigenWs($origenWs)
    {
        $this->origenWs = $origenWs;

        return $this;
    }

    /**
     * Get origenWs
     *
     * @return boolean
     */
    public function getOrigenWs()
    {
        return $this->origenWs;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return Asignatura
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Get fechaActualizacion
     *
     * @return \DateTime
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

    /**
     * @return bool
     */
    public function esRecursada(): bool
    {
        return $this->esRecursada;
    }

    /**
     * @param bool $esRecursada
     * @return Asignatura
     */
    public function setEsRecursada(bool $esRecursada): Asignatura
    {
        $this->esRecursada = $esRecursada;
        return $this;
    }


}
