<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoActividadCurricular
 *
 * @ORM\Table(name="planif_tipos_actividad_curricular")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\TipoActividadCurricularRepository")
 */
class TipoActividadCurricular {

    const ACTIVIDAD1 = 'Clase teórica';
    const ACTIVIDAD2 = 'Coloquio';
    const ACTIVIDAD3 = 'Seminario';
    const ACTIVIDAD4 = 'Trabajo práctico';
    const ACTIVIDAD5 = 'Taller';
    const ACTIVIDAD6 = 'Clase teórico–práctica';
    const ACTIVIDAD7 = 'Resolución de problemas';
    const ACTIVIDAD8 = 'Consulta';
    const ACTIVIDAD9 = 'Evaluaciones en sus diversas modalidades';
    const ACTIVIDAD10 = 'Empleo de plataformas virtuales de aprendizaje';
    const ACTIVIDAD11 = 'Otras actividades';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=64, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=512, nullable=true)
     */
    private $descripcion;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TipoActividadCurricular
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TipoActividadCurricular
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

    public function __toString() {
        return $this->nombre;
    }

}
