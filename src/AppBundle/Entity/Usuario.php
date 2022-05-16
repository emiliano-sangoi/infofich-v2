<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * 
 * Usuario
 *
 * @ORM\Table(name="app_usuarios")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 * @UniqueEntity(fields={"username"},
 *     message="El nombre de usuario ingresado ya se encuentra en uso."
 * )
 */
class Usuario implements \Symfony\Component\Security\Core\User\UserInterface, \JsonSerializable{
    
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
     * @ORM\Column(name="username", type="string", length=255, unique=true)
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
     * 
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     * 
     * @var string
     */
    protected $salt;

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
    
    
    /**
     * Indica cuando el usuario fue dado de baja (baja logica).
     * 
     * @var DateTime
     * 
     * @ORM\Column(name="fecha_baja", type="datetime", nullable=true)
     */
    protected $fechaBaja;

    /**
     * @var string
     *
     * @ORM\Column(name="string_recup_pwd", type="string", length=64, nullable=true)
     */
    protected $stringRecupPwd;

    /**
     * Indica cuando el usuario fue dado de baja (baja logica).
     *
     * @var DateTime
     *
     * @ORM\Column(name="fecha_gen_string_recup", type="datetime", nullable=true)
     */
    protected $fechaGenStringRecup;


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
        return $this->roles->toArray();
    }
    
    /**
     * Devuelve los permisos que posee el usuario a partir de los roles que tiene asignado
     * 
     * @return array Codigos de los permisos que posee el usuario.
     */
    public function getPermisos(){
        $permisos = array();
        foreach ($this->roles as $rol){
            $permisos = array_merge($permisos, $rol->getCodigosPermisos());            
        }
        return $permisos;
    }
    
    /**
     * Funcion que verifica si cierto usuario tiene o no el permiso pasado como argumento.
     * 
     * @param int $cod_permiso
     * @return boolean true si lo tiene o false en caso contrario
     */
    public function tienePermiso($cod_permiso){
        $res = false;
        foreach ($this->roles as $rol){
            foreach ($rol->getPermisos() as $permiso){
                if($permiso->getCodigo() == $cod_permiso){
                    $res = true;
                    break 2;
                }
            }
        }
        return $res;
    }
    
    /**
     * Chequea si el usuario tiene asignado el rol pasado como parametro.
     * 
     * @param type $rol
     * @return type
     */
    public function tieneRol($rol){                
        return in_array($rol, $this->getRolesAsStr());                
    }
       

    /**
     * Devuelve los roles como un arreglo de strings
     * 
     * @return array
     */
    public function getRolesAsStr() {
        $roles_str = array();
        foreach ($this->roles as $rol){
            $roles_str[] = $rol->getNombre();
        }
        return $roles_str;        
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

    public function eraseCredentials() {
        
    }

    public function getSalt() {
        return $this->salt;
    }
       


    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     *
     * @return Usuario
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

    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'username' => $this->username,            
        );
    }


    /**
     * Set stringRecupPwd
     *
     * @param string $stringRecupPwd
     *
     * @return Usuario
     */
    public function setStringRecupPwd($stringRecupPwd)
    {
        $this->stringRecupPwd = $stringRecupPwd;

        return $this;
    }

    /**
     * Get stringRecupPwd
     *
     * @return string
     */
    public function getStringRecupPwd()
    {
        return $this->stringRecupPwd;
    }

    /**
     * @return DateTime
     */
    public function getFechaGenStringRecup()
    {
        return $this->fechaGenStringRecup;
    }

    /**
     * @param DateTime $fechaGenStringRecup
     */
    public function setFechaGenStringRecup($fechaGenStringRecup)
    {
        $this->fechaGenStringRecup = $fechaGenStringRecup;
    }





}
