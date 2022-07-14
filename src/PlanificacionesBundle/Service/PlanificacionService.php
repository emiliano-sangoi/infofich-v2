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
    
    /**
     * @var APIInfofichService
     */
    private $apiInfofichService;

    public function __construct($entityManager, $apiInfofichService) {

        $this->em = $entityManager;
        $this->apiInfofichService = $apiInfofichService;
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
        $this->errores['viajes'] = array();

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
            //'validarViajesAcademicos',
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
        
        $dr = $planificacion->getDocenteResponsable();
        $aux = array();$c = 0;
        foreach ($planificacion->getDocentesColaboradores() as $dc){
            if($dr == $dc->getDocenteGrado()){
                $errores[] = 'El docente responsable de la planificacion (' .
                        ($dr) . ') no puede figurar en la lista de docentes colaboradores.';
                break;
            }
            $c++;
            $aux[$dc->getDocenteGrado()->getId()] = null;
        }
        
        if(count($aux) < $c){
            $errores[] = 'Existen docentes duplicados entre los colaboradores.';
        }        
        

        return $errores;
    }

    public function validarAprobacion(Planificacion $planificacion) {
        $errores = array();

        if (!$planificacion->getRequisitosAprobacion()) {
            $errores[] = 'No han definido los requisitos de aprobación (asistencia, fecha de parciales, etcétera).';
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

        if ($planificacion->getBibliografias()->count() === 0) {
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
        
        //Controlamos que la suma de la carga horaria de las act no supere la carga horaria total de la asignatura
        $sumaCargaHoraria = $planificacion->getTotalCargaHorariaAula();

        $asignatura = $this->apiInfofichService->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $cargaHorariaTotal = $asignatura->getCargaHoraria();
        
        //dump($sumaCargaHoraria, $cargaHorariaTotal);exit;
        if (($sumaCargaHoraria != $cargaHorariaTotal) && ($cargaHorariaTotal > 0)) {         
            $errores[] = 'La carga horaria definida en la planificacion ('.$sumaCargaHoraria.' Hs.) es distinta a la carga horaria total definida en la asignatura ('. $cargaHorariaTotal . ' hs.).';//no se usaa
            $this->hayErrores = true;
         
        }

        return $errores;
    }
    
    public function validarDistribucionHoraria(Planificacion $planificacion) {
        $errores = array();
        
        // ????

        return $errores;
    }
    
    /**
     * Viajes academicos es opcional, no se usa por ahora esta validacion.
     * 
     * @param Planificacion $planificacion
     * @return string
     */
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
