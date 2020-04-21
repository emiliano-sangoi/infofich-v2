<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use FICH\APIInfofich\Query\Carreras\QueryCarreras;
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

    public function __construct(EntityManager $entityManager) {

        $this->em = $entityManager;
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
                ->setCacheEnabled(true);

        if (!$solo_carreras) {

            $solo_carreras = array(
                WSHelper::CARRERA_IRH,
                WSHelper::CARRERA_II,
                WSHelper::CARRERA_IAMB,
                WSHelper::CARRERA_IAGR
            );
        }

        $resultado = $query->setCarreras($solo_carreras)
                ->setSoloVigentes(true)
                ->getResultado();

        if ($resultado) {
            return $resultado;
        }

        $this->ultimoError = $query->getError();
        return false;
    }
    
    public function getCarrera($carrera) {
        $carreras_fich = $this->getCarreras(array($carrera));
        
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
    public function getAsignaturasPorCarrera($carrera) {

        $carreras_fich = $this->getCarreras(array($carrera));
        
        if (count($carreras_fich) > 0) {

            $c = array_shift($carreras_fich);
            $query = new \FICH\APIInfofich\Query\Carreras\QueryMateriasCarrera();

            $query->setUnidadAcademica(WSHelper::UA_FICH)
                    ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO)
                    ->setCarrera($c->getCodigoCarrera())
                    ->setPlan($c->getPlanCarrera())
                    ->setVersion($c->getVersionPlan())
                    ->setCacheEnabled(true);

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

}
