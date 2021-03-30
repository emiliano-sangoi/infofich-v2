<?php

namespace DocentesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Docente
 *
 * @ORM\Table(name="docentes_adscriptos", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unique_docente_adscripto", columns={"resolucion", "persona_id"})
 * })
 * @ORM\Entity(repositoryClass="DocentesBundle\Repository\DocenteAdscriptoRepository")
 */
class DocenteAdscripto extends Docente {

    /**
     * Resolucion del concejo directivo
     * 
     * @var string
     *
     * @ORM\Column(name="resolucion", type="string", length=64)
     */
    private $resolucion;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto", mappedBy="docenteAdscripto")
     */
    private $planificacionesAdscripto;
    

    public function __construct() {
        $this->planificaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString() {
        return $this->resolucion . ' - ' . $this->persona->getApeNom($apellido_uppercase);
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

    /**
     * Add planificacionesAdscripto
     *
     * @param \PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto $planificacionesAdscripto
     *
     * @return DocenteAdscripto
     */
    public function addPlanificacionesAdscripto(\PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto $planificacionesAdscripto)
    {
        $this->planificacionesAdscripto[] = $planificacionesAdscripto;

        return $this;
    }

    /**
     * Remove planificacionesAdscripto
     *
     * @param \PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto $planificacionesAdscripto
     */
    public function removePlanificacionesAdscripto(\PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto $planificacionesAdscripto)
    {
        $this->planificacionesAdscripto->removeElement($planificacionesAdscripto);
    }

    /**
     * Get planificacionesAdscripto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlanificacionesAdscripto()
    {
        return $this->planificacionesAdscripto;
    }

    /**
     * Set resolucion
     *
     * @param string $resolucion
     *
     * @return DocenteAdscripto
     */
    public function setResolucion($resolucion)
    {
        $this->resolucion = $resolucion;

        return $this;
    }

    /**
     * Get resolucion
     *
     * @return string
     */
    public function getResolucion()
    {
        return $this->resolucion;
    }
}
