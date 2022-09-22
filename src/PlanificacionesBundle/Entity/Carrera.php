<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Carrera
 *
 * Campos devueltos por el web service:
 *   "codigoCarrera": "1069",
 *   "nombreCarrera": "Ingeniería Ambiental",
 *   "planCarrera": "012004",
 *   "versionPlan": "1",
 *   "estado": "A",
 *   "tipoTitulo": 1,
 *   "tipoCarrera": "Grado",
 *   "alcanceTitulo": "Grado"
 * 
 * @ORM\Table(name="planif_carreras")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\CarreraRepository")
 */
class Carrera implements \JsonSerializable {

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
     * @var int
     *
     * @ORM\Column(name="codigo_carrera", type="string", length=8)
     */
    private $codigoCarrera;

    /**
     * Nombre de la carrera
     *
     * @var string
     *
     * @ORM\Column(name="nombre_carrera", type="string", length=256)
     */
    private $nombreCarrera;

    /**
     * Plan al que pertenece la carrera.
     *
     * @var string
     *
     * @ORM\Column(name="plan_carrera", type="string", length=6)
     */
    private $planCarrera;

    /**
     * Plan al que pertenece la carrera.
     *
     * @var int
     *
     * @ORM\Column(name="version_plan", type="integer")
     */
    private $versionPlan;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_titulo", type="string", length=1)
     */
    private $tipoTitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_carrera", type="string", length=24)
     */
    private $tipoCarrera;

    /**
     * @var string
     *
     * @ORM\Column(name="alcance_titulo", type="string", length=24)
     */
    private $alcanceTitulo;

    public function __toString() {
        return $this->nombreCarrera;
    }


    /**
     * Set codigoCarrera
     *
     * @param string $codigoCarrera
     *
     * @return Carrera
     */
    public function setCodigoCarrera($codigoCarrera)
    {
        $this->codigoCarrera = $codigoCarrera;

        return $this;
    }

    /**
     * Get codigoCarrera
     *
     * @return string
     */
    public function getCodigoCarrera()
    {
        return $this->codigoCarrera;
    }
    
    /**
     * Set nombreCarrera
     *
     * @param string $nombreCarrera
     *
     * @return nombreCarrera
     */
    public function setNombreCarrera($nombreCarrera)
    {
        $this->nombreCarrera = $nombreCarrera;

        return $this;
    }

    /**
     * Get nombreCarrera
     *
     * @return string
     */
    public function getNombreCarrera()
    {
        return $this->nombreCarrera;
    }
    
    /**
     * Set planCarrera
     *
     * @param string $planCarrera
     *
     * @return planCarrera
     */
    public function setPlanCarrera($planCarrera)
    {
        $this->planCarrera = $planCarrera;

        return $this;
    }

    /**
     * Get PlanCarrera
     *
     * @return string
     */
    public function getPlanCarrera()
    {
        return $this->planCarrera;
    }
    
    /**
     * Set versionPlan
     *
     * @param string versionPlan
     *
     * @return versionPlan
     */
    public function setVersionPlan($versionPlan)
    {
        $this->versionPlan = $versionPlan;

        return $this;
    }

    /**
     * Get versionPlan
     *
     * @return string
     */
    public function getVersionPlan()
    {
        return $this->versionPlan;
    }
    
    /**
     * Set estado
     *
     * @param string estado
     *
     * @return estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }
    
    /**
     * Set tipoTitulo
     *
     * @param string tipoTitulo
     *
     * @return tipoTitulo
     */
    public function setTipoTitulo($tipoTitulo)
    {
        $this->tipoTitulo = $tipoTitulo;

        return $this;
    }

    /**
     * Get tipoTitulo
     *
     * @return string
     */
    public function getTipoTitulo()
    {
        return $this->tipoTitulo;
    }
    
    /**
     * Set tipoCarrera
     *
     * @param string tipoCarrera
     *
     * @return $tipoCarrera
     */
    public function setTipoCarrera($tipoCarrera)
    {
        $this->tipoCarrera = $tipoCarrera;

        return $this;
    }

    /**
     * Get tipoCarrera
     *
     * @return string
     */
    public function getTipoCarrera()
    {
        return $this->tipoCarrera;
    }
    
    /**
     * Set alcanceTitulo
     *
     * @param string alcanceTitulo
     *
     * @return alcanceTitulo
     */
    public function setAlcanceTitulo($alcanceTitulo)
    {
        $this->alcanceTitulo = $alcanceTitulo;

        return $this;
    }

    /**
     * Get alcanceTitulo
     *
     * @return string
     */
    public function getAlcanceTitulo()
    {
        return $this->alcanceTitulo;
    }
    
    

    public function jsonSerialize() {
        return array(
            'codigoCarrera' => $this->codigoCarrera,
            'nombreCarrera' => $this->nombreCarrera,
            'planCarrera' => $this->planCarrera,
            'versionPlan' => $this->versionPlan,
            'estado' => $this->estado,    
            'tipoTitulo' => $this->tipoTitulo,           
            'tipoCarrera' => $this->tipoCarrera,           
            'alcanceTitulo' => $this->alcanceTitulo,           
        );
    }

}
