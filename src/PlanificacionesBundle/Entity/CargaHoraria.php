<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CargaHoraria
 *
 * @ORM\Table(name="planif_carga_horaria")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\CargaHorariaRepository")
 */
class CargaHoraria
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
     * @var float
     *
     * @ORM\Column(name="cant_hs_resol_prob_ing", type="decimal", precision=6, scale=1)
     */
    private $cantHsResolProbIng;

    /**
     * @var float
     *
     * @ORM\Column(name="cant_hs_ej_rutinarios", type="decimal", precision=6, scale=1)
     */
    private $cantHsEjRutinarios;

    /**
     * @var float
     *
     * @ORM\Column(name="cant_hs_act_proy_disenio", type="decimal", precision=6, scale=1)
     */
    private $cantHsActProyDisenio;

    /**
     * @var float
     *
     * @ORM\Column(name="cant_hs_practica_prof_sup", type="decimal", precision=6, scale=1)
     */
    private $cantHsPracticaProfSup;

    /**
     * @var float
     *
     * @ORM\Column(name="cant_hs_teoria", type="decimal", precision=6, scale=1)
     */
    private $cantHsTeoria;

    /**
     * @var float
     *
     * @ORM\Column(name="cant_hs_consulta", type="decimal", precision=6, scale=1)
     */
    private $cantHsConsulta;

    /**
     * @var float
     *
     * @ORM\Column(name="cant_hs_evaluacion", type="decimal", precision=6, scale=1)
     */
    private $cantHsEvaluacion;

    /**
     *
     * @var Planificacion
     *
     * @ORM\OneToOne(targetEntity="Planificacion", inversedBy="cargaHoraria")
     */
    private $planificacion;


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
     * Set cantHsResolProbIng
     *
     * @param string $cantHsResolProbIng
     *
     * @return CargaHoraria
     */
    public function setCantHsResolProbIng($cantHsResolProbIng)
    {
        $this->cantHsResolProbIng = $cantHsResolProbIng;

        return $this;
    }

    /**
     * Get cantHsResolProbIng
     *
     * @return string
     */
    public function getCantHsResolProbIng()
    {
        return $this->cantHsResolProbIng;
    }

    /**
     * Set cantHsEjRutinarios
     *
     * @param string $cantHsEjRutinarios
     *
     * @return CargaHoraria
     */
    public function setCantHsEjRutinarios($cantHsEjRutinarios)
    {
        $this->cantHsEjRutinarios = $cantHsEjRutinarios;

        return $this;
    }

    /**
     * Get cantHsEjRutinarios
     *
     * @return string
     */
    public function getCantHsEjRutinarios()
    {
        return $this->cantHsEjRutinarios;
    }

    /**
     * Set cantHsActProyDisenio
     *
     * @param string $cantHsActProyDisenio
     *
     * @return CargaHoraria
     */
    public function setCantHsActProyDisenio($cantHsActProyDisenio)
    {
        $this->cantHsActProyDisenio = $cantHsActProyDisenio;

        return $this;
    }

    /**
     * Get cantHsActProyDisenio
     *
     * @return string
     */
    public function getCantHsActProyDisenio()
    {
        return $this->cantHsActProyDisenio;
    }

    /**
     * Set cantHsPracticaProfSup
     *
     * @param string $cantHsPracticaProfSup
     *
     * @return CargaHoraria
     */
    public function setCantHsPracticaProfSup($cantHsPracticaProfSup)
    {
        $this->cantHsPracticaProfSup = $cantHsPracticaProfSup;

        return $this;
    }

    /**
     * Get cantHsPracticaProfSup
     *
     * @return string
     */
    public function getCantHsPracticaProfSup()
    {
        return $this->cantHsPracticaProfSup;
    }

    /**
     * Set cantHsTeoria
     *
     * @param string $cantHsTeoria
     *
     * @return CargaHoraria
     */
    public function setCantHsTeoria($cantHsTeoria)
    {
        $this->cantHsTeoria = $cantHsTeoria;

        return $this;
    }

    /**
     * Get cantHsTeoria
     *
     * @return string
     */
    public function getCantHsTeoria()
    {
        return $this->cantHsTeoria;
    }

    /**
     * Set cantHsConsulta
     *
     * @param string $cantHsConsulta
     *
     * @return CargaHoraria
     */
    public function setCantHsConsulta($cantHsConsulta)
    {
        $this->cantHsConsulta = $cantHsConsulta;

        return $this;
    }

    /**
     * Get cantHsConsulta
     *
     * @return string
     */
    public function getCantHsConsulta()
    {
        return $this->cantHsConsulta;
    }

    /**
     * Set cantHsEvaluacion
     *
     * @param string $cantHsEvaluacion
     *
     * @return CargaHoraria
     */
    public function setCantHsEvaluacion($cantHsEvaluacion)
    {
        $this->cantHsEvaluacion = $cantHsEvaluacion;

        return $this;
    }

    /**
     * Get cantHsEvaluacion
     *
     * @return string
     */
    public function getCantHsEvaluacion()
    {
        return $this->cantHsEvaluacion;
    }

    /**
     * Set planificacion
     *
     * @param \PlanificacionesBundle\Entity\Planificacion $planificacion
     *
     * @return CargaHoraria
     */
    public function setPlanificacion(\PlanificacionesBundle\Entity\Planificacion $planificacion = null)
    {
        $this->planificacion = $planificacion;

        return $this;
    }

    /**
     * Get planificacion
     *
     * @return \PlanificacionesBundle\Entity\Planificacion
     */
    public function getPlanificacion()
    {
        return $this->planificacion;
    }
}
