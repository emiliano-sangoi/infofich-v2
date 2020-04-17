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

    public function getCarreras($solo_carreras) {

        $query = new QueryCarreras();

        $carreras = $query
                ->setUnidadAcademica(WSHelper::UA_FICH)
                ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO)
                ->setCacheEnabled(true)
                ->getResultado();

        if (count($solo_carreras) > 0) {
            $carreras = $query->filtrar($solo_carreras);
        }

        return $carreras;
    }

    /**
     * Devuelve las carreras de FICH
     * 
     * @return type
     */
    public function getCarrerasFICH() {

        $solo_carreras = array(
            WSHelper::CARRERA_IRH, 
            WSHelper::CARRERA_II, 
            WSHelper::CARRERA_IAMB, 
            WSHelper::CARRERA_IAGR
        );

        //dump($this->getCarreras($solo_carreras));exit;
        return $this->getCarreras($solo_carreras);
    }

}
