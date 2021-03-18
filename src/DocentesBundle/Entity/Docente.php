<?php

namespace DocentesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Docente
 *
 * 
 * @ORM\MappedSuperclass
 */
class Docente {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \AppBundle\Entity\Persona
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Persona", cascade={"persist"},fetch="EAGER")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id", nullable=false)
     * @Assert\Valid
     * 
     */
    protected $persona;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;
    
     /**
     * Fecha en la que el docente se da de baja.
     * 
     * @var DateTime
     * 
     * @ORM\Column(name="fecha_inactivo", type="datetime", nullable=true)
     */
    protected $fechaInactivo;   
    
    /**
     * Fecha en la que fue actualizado por ultima vez.
     * 
     * @var DateTime
     * 
     * @ORM\Column(name="fecha_ultima_act", type="datetime", nullable=true)
     */
    protected $fechaUltimaActualizacion;   

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set persona
     *
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return Docente
     */
    public function setPersona(\AppBundle\Entity\Persona $persona = null) {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \AppBundle\Entity\Persona
     */
    public function getPersona() {
        return $this->persona;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Docente
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }
    
        /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     *
     * @return Docente
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }
    
      /**
     * Set fechaUltimaActualizacion
     *
     * @param \DateTime $fechaUltimaActualizacion
     *
     * @return DocenteGrado
     */
    public function setFechaUltimaActualizacion(\DateTime $fechaUltimaActualizacion)
    {
        $this->fechaUltimaActualizacion = $fechaUltimaActualizacion;

        return $this;
    }

    /**
     * Get fechaUltimaActualizacion
     *
     * @return \DateTime
     */
    public function getFechaUltimaActualizacion()
    {
        return $this->fechaUltimaActualizacion;
    }

}
