<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/*
 * Temario
 *
 * @ORM\Table(name="planif_temarios", uniqueConstraints={
 *        @ORM\UniqueConstraint(name="ak_planif_temarios", columns={"unidad"})
 * })
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\TemarioRepository")
 *
 */


/**
 * Temario
 *
 * @ORM\Table(name="planif_temarios")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\TemarioRepository")
 *
 */
class Temario {

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
     * @ORM\Column(name="unidad", type="smallint")
     * @Assert\Type(
     *     type="int",
     *     message="La unidad del tema debe ser un número entero")
     */
    private $unidad;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=512)
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="contenido", type="text", nullable=true)
     */
    private $contenido;

    /**
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="temario")
     * @ORM\JoinColumn(name="planif_planificaciones_id", referencedColumnName="id") 
     */
    private $planificacion;

    /**
     * Un temario tiene muchas actividades.
     * 
     * @ORM\OneToMany(targetEntity="ActividadCurricular", mappedBy="temario", cascade={"persist","remove"})
     */
    private $actividades;

    public function __construct() {
        $this->actividades = new ArrayCollection();
    }

    public function incrementarUnidad(){
        $this->unidad++;
        return $this;
    }

    public function __toString() {
        return $this->titulo;
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
     * Set unidad
     *
     * @param integer $unidad
     *
     * @return Temario
     */
    public function setUnidad($unidad) {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * Get unidad
     *
     * @return int
     */
    public function getUnidad() {
        return $this->unidad;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Temario
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     *
     * @return Temario
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
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return Temario
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

    /**
     * Add actividade
     *
     * @param \PlanificacionesBundle\Entity\ActividadCurricular $actividade
     *
     * @return Temario
     */
    public function addActividade(\PlanificacionesBundle\Entity\ActividadCurricular $actividade) {
        $this->actividades[] = $actividade;

        return $this;
    }

    /**
     * Remove actividade
     *
     * @param \PlanificacionesBundle\Entity\ActividadCurricular $actividade
     */
    public function removeActividade(\PlanificacionesBundle\Entity\ActividadCurricular $actividade) {
        $this->actividades->removeElement($actividade);
    }

    /**
     * Get actividades
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActividades() {
        return $this->actividades;
    }

    public function getActividadesOrdPorFecha() {

        $actividades = $this->actividades->toArray();
        usort($actividades, function ($a1, $a2) {
            return $a1->getFecha()->getTimestamp() > $a2->getFecha()->getTimestamp();
        });

        return $actividades;
    }

}
