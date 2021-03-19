<?php

namespace DocentesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Docente
 *
 * @ORM\Table(name="planif_docentes_adscriptos")
 * @ORM\Entity(repositoryClass="DocentesBundle\Repository\DocenteAdscriptoRepository")
 */
class DocenteAdscripto extends Docente {

    /**
     * @var string
     *
     * @ORM\Column(name="nro_legajo", type="string", length=64, nullable=true)
     */
    private $nroLegajo;

    /**
     * Many Groups have Many Users.
     * 
     * @ORM\ManyToMany(targetEntity="PlanificacionesBundle\Entity\Planificacion", mappedBy="docentesAdscriptos")
     */
    private $planificaciones;

    public function __construct() {
        $this->planificaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getCodApeNom($apellido_uppercase = false) {
        return $this->nroLegajo . ' - ' . $this->persona->getApeNom($apellido_uppercase);
    }

    /**
     * Set nroLegajo
     *
     * @param string $nroLegajo
     *
     * @return Docente
     */
    public function setNroLegajo($nroLegajo) {
        $this->nroLegajo = $nroLegajo;

        return $this;
    }

    /**
     * Get nroLegajo
     *
     * @return string
     */
    public function getNroLegajo() {
        return $this->nroLegajo;
    }


    /**
     * Set fechaInactivo
     *
     * @param \DateTime $fechaInactivo
     *
     * @return DocenteAdscripto
     */
    public function setFechaInactivo($fechaInactivo)
    {
        $this->fechaInactivo = $fechaInactivo;

        return $this;
    }

    /**
     * Get fechaInactivo
     *
     * @return \DateTime
     */
    public function getFechaInactivo()
    {
        return $this->fechaInactivo;
    }

    /**
     * Add planificacione
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacione
     *
     * @return DocenteAdscripto
     */
    public function addPlanificacione(\PlanificacionesBundle\Entity\Planificacion $planificacione)
    {
        $this->planificaciones[] = $planificacione;

        return $this;
    }

    /**
     * Remove planificacione
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacione
     */
    public function removePlanificacione(\PlanificacionesBundle\Entity\Planificacion $planificacione)
    {
        $this->planificaciones->removeElement($planificacione);
    }

    /**
     * Get planificaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlanificaciones()
    {
        return $this->planificaciones;
    }
}
