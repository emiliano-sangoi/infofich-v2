<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departamento
 *
 * @ORM\Table(name="planif_departamentos")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\DepartamentoRepository")
 */
class Departamento
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
     * @ORM\Column(name="nombre", type="string", length=512)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_guarani", type="string", length=12, nullable=true)
     */
    private $codigoGuarani;


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Departamento
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set codigoGuarani
     *
     * @param string $codigoGuarani
     *
     * @return Departamento
     */
    public function setCodigoGuarani($codigoGuarani)
    {
        $this->codigoGuarani = $codigoGuarani;

        return $this;
    }

    /**
     * Get codigoGuarani
     *
     * @return string
     */
    public function getCodigoGuarani()
    {
        return $this->codigoGuarani;
    }
}

