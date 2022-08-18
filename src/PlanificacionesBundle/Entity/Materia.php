<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Materia
 *
 * Campos devueltos por el web service:
 *      #codigoMateria: "FICHIF021"
 *      #nombreMateria: "COMPUTACIÓN GRÁFICA"
 *      #tipoMateria: "N"
 *      #horasSemanales: "7.00"
 *      #cargaHoraria: "105.00"
 *      #valorMateria: "7.00"
 *      #promediable: true
 *      #obligatoria: false
 *      #anioCursada: "3"
 *      #periodoCursada: "2do Cuatrimestre"
 *      #tipoCursada: "cuatrimestre"
 *
 * @ORM\Table(name="planif_materias", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="ak_planif_materias", columns={"codigo_materia", "nro_modulo"})
 * })
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\MateriaRepository")
 */
class Materia implements \JsonSerializable
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
     * @var string
     *
     * @ORM\Column(name="codigo_materia", type="string", length=12, unique=true)
     */
    private $codigoMateria;

    /**
     * Nombre de la materia
     *
     * @var string
     *
     * @ORM\Column(name="nombre_materia", type="string", length=256)
     */
    private $nombreMateria;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_materia", type="string", length=1)
     */
    private $tipoMateria;

    /**
     * @var float
     *
     * @ORM\Column(name="hs_semanales", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $hsSemanales;

    /**
     * @var float
     *
     * @ORM\Column(name="hs_carga_horaria", type="decimal", precision=6, scale=2)
     */
    private $cargaHoraria;

    /**
     * @var float
     *
     * @ORM\Column(name="hs_valor_materia", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $valorMateria;

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
     * @ORM\Column(name="anio_cursada", type="integer")
     */
    private $anioCursada;

    /**
     * @var string
     *
     * @ORM\Column(name="periodo_cursada", type="string", length=24)
     */
    private $periodoCursada;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_cursada", type="string", length=24)
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
       return $this->nombreMateria;
   }

    /**
     * Set codigoMateria
     *
     * @param string $codigoMateria
     *
     * @return Materia
     */
    public function setCodigoMateria($codigoMateria)
    {
        $this->codigoMateria = $codigoMateria;

        return $this;
    }

    /**
     * Get codigoMateria
     *
     * @return string
     */
    public function getCodigoMateria()
    {
        return $this->codigoMateria;
    }

    /**
     * Set nombreAsignatura
     *
     * @param string $nombreMateria
     *
     * @return Materia
     */
    public function setNombreMateria($nombreMateria)
    {
        $this->nombreMateria = $nombreMateria;

        return $this;
    }

    /**
     * Get nombreMateria
     *
     * @return string
     */
    public function getNombreMateria()
    {
        return $this->nombreMateria;
    }

    /**
     * Set tipoMateria
     *
     * @param string $tipoMateria
     *
     * @return Materia
     */
    public function setTipoMateria($tipoMateria)
    {
        $this->tipoMateria = $tipoMateria;

        return $this;
    }

    /**
     * Get tipoMateria
     *
     * @return string
     */
    public function getTipoMateria()
    {
        return $this->tipoMateria;
    }

    /**
     * Set hsSemanales
     *
     * @param string $hsSemanales
     *
     * @return Materia
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
     * @return Materia
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
     * Set valorMateria
     *
     * @param string $valorMateria
     *
     * @return Materia
     */
    public function setValorMateria($valorMateria)
    {
        $this->valorMateria = $valorMateria;

        return $this;
    }

    /**
     * Get valorMateria
     *
     * @return string
     */
    public function getValorMateria()
    {
        return $this->valorMateria;
    }

    /**
     * Set promediable
     *
     * @param boolean $promediable
     *
     * @return Materia
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
     * @return Materia
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
     * @return Materia
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
     * @return Materia
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
     * @return Materia
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
     * @return Materia
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
     * @return Materia
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
            'codigoMateria' => $this->codigoMateria,
            'nombreMateria' => $this->nombreMateria,
            'tipoMateria' => $this->tipoMateria,
            'horasSemanales' => $this->hsSemanales,
            'cargaHoraria' => $this->cargaHoraria,
            'valorMateria' => $this->valorMateria,
            'obligatoria' => $this->obligatoria,
            'promediable' => $this->promediable,
            'anioCursada' => $this->anioCursada,
            'periodoCursada' => $this->periodoCursada,
            'tipoCursada' => $this->tipoCursada,
            'nroModulo' => $this->nroModulo
        );
    }
}
