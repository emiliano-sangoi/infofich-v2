<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * HistoricoEstados
 *
 * @ORM\Table(name="planif_historico_estados_planif", uniqueConstraints={
 *        @ORM\UniqueConstraint(name="ak_historico_estados", 
 *            columns={"planif_planificaciones_id", "planif_estados_id", "fecha_desde"})
 *    })
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\HistoricoEstadosRepository")
 */
class HistoricoEstados
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
     * @ORM\Column(name="fecha_desde", type="datetime")
     */
    private $fechaDesde;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_hasta", type="datetime", nullable=true)
     */
    private $fechaHasta;
    
    /**
     *
     * @var Estado
     * 
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumn(name="planif_estados_id", referencedColumnName="id") 
     */
    private $estado;
    
    
    /**
     *
     * @var Planificacion
     * 
     * @ORM\ManyToOne(targetEntity="Planificacion", inversedBy="historicosEstado")
     * @ORM\JoinColumn(name="planif_planificaciones_id", referencedColumnName="id") 
     */
    private $planificacion;
    
    
    /**
     * 
     * @var AppBundle\Entity\Usuario
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;
    
    
    public function __construct() {
        $this->fechaDesde = new \DateTime();
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
     * Set fechaDesde
     *
     * @param \DateTime $fechaDesde
     *
     * @return HistoricoEstados
     */
    public function setFechaDesde($fechaDesde)
    {
        $this->fechaDesde = $fechaDesde;

        return $this;
    }

    /**
     * Get fechaDesde
     *
     * @return \DateTime
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * Set fechaHasta
     *
     * @param \DateTime $fechaHasta
     *
     * @return HistoricoEstados
     */
    public function setFechaHasta($fechaHasta)
    {
        $this->fechaHasta = $fechaHasta;

        return $this;
    }

    /**
     * Get fechaHasta
     *
     * @return \DateTime
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * Set estado
     *
     * @param \PlanificacionesBundle\Entity\Estado $estado
     *
     * @return HistoricoEstados
     */
    public function setEstado(\PlanificacionesBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \PlanificacionesBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return HistoricoEstados
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
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return HistoricoEstados
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
