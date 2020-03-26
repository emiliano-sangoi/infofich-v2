<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BibliografiaPlanificacion
 *
 * @ORM\Table(name="planif_bibliografia_planificacion")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\BibliografiaPlanificacionRepository")
 */
class BibliografiaPlanificacion
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
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="bibliografiasPlanificacion")
     * @ORM\JoinColumn(name="planif_planificaciones_id", referencedColumnName="id") 
     */
    private $planificacion;
    
    /**
     *
     * @var Bibliografia
     * 
     * @ORM\ManyToOne(targetEntity="Bibliografia")
     * @ORM\JoinColumn(name="planif_bibliografias_id", referencedColumnName="id")
     */
    private $biliografia;
    
    
    /**
     *
     * @var TipoBibliografia
     * 
     * @ORM\ManyToOne(targetEntity="TipoBibliografia")
     * @ORM\JoinColumn(name="planif_tipos_bibliografia_id", referencedColumnName="id")
     */
    private $tipoBibliografia;


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
     * @return BibliografiaPlanificacion
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
     * Set biliografia
     *
     * @param \PlanificacionesBundle\Entity\Bibliografia $biliografia
     *
     * @return BibliografiaPlanificacion
     */
    public function setBiliografia(\PlanificacionesBundle\Entity\Bibliografia $biliografia = null)
    {
        $this->biliografia = $biliografia;

        return $this;
    }

    /**
     * Get biliografia
     *
     * @return \PlanificacionesBundle\Entity\Bibliografia
     */
    public function getBiliografia()
    {
        return $this->biliografia;
    }

    /**
     * Set tipoBibliografia
     *
     * @param \PlanificacionesBundle\Entity\TipoBibliografia $tipoBibliografia
     *
     * @return BibliografiaPlanificacion
     */
    public function setTipoBibliografia(\PlanificacionesBundle\Entity\TipoBibliografia $tipoBibliografia = null)
    {
        $this->tipoBibliografia = $tipoBibliografia;

        return $this;
    }

    /**
     * Get tipoBibliografia
     *
     * @return \PlanificacionesBundle\Entity\TipoBibliografia
     */
    public function getTipoBibliografia()
    {
        return $this->tipoBibliografia;
    }
}
