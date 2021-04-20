<?php

namespace DocentesBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PlanificacionesBundle\Entity\Planificacion;

/**
 * Docente
 *
 * @ORM\Table(name="docentes_grado", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="unique_docente_grado", columns={"nro_legajo"})
 * })
 * @ORM\Entity(repositoryClass="DocentesBundle\Repository\DocenteGradoRepository")
 */
class DocenteGrado extends Docente {

    /**
     * @var string
     *
     * @ORM\Column(name="nro_legajo", type="string", length=64, nullable=true, unique=true)
     */
    private $nroLegajo;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="PlanificacionesBundle\Entity\Planificacion", mappedBy="docenteResponsable")
     */
    private $planificacionesResponsable;
    
    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="PlanificacionesBundle\Entity\PlanificacionDocenteColaborador", mappedBy="docenteGrado")
     */
    private $planificacionesColaborador;
    
    
    public function __construct() {
        $this->planificacionesColaborador = new ArrayCollection();
    }
   

    public function __toString() {
        return $this->persona->getApeNom(false);
    }
    
    public function getDescripcion() {
        return 'Legajo: ' . $this->nroLegajo . ' / ' . $this->persona->getTipoYNroDocumento() . ' / ' .  $this->persona->getApeNom(false);
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
     * @param DateTime $fechaInactivo
     *
     * @return DocenteGrado
     */
    public function setFechaInactivo($fechaInactivo) {
        $this->fechaInactivo = $fechaInactivo;

        return $this;
    }

    /**
     * Get fechaInactivo
     *
     * @return DateTime
     */
    public function getFechaInactivo() {
        return $this->fechaInactivo;
    }


  

    /**
     * Add planificacione
     *
     * @param Planificacion $planificacione
     *
     * @return DocenteGrado
     */
    public function addPlanificacione(Planificacion $planificacione)
    {
        $this->planificaciones[] = $planificacione;

        return $this;
    }

    /**
     * Remove planificacione
     *
     * @param Planificacion $planificacione
     */
    public function removePlanificacione(Planificacion $planificacione)
    {
        $this->planificaciones->removeElement($planificacione);
    }

    /**
     * Get planificaciones
     *
     * @return Collection
     */
    public function getPlanificaciones()
    {
        return $this->planificaciones;
    }

    /**
     * Add planificacionesColaborador
     *
     * @param \PlanificacionesBundle\Entity\PlanificacionDocenteColaborador $planificacionesColaborador
     *
     * @return DocenteGrado
     */
    public function addPlanificacionesColaborador(\PlanificacionesBundle\Entity\PlanificacionDocenteColaborador $planificacionesColaborador)
    {
        $this->planificacionesColaborador[] = $planificacionesColaborador;

        return $this;
    }

    /**
     * Remove planificacionesColaborador
     *
     * @param \PlanificacionesBundle\Entity\PlanificacionDocenteColaborador $planificacionesColaborador
     */
    public function removePlanificacionesColaborador(\PlanificacionesBundle\Entity\PlanificacionDocenteColaborador $planificacionesColaborador)
    {
        $this->planificacionesColaborador->removeElement($planificacionesColaborador);
    }

    /**
     * Get planificacionesColaborador
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlanificacionesColaborador()
    {
        return $this->planificacionesColaborador;
    }

    /**
     * Add planificacionesResponsable
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacionesResponsable
     *
     * @return DocenteGrado
     */
    public function addPlanificacionesResponsable(\PlanificacionesBundle\Entity\Planificacion $planificacionesResponsable)
    {
        $this->planificacionesResponsable[] = $planificacionesResponsable;

        return $this;
    }

    /**
     * Remove planificacionesResponsable
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacionesResponsable
     */
    public function removePlanificacionesResponsable(\PlanificacionesBundle\Entity\Planificacion $planificacionesResponsable)
    {
        $this->planificacionesResponsable->removeElement($planificacionesResponsable);
    }

    /**
     * Get planificacionesResponsable
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlanificacionesResponsable()
    {
        return $this->planificacionesResponsable;
    }
}
