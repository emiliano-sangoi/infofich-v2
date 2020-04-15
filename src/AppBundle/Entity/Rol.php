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
class Rol {

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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /*
     * @var ArrayCollection
     * 
     * Un rol tiene asociado muchos permisos
     * 
     * @ORM\ManyToMany(targetEntity="Permiso")
     * @ORM\JoinTable(name="app_roles_permisos",
     *      joinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="permiso_id", referencedColumnName="id")}
     *      )
     */
    //private $permisos;
    
    /**
     * @var Rol
     * 
     * @ORM\ManyToOne(targetEntity="Rol", inversedBy="hijos")
     * @ORM\JoinColumn(name="padre_id", referencedColumnName="id")
     */
    private $padre;
    

    /**
     * @var ArrayCollection
     * 
     * Un rol puede tener muchos hijos
     * 
     * @ORM\OneToMany(targetEntity="Rol", mappedBy="padre")
     */
    private $hijos;
    

    public function __construct() {
        $this->permisos = new ArrayCollection();
        $this->hijos = new ArrayCollection();
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
     * Set padre
     *
     * @param \AppBundle\Entity\Rol $padre
     *
     * @return Rol
     */
    public function setPadre(\AppBundle\Entity\Rol $padre = null)
    {
        $this->padre = $padre;

        return $this;
    }

    /**
     * Get padre
     *
     * @return \AppBundle\Entity\Rol
     */
    public function getPadre()
    {
        return $this->padre;
    }

    /**
     * Add hijo
     *
     * @param \AppBundle\Entity\Rol $hijo
     *
     * @return Rol
     */
    public function addHijo(\AppBundle\Entity\Rol $hijo)
    {
        $this->hijos[] = $hijo;

        return $this;
    }

    /**
     * Remove hijo
     *
     * @param \AppBundle\Entity\Rol $hijo
     */
    public function removeHijo(\AppBundle\Entity\Rol $hijo)
    {
        $this->hijos->removeElement($hijo);
    }

    /**
     * Get hijos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHijos()
    {
        return $this->hijos;
    }
}
