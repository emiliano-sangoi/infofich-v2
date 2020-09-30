<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Docente
 *
 * @ORM\Table(name="planif_docentes")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\DocenteRepository")
 */
class Docente
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
     * @var \AppBundle\Entity\Persona
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Persona", cascade={"persist"},fetch="EAGER")
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id", nullable=false)
     * 
     */
    private $persona;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_legajo", type="string", length=64, nullable=true)
     */
    private $nroLegajo;
    
        /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getCodApeNom($apellido_uppercase = false){
        return $this->nroLegajo . ' - ' . $this->persona->getApeNom($apellido_uppercase);
    }

        /**
     * Set nroLegajo
     *
     * @param string $nroLegajo
     *
     * @return Docente
     */
    public function setNroLegajo($nroLegajo)
    {
        $this->nroLegajo = $nroLegajo;

        return $this;
    }

    /**
     * Get nroLegajo
     *
     * @return string
     */
    public function getNroLegajo()
    {
        return $this->nroLegajo;
    }

    /**
     * Set persona
     *
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return Docente
     */
    public function setPersona(\AppBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \AppBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Docente
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
