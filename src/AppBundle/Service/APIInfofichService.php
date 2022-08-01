<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use FICH\APIInfofich\Query\Carreras\QueryCarreras;
use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use FICH\APIRectorado\Config\WSHelper;

/**
 * Description of APIInfofichService
 *
 * @author emi88
 */
class APIInfofichService {

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
     * @var array
     */
    private $carreras_permitidas;
    
    /**
     * 
     * @var boolean
     */
    private $wsCacheEnabled;
    
    /**
     * 
     * @var string
     */
    private $wsEnv;

    public function __construct(EntityManager $entityManager, $apiInfofichCacheEnabled, $apiInfofichEnv) {

        $this->em = $entityManager;

        $this->carreras_permitidas = array(
            WSHelper::CARRERA_IRH,
            WSHelper::CARRERA_II,
            WSHelper::CARRERA_IAMB,
            WSHelper::CARRERA_IAGR,
            WSHelper::CARRERA_PTOP,
            WSHelper::CARRERA_TEC_UNIV_AUT_ROBOTICA
        );
        
        $this->wsCacheEnabled = $apiInfofichCacheEnabled;
        $this->wsEnv = $apiInfofichEnv;
    }

    /**
     * Devuelve las carreras de especificadas en el arreglo.
     * 
     * @param array|null $solo_carreras Codigos de las carreras (WSHelper::CARRERA_*)
     * @return array
     */
    public function getCarreras($solo_carreras = null) {

        $this->ultimoError = '';
        $query = new QueryCarreras();

        $query->setUnidadAcademica(WSHelper::UA_FICH)
                ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO)
                ->setWsEnv($this->wsEnv)
                ->setCacheEnabled($this->wsCacheEnabled);

        if (!$solo_carreras) {
            $solo_carreras = $this->carreras_permitidas;
        }

        $resultado = $query->setCarreras($solo_carreras)
                ->setSoloVigentes(true)                
                ->getResultado();
        
        if (is_array($resultado)) {
            //dump($resultado);exit;
            return $resultado;
        }
        
        $this->ultimoError = $query->getError();
        return false;
    }

    /**
     * 
     * @param string $carrera Codigo de la carrera, por ej. '01', '02', etc.
     * 
     * @return FICH\APIInfofich\Model\Carrera|false
     */
    public function getCarrera($carrera) {
        $carreras_fich = $this->getCarreras(array($carrera));
        
        if(!is_array($carreras_fich)){
            return false;
        }

        if (count($carreras_fich) > 0) {
            $c = array_shift($carreras_fich);
            return $c;
        }

        $this->ultimoError = 'No se encontro la carrera ' . $carrera;
        return false;
    }

    /**
     * Devuelve las asignaturas para cierta carrera.
     * 
     * @param string $carrera Codigo de la carrera a buscar
     * @return array|false
     */
    public function getAsignaturasPorCarrera($carrera, $raw = false) {        

        $carreras_fich = $this->getCarreras(array($carrera));

        if(!is_array($carreras_fich)){
            return false;
        }
        
        if (count($carreras_fich) > 0) {

            $c = array_shift($carreras_fich);
            $query = new \FICH\APIInfofich\Query\Carreras\QueryMateriasCarrera();

            $query->setUnidadAcademica(WSHelper::UA_FICH)
                    ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO)
                    ->setCarrera($c->getCodigoCarrera())
                    ->setPlan($c->getPlanCarrera())
                    ->setVersion($c->getVersionPlan())
                    ->setRaw($raw)
                    ->setWsEnv($this->wsEnv)
                    ->setCacheEnabled($this->wsCacheEnabled);

            $asignaturas = $query->getResultado();

            if (!$asignaturas) {
                $this->ultimoError = $query->getError();
                return false;
            }

            return $asignaturas;
        }

        $this->ultimoError = 'No se encontro la carrera ' . $carrera;
        return false;
    }
    
    
    /**
     * Devuelve las asignaturas para cierta carrera.
     * 
     * @param string $carrera Codigo de la carrera a buscar
     * @return array|false
     */
    public function getAsignatura($carrera, $codigo) {                       

        $carreras_fich = $this->getCarreras(array($carrera));       

        if (count($carreras_fich) > 0) {

            $c = array_shift($carreras_fich);
            $query = new \FICH\APIInfofich\Query\Carreras\QueryMateriasCarrera();

            $query->setUnidadAcademica(WSHelper::UA_FICH)
                    ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO)
                    ->setCarrera($c->getCodigoCarrera())
                    ->setPlan($c->getPlanCarrera())
                    ->setVersion($c->getVersionPlan())
                    ->soloMaterias(array($codigo))       
                    ->setWsEnv($this->wsEnv)
                    ->setCacheEnabled($this->wsCacheEnabled);

            $asignaturas = $query->getResultado();

            if (!$asignaturas) {
                $this->ultimoError = $query->getError();
                return false;
            }else if(count($asignaturas) > 0){
                return array_shift($asignaturas);
            }
            
            return null;
        }

        $this->ultimoError = 'No se encontro la carrera ' . $carrera;
        return false;
    }

    function getUltimoError() {
        return $this->ultimoError;
    }

    /**
     * Obtiene los docentes activos de la FICH
     * 
     * @return array
     */
    public function getDocentesActivos() {

        $q = new QueryDocentes();
        $docentes = $q->setCacheEnabled($this->wsCacheEnabled)
                ->setWsEnv($this->wsEnv)
                ->setEscalafon(QueryDocentes::ESCALAFON_DOCENTES)
                ->setEstado('activo')
                ->getDocentes();

        if(!empty($docentes)){
            uasort($docentes, function($a, $b){
                return strcasecmp($a->getApellido(), $b->getApellido());
            });
        }                    
        return $docentes;
    }


}
