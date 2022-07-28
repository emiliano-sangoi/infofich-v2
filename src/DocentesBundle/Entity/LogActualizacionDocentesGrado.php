<?php

namespace DocentesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LogActualizacionDocentesGrado
 *
 * @ORM\Table(name="log_actualizacion_docentes_grado")
 * @ORM\Entity(repositoryClass="DocentesBundle\Repository\LogActualizacionDocentesGradoRepository")
 */
class LogActualizacionDocentesGrado
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
     * @ORM\Column(name="fechaActualizacion", type="datetime")
     */
    private $fechaActualizacion;

    /**
     * @var int
     *
     * @ORM\Column(name="cantNuevos", type="integer")
     */
    private $cantNuevos;

    /**
     * @var int
     *
     * @ORM\Column(name="cantActualizados", type="integer")
     */
    private $cantActualizados;

    /**
     * @var int
     *
     * @ORM\Column(name="cantDesactivados", type="integer")
     */
    private $cantDesactivados;

    /**
     * @var string
     *
     * @ORM\Column(name="logTxt", type="text", nullable=true)
     */
    private $logTxt;

    public function __construct()
    {
        $this->fechaActualizacion = new \DateTime();
    }

    public function __toString()
    {
        return 'Log ' . $this->fechaActualizacion->format('Ymd - H:i');
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
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return AudDocenteGrado
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
     * Set cantNuevos
     *
     * @param integer $cantNuevos
     *
     * @return AudDocenteGrado
     */
    public function setCantNuevos($cantNuevos)
    {
        $this->cantNuevos = $cantNuevos;

        return $this;
    }

    /**
     * Get cantNuevos
     *
     * @return int
     */
    public function getCantNuevos()
    {
        return $this->cantNuevos;
    }

    /**
     * Set cantActualizados
     *
     * @param integer $cantActualizados
     *
     * @return AudDocenteGrado
     */
    public function setCantActualizados($cantActualizados)
    {
        $this->cantActualizados = $cantActualizados;

        return $this;
    }

    /**
     * Get cantActualizados
     *
     * @return int
     */
    public function getCantActualizados()
    {
        return $this->cantActualizados;
    }

    /**
     * Set cantDesactivados
     *
     * @param integer $cantDesactivados
     *
     * @return AudDocenteGrado
     */
    public function setCantDesactivados($cantDesactivados)
    {
        $this->cantDesactivados = $cantDesactivados;

        return $this;
    }

    /**
     * Get cantDesactivados
     *
     * @return int
     */
    public function getCantDesactivados()
    {
        return $this->cantDesactivados;
    }

    /**
     * Set logTxt
     *
     * @param string $logTxt
     *
     * @return AudDocenteGrado
     */
    public function setLogTxt($logTxt)
    {
        $this->logTxt = $logTxt;

        return $this;
    }

    /**
     * Get logTxt
     *
     * @return string
     */
    public function getLogTxt()
    {
        return $this->logTxt;
    }
}

