<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persona
 *
 * @ORM\Table(name="app_personas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonaRepository")
 * 
 * @ORM\HasLifecycleCallbacks()
 */
class Persona
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
     * @ORM\Column(name="apellidos", type="string", length=512)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=512)
     */
    private $nombres;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_documento", type="smallint", nullable=true)
     */
    private $tipoDocumento;
    
    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=12, unique=true)
     */
    private $documento;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="cuil", type="string", length=16, nullable=true, unique=true)
     */
    private $cuil;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=32, nullable=true)
     */
    private $telefono;
    
    public function __toString() {
        return $this->apellidos . ', ' . $this->nombres;
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
     * Get apellido y nombre
     *
     * @return string
     */
    public function getApeNom($apellido_uppercase = false)
    {
        $s = $apellido_uppercase ? strtoupper($this->apellidos) : $this->apellidos;
        return $s . ', ' . $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Persona
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return Persona
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return Persona
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }
    
    /**
     * Get tipo documento
     *
     * @return integer
     */
    function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    /**
     * 
     * @param integer $tipoDocumento
     * 
     * @return $this
     */
    function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
        return $this;
    }

    
    /**
     * Set email
     *
     * @param string $email
     *
     * @return Persona
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

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Persona
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set cuil
     *
     * @param string $cuil
     *
     * @return Persona
     */
    public function setCuil($cuil)
    {
        $this->cuil = $cuil;

        return $this;
    }

    /**
     * Get cuil
     *
     * @return string
     */
    public function getCuil()
    {
        return $this->cuil;
    }
}
