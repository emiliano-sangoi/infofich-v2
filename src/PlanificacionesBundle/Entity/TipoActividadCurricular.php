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

    const ACTIVIDAD1 = 'Ejemplo1';
    const ACTIVIDAD2 = 'Ejemplo2';
    const ACTIVIDAD3 = 'Ejemplo3';
    const ACTIVIDAD4 = 'Ejemplo4';

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
