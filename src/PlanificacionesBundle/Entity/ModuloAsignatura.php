<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use \FICH\APIRectorado\Config\WSHelper;

/**
 * ModuloAsignatura
 *
 * @ORM\Table(name="planif_modulos_asignatura", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="ak_modulos_asignatura", columns={"codigo", "codigoGuarani"})
 * })
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\ModuloAsignaturaRepository")
 * @UniqueEntity(
 *     fields={"codigo", "codigoGuarani"},
 *     errorPath="codigoAsignatura",
 *     message="Esta asignatura ya tiene creada una planificación."
 * )
 */
class ModuloAsignatura implements JsonSerializable{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Codigo del modulo
     *
     * @var int
     *
     * @ORM\Column(name="codigo", type="integer", nullable=false)
     */
    private $codigo;

    /**
     * Codigo asignatura asociada
     *
     * @var string
     *
     * @ORM\Column(name="codigo_guarani", type="string", length=24, nullable=false)
     */
    private $codigoGuarani;

    /**
     * Nombre del modulo
     *
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=256)
     */
    private $nombre;


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
     * Set codigoGuarani
     *
     * @param string $codigoGuarani
     *
     * @return ModuloAsignatura
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

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return ModuloAsignatura
     */
    public function setNombreAsignatura($nombre) {
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
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return ModuloAsignatura
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return int
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'codigoGuarani' => $this->codigoGuarani,
            'nombre' => $this->nombre,
            'posicion' => $this->codigo,
        );
    }
}
