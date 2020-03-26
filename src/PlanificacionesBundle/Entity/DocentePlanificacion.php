<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocentePlanificacion
 *
 * @ORM\Table(name="planif_docente_planificacion")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\DocentePlanificacionRepository")
 */
class DocentePlanificacion
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
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="docentesPlanificacion")
     * @ORM\JoinColumn(name="planif_planificaciones_id", referencedColumnName="id") 
     */
    private $planificacion;
    
    /**
     *
     * @var Docente
     * 
     * @ORM\ManyToOne(targetEntity="Docente")
     * @ORM\JoinColumn(name="planif_docentes_id", referencedColumnName="id") 
     */
    private $docente;
    
    /**
     *
     * @var TipoDocente
     * 
     * @ORM\ManyToOne(targetEntity="TipoDocente")
     * @ORM\JoinColumn(name="planif_tipos_docente_id", referencedColumnName="id") 
     */
    private $tipoDocente;


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
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return DocentePlanificacion
     */
    public function setPlanificacion(\PlanificacionesBundle\Entity\Planificacion $planificacion = null)
    {
        $this->planificacion = $planificacion;

        return $this;
    }

    /**
     * Get planificacion
     *
     * @return \PlanificacionesBundle\Entity\Planificacion
     */
    public function getPlanificacion()
    {
        return $this->planificacion;
    }

    /**
     * Set docente
     *
     * @param \PlanificacionesBundle\Entity\Docente $docente
     *
     * @return DocentePlanificacion
     */
    public function setDocente(\PlanificacionesBundle\Entity\Docente $docente = null)
    {
        $this->docente = $docente;

        return $this;
    }

    /**
     * Get docente
     *
     * @return \PlanificacionesBundle\Entity\Docente
     */
    public function getDocente()
    {
        return $this->docente;
    }

    /**
     * Set tipoDocente
     *
     * @param \PlanificacionesBundle\Entity\TipoDocente $tipoDocente
     *
     * @return DocentePlanificacion
     */
    public function setTipoDocente(\PlanificacionesBundle\Entity\TipoDocente $tipoDocente = null)
    {
        $this->tipoDocente = $tipoDocente;

        return $this;
    }

    /**
     * Get tipoDocente
     *
     * @return \PlanificacionesBundle\Entity\TipoDocente
     */
    public function getTipoDocente()
    {
        return $this->tipoDocente;
    }
}
