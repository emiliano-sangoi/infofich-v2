<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * Usuario
 *
 * @ORM\Table(name="app_usuarios")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 */
class Usuario{
    
    const PLAIN_PWD_MIN_LENGTH = 8;    
    const PLAIN_PWD_MAX_LENGTH = 24;
    const USERNAME_MIN_LENGTH = 6;
    const USERNAME_MAX_LENGTH = 24;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     * @var Persona
     * 
     * @ORM\OneToOne(targetEntity="Persona", cascade={"persist"})
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id", nullable=false)
     */
    protected $persona;

    /**
     *
     * @var DateTime
     * 
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    protected $fechaCreacion;

    /**
     * 
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank(message="El nombre de usuario no puede quedar vacio.")
     * @Assert\Length(
     *      min = Usuario::USERNAME_MIN_LENGTH,
     *      max = Usuario::USERNAME_MAX_LENGTH,
     *      minMessage = "El nombre de usuario debe tener al menos {{ limit }} caracteres.",
     *      maxMessage = "La contraseña puede tener a lo sumo {{ limit }} caracteres."
     * )
     * 
     * @var string
     */
    protected $username;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="bloqueado", type="boolean")
     */
    protected $bloqueado;

    /**
     * Hash de la contraseña
     * 
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\NotBlank(message="El campo contraseña es obligatorio.")
     * @Assert\Length(
     *      min = Usuario::PLAIN_PWD_MIN_LENGTH,
     *      max = Usuario::PLAIN_PWD_MAX_LENGTH,
     *      minMessage = "La contraseña debe tener al menos {{ limit }} caracteres.",
     *      maxMessage = "La contraseña puede tener a lo sumo {{ limit }} caracteres."
     * )
     *
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(name="ultimo_ingreso", type="datetime", nullable=true)
     */
    protected $ultimoIngreso;

    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="Rol") 
     * @ORM\JoinTable(name="app_usuario_roles",
     *      joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")}
     *      )
     */
    protected $roles;



    public function __construct() {
        
        $this->roles = new ArrayCollection();
        $this->fechaCreacion = new DateTime();
        $this->bloqueado = false;
    }

    


    /**
     * Returns the user roles
     *
     * @return array The roles
     */
    public function getRoles() {

        return array('ROLE_ADMIN');


        // TODO: Revisar

        $roles = $this->getRoles();

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        return array_unique($roles);
    }

    /**
     * Get id
     *
     * @return integer
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
     * @return Usuario
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
     * Set username
     *
     * @param string $username
     *
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set bloqueado
     *
     * @param boolean $bloqueado
     *
     * @return Usuario
     */
    public function setBloqueado($bloqueado)
    {
        $this->bloqueado = $bloqueado;

        return $this;
    }

    /**
     * Get bloqueado
     *
     * @return boolean
     */
    public function getBloqueado()
    {
        return $this->bloqueado;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set ultimoIngreso
     *
     * @param \DateTime $ultimoIngreso
     *
     * @return Usuario
     */
    public function setUltimoIngreso($ultimoIngreso)
    {
        $this->ultimoIngreso = $ultimoIngreso;

        return $this;
    }

    /**
     * Get ultimoIngreso
     *
     * @return \DateTime
     */
    public function getUltimoIngreso()
    {
        return $this->ultimoIngreso;
    }

    /**
     * Set persona
     *
     * @param \AppBundle\Entity\Persona $persona
     *
     * @return Usuario
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
     * Add role
     *
     * @param \AppBundle\Entity\Rol $role
     *
     * @return Usuario
     */
    public function addRole(\AppBundle\Entity\Rol $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \AppBundle\Entity\Rol $role
     */
    public function removeRole(\AppBundle\Entity\Rol $role)
    {
        $this->roles->removeElement($role);
    }
    
    public function __toString() {
        return $this->username;
    }
}
