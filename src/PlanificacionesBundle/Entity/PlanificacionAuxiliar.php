<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planificacion Auxiliar
 *
 * @ORM\Table(name="planif_planificaciones_aux")
 */
class PlanificacionAuxiliar
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
     * @var string
     *
     * @ORM\Column(name="codigo_guarani", type="string", length=24, unique=true)
     */
    private $codigoGuarani;

    /**
     * Nombre de la asignatura
     * 
     * @var Asignatura
     * 
     * @ORM\Column(name="nombre_asignatura", type="string", length=256)
     */
    private $nombreAsignatura;

    /**
     * @ORM\Column(name="posicion", type="integer", nullable=true)
     */
    private $posicion;


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
     * Set codigoGuarani
     *
     * @param string $codigoGuarani
     *
     * @return Asignatura
     */
    public function setCodigoGuarani($codigoGuarani)
    {
        $this->codigoGuarani = $codigoGuarani;

        return $this;
    }

    /**
     * Get codigoGuarani
     *
     * @return string
     */
    public function getCodigoGuarani()
    {
        return $this->codigoGuarani;
    }

    /**
     * Set nombreAsignatura
     *
     * @param string $nombreAsignatura
     *
     * @return Planificacion
     */
    public function setNombreAsignatura($nombreAsignatura) {
        $this->nombreAsignatura = $nombreAsignatura;

        return $this;
    }

    /**
     * Get nombreAsignatura
     *
     * @return string
     */
    public function getNombreAsignatura() {
        return $this->nombreAsignatura;
    }

    /**
     * Set posicion
     *
     * @param integer $posicion
     *
     * @return Bibliografia
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get posicion
     *
     * @return integer
     */
    public function getPosicion()
    {
        return $this->posicion;
    }
}
