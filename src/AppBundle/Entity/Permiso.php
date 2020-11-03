<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Permiso
 *
 * @ORM\Table(name="app_permisos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PermisoRepository")
 */
class Permiso
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
     * @var integer 
     * 
     * @ORM\Column(name="codigo", type="integer", unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=512)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;
    
    /**
     * Many Groups have Many Users.
     * @ORM\ManyToMany(targetEntity="Rol", mappedBy="permisos")
     */
    private $roles;
    
    
    public function __construct() {
        $this->permisos = new ArrayCollection();
        $this->roles = new ArrayCollection;
        ;
    }
    
    public function __toString() {
        return $this->titulo;
    }
    
    public function getListaRoles(){
        return $this->roles->count() === 0 ? null : implode(', ', $this->roles);
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
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Permiso
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

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Permiso
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return Permiso
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
     * Add role
     *
     * @param \AppBundle\Entity\Rol $role
     *
     * @return Permiso
     */
    public function addRole(\AppBundle\Entity\Rol $role)
    {
        $this->roles[] = $role;
        
        $role->addPermiso($this);

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

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
