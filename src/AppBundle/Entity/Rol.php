<?php

namespace AppBundle\Entity;

use AppBundle\Repository\RolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rol
 *
 * @ORM\Table(name="app_roles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RolRepository")
 */
class Rol implements \Symfony\Component\Security\Core\Role\RoleInterface {
    
    // constantes para usar y 
    // buscar utilizando el campo código:
    
    const ADMIN = 1;
    const SEC_ACAD = 2;
    

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
     * @var integer 
     * 
     * @ORM\Column(name="codigo", type="integer", unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;
    
     /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;    
    
    /**
     * 
     * @var ArrayCollection 
     * 
     * @ORM\ManyToMany(targetEntity="Permiso", inversedBy="roles")
     * @ORM\JoinTable(name="app_roles_permisos",
     *      joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="permiso_id", referencedColumnName="id")}
     *      )
     */
    private $permisos;
    

    public function __construct() {
        $this->permisos = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->nombre;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Rol
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Rol
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }


    /**
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return Rol
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Add permiso
     *
     * @param \AppBundle\Entity\Permiso $permiso
     *
     * @return Rol
     */
    public function addPermiso(\AppBundle\Entity\Permiso $permiso)
    {
        $this->permisos[] = $permiso;                

        return $this;
    }

    /**
     * Remove permiso
     *
     * @param \AppBundle\Entity\Permiso $permiso
     */
    public function removePermiso(\AppBundle\Entity\Permiso $permiso)
    {
        $this->permisos->removeElement($permiso);
    }

    /**
     * Get permisos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPermisos()
    {
        return $this->permisos;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Rol
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getRole() {
        return $this->nombre;        
    }

}
