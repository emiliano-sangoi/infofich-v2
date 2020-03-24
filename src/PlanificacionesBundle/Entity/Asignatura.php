<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asignatura
 *
 * @ORM\Table(name="planif_asignaturas")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\AsignaturaRepository")
 */
class Asignatura
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
     * @ORM\Column(name="codigo_guarani", type="string", length=8, unique=true)
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
     * Set codigoGuarani
     *
     * @param string $codigoGuarani
     *
     * @return Asignatura
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

