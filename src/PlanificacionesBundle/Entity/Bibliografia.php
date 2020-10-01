<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bibliografia
 *
 * @ORM\Table(name="planif_bibliografias")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\BibliografiaRepository")
 */
class Bibliografia
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
     * @ORM\Column(name="titulo", type="string", length=512)
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $titulo;    

    /**
     * @var string
     *
     * @ORM\Column(name="autores", type="string", length=512)
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $autores;

    /**
     * @var string
     *
     * @ORM\Column(name="editorial", type="string", length=512)
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $editorial;

    /**
     * @var int
     *
     * @ORM\Column(name="anio_edicion", type="smallint")
     * @Assert\Type(
     *     type="int",
     *     message="Este campo debe ser un número entero")
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $anioEdicion;

    /**
     * @var int
     *
     * @ORM\Column(name="nro_edicion", type="smallint")     
     * @Assert\Type(
     *     type="int",
     *     message="Este campo debe ser un número entero")    
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $nroEdicion;

    /**
     * @var string
     *
     * @ORM\Column(name="issn_isbn", type="string", length=256, nullable=true)
     */
    private $issnIsbn;
    

    /**
     * @var bool
     *
     * @ORM\Column(name="disponible_biblioteca", type="boolean")
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $disponibleBiblioteca;

    /**
     * @var bool
     *
     * @ORM\Column(name="disponible_online", type="boolean")
     * @Assert\NotBlank(message="Este campo no puede quedar vacío.")
     */
    private $disponibleOnline;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_consulta_online", type="datetime", nullable=true)
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual("today" , message="La fecha debe ser mayor o igual al día de hoy.")
     */
    private $fechaConsultaOnline;

    /**
     * @var string
     *
     * @ORM\Column(name="enlace_online", type="string", length=512, nullable=true)
     */
    private $enlaceOnline;
    
    public function __construct() {
        $this->fechaConsultaOnline = new \DateTime();
        $this->disponibleBiblioteca = false;
        $this->disponibleOnline = false;
    }
    
    public function __toString() {
        return $this->titulo;
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
     * @return Bibliografia
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
     * Set autores
     *
     * @param string $autores
     *
     * @return Bibliografia
     */
    public function setAutores($autores)
    {
        $this->autores = $autores;

        return $this;
    }

    /**
     * Get autores
     *
     * @return string
     */
    public function getAutores()
    {
        return $this->autores;
    }

    /**
     * Set editorial
     *
     * @param string $editorial
     *
     * @return Bibliografia
     */
    public function setEditorial($editorial)
    {
        $this->editorial = $editorial;

        return $this;
    }

    /**
     * Get editorial
     *
     * @return string
     */
    public function getEditorial()
    {
        return $this->editorial;
    }

    /**
     * Set anioEdicion
     *
     * @param integer $anioEdicion
     *
     * @return Bibliografia
     */
    public function setAnioEdicion($anioEdicion)
    {
        $this->anioEdicion = $anioEdicion;

        return $this;
    }

    /**
     * Get anioEdicion
     *
     * @return int
     */
    public function getAnioEdicion()
    {
        return $this->anioEdicion;
    }

    /**
     * Set nroEdicion
     *
     * @param integer $nroEdicion
     *
     * @return Bibliografia
     */
    public function setNroEdicion($nroEdicion)
    {
        $this->nroEdicion = $nroEdicion;

        return $this;
    }

    /**
     * Get nroEdicion
     *
     * @return int
     */
    public function getNroEdicion()
    {
        return $this->nroEdicion;
    }

    /**
     * Set issnIsbn
     *
     * @param string $issnIsbn
     *
     * @return Bibliografia
     */
    public function setIssnIsbn($issnIsbn)
    {
        $this->issnIsbn = $issnIsbn;

        return $this;
    }

    /**
     * Get issnIsbn
     *
     * @return string
     */
    public function getIssnIsbn()
    {
        return $this->issnIsbn;
    }

    /**
     * Set disponibleBiblioteca
     *
     * @param boolean $disponibleBiblioteca
     *
     * @return Bibliografia
     */
    public function setDisponibleBiblioteca($disponibleBiblioteca)
    {
        $this->disponibleBiblioteca = $disponibleBiblioteca;

        return $this;
    }

    /**
     * Get disponibleBiblioteca
     *
     * @return bool
     */
    public function getDisponibleBiblioteca()
    {
        return $this->disponibleBiblioteca;
    }

    /**
     * Set disponibleOnline
     *
     * @param boolean $disponibleOnline
     *
     * @return Bibliografia
     */
    public function setDisponibleOnline($disponibleOnline)
    {
        $this->disponibleOnline = $disponibleOnline;

        return $this;
    }

    /**
     * Get disponibleOnline
     *
     * @return bool
     */
    public function getDisponibleOnline()
    {
        return $this->disponibleOnline;
    }

    /**
     * Set fechaConsultaOnline
     *
     * @param \DateTime $fechaConsultaOnline
     *
     * @return Bibliografia
     */
    public function setFechaConsultaOnline($fechaConsultaOnline)
    {
        $this->fechaConsultaOnline = $fechaConsultaOnline;

        return $this;
    }

    /**
     * Get fechaConsultaOnline
     *
     * @return \DateTime
     */
    public function getFechaConsultaOnline()
    {
        return $this->fechaConsultaOnline;
    }

    /**
     * Set enlaceOnline
     *
     * @param string $enlaceOnline
     *
     * @return Bibliografia
     */
    public function setEnlaceOnline($enlaceOnline)
    {
        $this->enlaceOnline = $enlaceOnline;

        return $this;
    }

    /**
     * Get enlaceOnline
     *
     * @return string
     */
    public function getEnlaceOnline()
    {
        return $this->enlaceOnline;
    }
    
}
