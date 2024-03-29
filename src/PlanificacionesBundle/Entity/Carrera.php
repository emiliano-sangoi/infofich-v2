<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Mixed_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use FICH\APIRectorado\Config\WSHelper;

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
 * @ORM\Table(name="planif_carreras", uniqueConstraints={@ORM\UniqueConstraint(name="uk1_planif_carreras", columns={"codigo_carrera", "plan_carrera", "version_plan", "estado"})})
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\CarreraRepository")
 * @UniqueEntity(
 *     fields={"codigoCarrera", "planCarrera", "versionPlan", "estado"},
 *     errorPath="codigoCarrera",
 *     message="La carrera ya existe en la base de datos."
 * )
 */
class Carrera implements \JsonSerializable {

    public static $carrerasPlanificacion = array(
        WSHelper::CARRERA_IRH,
        WSHelper::CARRERA_II,
        WSHelper::CARRERA_IAMB,
        WSHelper::CARRERA_IAGR,
        WSHelper::CARRERA_PTOP,
        WSHelper::CARRERA_TEC_UNIV_AUT_ROBOTICA,
        WSHelper::CARRERA_ING_INT_ART,
        WSHelper::CARRERA_LIC_CIENCIA_DATOS,
    );

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
     * Nombre de la carrera
     *
     * @var string
     *
     * @ORM\Column(name="nombre_carrera_abrev", type="string", length=24, nullable=true)
     */
    private $nombreCarreraAbrev;

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
     * @var string
     *
     * @ORM\Column(name="nombre_plan", type="string", length=6, nullable=true)
     */
    private $nombrePlan;

    /**
     * Plan al que pertenece la carrera.
     *
     * @var string
     *
     * @ORM\Column(name="plan_carrera_ant", type="string", length=6, nullable=true)
     */
    private $planCarreraAnt;

    /**
     * @return string
     */
    public function getNombrePlan()
    {
        return $this->nombrePlan;
    }

    /**
     * @param string $nombrePlan
     * @return Carrera
     */
    public function setNombrePlan($nombrePlan)
    {
        $this->nombrePlan = $nombrePlan;
        return $this;
    }



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
     * @ORM\Column(name="alcance_titulo", type="string", length=24, nullable=true)
     */
    private $alcanceTitulo;

    /**
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Asignatura", mappedBy="carrera")
     */
    private $asignaturas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_actualizacion", type="datetime")
     */
    private $fechaActualizacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="disponible_planif", type="boolean", nullable=true)
     *
     */
    private $disponiblePlanif;



    public function __toString() {
        return $this->nombreCarrera;
    }

    public function __toString2() {
        return $this->codigoCarrera . ' - ' . $this->nombreCarrera;
    }

    public function getCarreraPlan() {
        return $this->nombreCarrera . ' - Plan: ' . $this->planCarrera;
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

    /**
     * @return \DateTime
     */
    public function getFechaActualizacion()
    {
        return $this->fechaActualizacion;
    }

    /**
     * @param \DateTime $fechaActualizacion
     * @return Carrera
     */
    public function setFechaActualizacion(\DateTime $fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPlanCarreraAnt()
    {
        return $this->planCarreraAnt;
    }

    /**
     * @param string $planCarreraAnt
     * @return Carrera
     */
    public function setPlanCarreraAnt($planCarreraAnt)
    {
        $this->planCarreraAnt = $planCarreraAnt;
        return $this;
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asignaturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->disponiblePlanif = true;
    }

    /**
     * Add asignatura
     *
     * @param \PlanificacionesBundle\Entity\Asignatura $asignatura
     *
     * @return Carrera
     */
    public function addAsignatura(\PlanificacionesBundle\Entity\Asignatura $asignatura)
    {
        $asignatura->setCarrera($this);

        $this->asignaturas[] = $asignatura;

        return $this;
    }

    /**
     * Remove asignatura
     *
     * @param \PlanificacionesBundle\Entity\Asignatura $asignatura
     */
    public function removeAsignatura(\PlanificacionesBundle\Entity\Asignatura $asignatura)
    {
        $this->asignaturas->removeElement($asignatura);
    }

    /**
     * Get asignaturas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAsignaturas()
    {
        return $this->asignaturas;
    }

    /**
     * Set disponiblePlanif
     *
     * @param boolean $disponiblePlanif
     *
     * @return Carrera
     */
    public function setDisponiblePlanif($disponiblePlanif)
    {
        $this->disponiblePlanif = $disponiblePlanif;

        return $this;
    }

    /**
     * Get disponiblePlanif
     *
     * @return boolean
     */
    public function getDisponiblePlanif()
    {
        return $this->disponiblePlanif;
    }

    /**
     * @return string
     */
    public function getNombreCarreraAbrev(): string
    {
        return $this->nombreCarreraAbrev;
    }

    /**
     * @param string $nombreCarreraAbrev
     * @return Carrera
     */
    public function setNombreCarreraAbrev(string $nombreCarreraAbrev): Carrera
    {
        $this->nombreCarreraAbrev = $nombreCarreraAbrev;
        return $this;
    }


}
