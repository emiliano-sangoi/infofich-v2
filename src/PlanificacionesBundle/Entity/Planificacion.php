<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $objetivosGral;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivos_especificos", type="text", nullable=true)
     */
    private $objetivosEspecificos;


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
}

