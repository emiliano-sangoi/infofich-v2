<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/*
 * @ORM\MappedSuperclass 
 */
abstract class DocentePlanificacion
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
     * @var Docente
     * 
     * @ORM\ManyToOne(targetEntity="Docente", cascade={"persist"})
     * @ORM\JoinColumn(name="planif_docentes_id", referencedColumnName="id") 
     */
    private $docente;   
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fechaCreacion;
    
    public function __construct() {
        $this->fechaCreacion = new \DateTime();
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return DocentePlanificacion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
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
}
