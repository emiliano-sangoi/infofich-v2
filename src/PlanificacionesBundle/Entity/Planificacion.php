<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Planificacion
 *
 * @ORM\Table(name="planif_planificaciones")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\PlanificacionRepository")
 */
class Planificacion
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
     * @var int
     *
     * @ORM\Column(name="anio_acad", type="smallint")
     */
    private $anioAcad;

    /**
     * @var string
     *
     * @ORM\Column(name="contenidos_minimos", type="text", nullable=true)
     */
    private $contenidosMinimos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fechaCreacion;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivos_gral", type="text", nullable=true)
     */
    private $objetivosGral;

    /**
     * @var string
     *
     * @ORM\Column(name="objetivos_especificos", type="text", nullable=true)
     */
    private $objetivosEspecificos;
    
    /**
     *
     * @var Departamento
     * 
     * @ORM\ManyToOne(targetEntity="Departamento")
     * @ORM\JoinColumn(name="planif_departamentos_id",referencedColumnName="id")
     */
    private $departamento;
    
    /**
     *
     * @var Asignatura
     * 
     * @ORM\ManyToOne(targetEntity="Asignatura")
     * @ORM\JoinColumn(name="planif_asignaturas_id",referencedColumnName="id")
     */
    private $asignatura;
    
    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="DocentePlanificacion", mappedBy="planificacion")
     */
    private $docentesPlanificacion;
    
    /**
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="HistoricoEstados", mappedBy="planificacion")
     */
    private $historicosEstado;
    
    
    public function __construct() {
        $this->docentesPlanificacion = new ArrayCollection;
        $this->historicosEstados = new ArrayCollection;
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
     * Set anioAcad
     *
     * @param integer $anioAcad
     *
     * @return Planificacion
     */
    public function setAnioAcad($anioAcad)
    {
        $this->anioAcad = $anioAcad;

        return $this;
    }

    /**
     * Get anioAcad
     *
     * @return int
     */
    public function getAnioAcad()
    {
        return $this->anioAcad;
    }

    /**
     * Set contenidosMinimos
     *
     * @param string $contenidosMinimos
     *
     * @return Planificacion
     */
    public function setContenidosMinimos($contenidosMinimos)
    {
        $this->contenidosMinimos = $contenidosMinimos;

        return $this;
    }

    /**
     * Get contenidosMinimos
     *
     * @return string
     */
    public function getContenidosMinimos()
    {
        return $this->contenidosMinimos;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Planificacion
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
     * Set objetivosGral
     *
     * @param string $objetivosGral
     *
     * @return Planificacion
     */
    public function setObjetivosGral($objetivosGral)
    {
        $this->objetivosGral = $objetivosGral;

        return $this;
    }

    /**
     * Get objetivosGral
     *
     * @return string
     */
    public function getObjetivosGral()
    {
        return $this->objetivosGral;
    }

    /**
     * Set objetivosEspecificos
     *
     * @param string $objetivosEspecificos
     *
     * @return Planificacion
     */
    public function setObjetivosEspecificos($objetivosEspecificos)
    {
        $this->objetivosEspecificos = $objetivosEspecificos;

        return $this;
    }

    /**
     * Get objetivosEspecificos
     *
     * @return string
     */
    public function getObjetivosEspecificos()
    {
        return $this->objetivosEspecificos;
    }

    /**
     * Set departamento
     *
     * @param \PlanificacionesBundle\Entity\Departamento $departamento
     *
     * @return Planificacion
     */
    public function setDepartamento(\PlanificacionesBundle\Entity\Departamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \PlanificacionesBundle\Entity\Departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set asignatura
     *
     * @param \PlanificacionesBundle\Entity\Asignatura $asignatura
     *
     * @return Planificacion
     */
    public function setAsignatura(\PlanificacionesBundle\Entity\Asignatura $asignatura = null)
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    /**
     * Get asignatura
     *
     * @return \PlanificacionesBundle\Entity\Asignatura
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Add docentesPlanificacion
     *
     * @param \PlanificacionesBundle\Entity\DocentePlanificacion $docentesPlanificacion
     *
     * @return Planificacion
     */
    public function addDocentesPlanificacion(\PlanificacionesBundle\Entity\DocentePlanificacion $docentesPlanificacion)
    {
        $this->docentesPlanificacion[] = $docentesPlanificacion;

        return $this;
    }

    /**
     * Remove docentesPlanificacion
     *
     * @param \PlanificacionesBundle\Entity\DocentePlanificacion $docentesPlanificacion
     */
    public function removeDocentesPlanificacion(\PlanificacionesBundle\Entity\DocentePlanificacion $docentesPlanificacion)
    {
        $this->docentesPlanificacion->removeElement($docentesPlanificacion);
    }

    /**
     * Get docentesPlanificacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocentesPlanificacion()
    {
        return $this->docentesPlanificacion;
    }


    /**
     * Add historicosEstado
     *
     * @param \PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado
     *
     * @return Planificacion
     */
    public function addHistoricosEstado(\PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado)
    {
        $this->historicosEstado[] = $historicosEstado;

        return $this;
    }

    /**
     * Remove historicosEstado
     *
     * @param \PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado
     */
    public function removeHistoricosEstado(\PlanificacionesBundle\Entity\HistoricoEstados $historicosEstado)
    {
        $this->historicosEstado->removeElement($historicosEstado);
    }

    /**
     * Get historicosEstado
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistoricosEstado()
    {
        return $this->historicosEstado;
    }
}
