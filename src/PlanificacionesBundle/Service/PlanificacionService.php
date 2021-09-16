<?php

namespace PlanificacionesBundle\Service;

use AppBundle\Repository\RolRepository;
use Doctrine\ORM\EntityManager;
use PlanificacionesBundle\Entity\Planificacion;

/**
 * Description of PlanificacionService
 *
 * @author emi88
 */
class PlanificacionService {

    /**
     *
     * @var string
     */
    private $ultimoError;

    /**
     *
     * @var EntityManager 
     */
    private $em;

    /**
     *
     * @var RolRepository 
     */
    private $repoRoles;

    /**
     *
     * @var array 
     */
    private $errores;
    
    /**
     *
     * @var boolean 
     */
    private $hayErrores;

    public function __construct($entityManager) {

        $this->em = $entityManager;
        $this->errores = array();
        $this->hayErrores = false;
        $this->repoRoles = $this->em->getRepository('AppBundle:Rol');
    }

    public function getErrores(Planificacion $planificacion) {

        $this->errores = array();        
        
        $this->hayErrores = false;
        
        $this->errores['info_basica'] = $this->validarInfoBasica($planificacion);
        $this->errores['eq_docente'] = $this->validarEqDocente($planificacion);
        $this->errores['aprobacion'] = $this->validarAprobacion($planificacion);
        $this->errores['objetivos'] = $this->validarObjetivos($planificacion);
        $this->errores['resultados'] = $this->validarResultados($planificacion);
        $this->errores['temario'] = $this->validarTemario($planificacion);
        $this->errores['bibliografia'] = $this->validarBibliografia($planificacion);
        $this->errores['cronograma'] = $this->validarCronograma($planificacion);
        $this->errores['dist_horaria'] = $this->validarDistribucionHoraria($planificacion);
        $this->errores['viajes'] = $this->validarViajesAcademicos($planificacion);

        return $this->errores;
    }
    
    public function hayErrores(Planificacion $planificacion) {
        
        $this->hayErrores = false;
        
        $funciones = array(
            'validarInfoBasica',
            'validarEqDocente',
            'validarAprobacion',
            'validarObjetivos',
            'validarResultados',
            'validarTemario',
            'validarBibliografia',
            'validarCronograma',
            'validarDistribucionHoraria',
            'validarViajesAcademicos',
        );
        
        foreach ($funciones as $f){
            $this->$f($planificacion);
            if ($this->hayErrores){
                return true;
            }
        }
        
        return false;
    }

    public function validarInfoBasica(Planificacion $planificacion) {
        $errores = array();

        //toda la validacion necesaria de info basica


        return $errores;
    }

    public function validarEqDocente(Planificacion $planificacion) {
        $errores = array();

        if (!$planificacion->getDocenteResponsable()) {
            $errores[] = 'No ha definido el docente responsable de la asignatura.';
            $this->hayErrores = true;
        }
        $errores[] = 'Lo lolo.';

        return $errores;
    }

    public function validarAprobacion(Planificacion $planificacion) {
        $errores = array();

        if (!$planificacion->getRequisitosAprobacion()) {
            $errores[] = 'No han definido los requisitos de aprobación.';
            $this->hayErrores = true;
            return $errores;
        }

        return $errores;
    }
    
    public function validarObjetivos(Planificacion $planificacion) {
        $errores = array();

        if (!$planificacion->getObjetivosGral()) {
            $errores[] = 'No se han definido los objetivos generales.';
            $this->hayErrores = true;
        }
        
        if (!$planificacion->getObjetivosEspecificos()) {
            $errores[] = 'No han definido los objetivos específicos';
            $this->hayErrores = true;
        }

        return $errores;
    }
    
    public function validarResultados(Planificacion $planificacion) {
        $errores = array();

        if (!$planificacion->getResultados()) {
            $errores[] = 'No se han definido los resultados.';
            $this->hayErrores = true;
        }

        return $errores;
    }
    
    public function validarTemario(Planificacion $planificacion) {
        $errores = array();

        if ($planificacion->getTemario()->count() === 0) {
            $errores[] = 'No se ha definido ningún tema.';
            $this->hayErrores = true;
        }

        return $errores;
    }
    
    public function validarBibliografia(Planificacion $planificacion) {
        $errores = array();

        if ($planificacion->getBibliografiasPlanificacion()->count() === 0) {
            $errores[] = 'No se ha definido ninguna bibliografía.';
            $this->hayErrores = true;
        }

        return $errores;
    }
    
    public function validarCronograma(Planificacion $planificacion) {
        $errores = array();

        if ($planificacion->getActividadCurricular()->count() === 0) {
            $errores[] = 'No se ha definido ninguna actividad curricular.';
            $this->hayErrores = true;
        }

        return $errores;
    }
    
    public function validarDistribucionHoraria(Planificacion $planificacion) {
        $errores = array();
        
        // ????

        return $errores;
    }
    
    public function validarViajesAcademicos(Planificacion $planificacion) {
        $errores = array();

        if ($planificacion->getViajesAcademicos()->count() === 0) {
            $errores[] = 'No se han definido ningún viaje academico';
            $this->hayErrores = true;
        }

        return $errores;
    }

    public function getUltimoError() {
        return $this->ultimoError;
    }

    public function getHayErrores() {
        return $this->hayErrores;
    }


}
