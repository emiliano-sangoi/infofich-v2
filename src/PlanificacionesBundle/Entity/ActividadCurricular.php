<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActividadCurricular
 *
 * @ORM\Table(name="planif_actividad_curricular")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\ActividadCurricularRepository")
 */
class ActividadCurricular
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="otras", type="text")
     */
    private $otras;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="text")
     */
    private $contenido;

    /**
     * @var string
     *
     * @ORM\Column(name="carga_horaria_aula", type="decimal", precision=6, scale=1, nullable=true)
     */
    private $cargaHorariaAula;

    /**
     * @var string
     *
     * @ORM\Column(name="carga_horaria_autonomo", type="decimal", precision=6, scale=1, nullable=true)
     */
    private $cargaHorariaAutonomo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return ActividadCurricular
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set otras
     *
     * @param string $otras
     *
     * @return ActividadCurricular
     */
    public function setOtras($otras)
    {
        $this->otras = $otras;

        return $this;
    }

    /**
     * Get otras
     *
     * @return string
     */
    public function getOtras()
    {
        return $this->otras;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return ActividadCurricular
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set cargaHorariaAula
     *
     * @param string $cargaHorariaAula
     *
     * @return ActividadCurricular
     */
    public function setCargaHorariaAula($cargaHorariaAula)
    {
        $this->cargaHorariaAula = $cargaHorariaAula;

        return $this;
    }

    /**
     * Get cargaHorariaAula
     *
     * @return string
     */
    public function getCargaHorariaAula()
    {
        return $this->cargaHorariaAula;
    }

    /**
     * Set cargaHorariaAutonomo
     *
     * @param string $cargaHorariaAutonomo
     *
     * @return ActividadCurricular
     */
    public function setCargaHorariaAutonomo($cargaHorariaAutonomo)
    {
        $this->cargaHorariaAutonomo = $cargaHorariaAutonomo;

        return $this;
    }

    /**
     * Get cargaHorariaAutonomo
     *
     * @return string
     */
    public function getCargaHorariaAutonomo()
    {
        return $this->cargaHorariaAutonomo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return ActividadCurricular
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
}

