<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use FICH\APIInfofich\Query\Carreras\QueryCarreras;
use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use FICH\APIRectorado\Config\WSHelper;
use PlanificacionesBundle\Entity\Materia;

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

        if (!is_array($carreras_fich)) {
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

        if (!is_array($carreras_fich)) {
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

            //Agregar los modulos existentes:
            $modulos = $this->getModulos($carrera);
            if (!empty($modulos)) {
                $asignaturas = array_merge($asignaturas, $modulos);
            }
            
            //se esta buscando las materias que son para dictado para recursantes
            $matRecursantes = $this->getMatRecursantes($carrera);
            if (!empty($matRecursantes)) {
                $asignaturas = array_merge($asignaturas, $matRecursantes);
            }

            return $asignaturas;
        }

        $this->ultimoError = 'No se encontro la carrera ' . $carrera;
        return false;
    }

    private function getModulos($carrera, $codigo_asignatura = null, $nro_modulo = null) {
        $repo = $this->em->getRepository(Materia::class);
        $qb = $repo->createQueryBuilder('m');
        $qb->select("m")
                ->where($qb->expr()->isNotNull("m.nroModulo"))
                ->andWhere($qb->expr()->eq("m.carrera", ':carrera'))
                ->andWhere($qb->expr()->isNull("m.recursantes"));

        if ($codigo_asignatura) {
            $qb->andWhere($qb->expr()->eq("m.codigoMateria", ':codigo_materia'));
            $qb->setParameter(':codigo_materia', $codigo_asignatura);
        }

        if ($nro_modulo) {
            $qb->andWhere($qb->expr()->eq("m.nroModulo", ':nro_modulo'));
            $qb->setParameter(':nro_modulo', $nro_modulo);
        }

        $qb->setParameter(':carrera', $carrera);
        $modulos = $qb->getQuery()->getResult();

        return $modulos;
    }

    private function getMatRecursantes($carrera, $codigo_asignatura = null, $nro_modulo = null, $recursantes = null) {
        $repo = $this->em->getRepository(Materia::class);
        $qb = $repo->createQueryBuilder('m');
        $qb->select("m")
                ->where($qb->expr()->isNotNull("m.recursantes"))
                ->andWhere($qb->expr()->eq("m.carrera", ':carrera'));

        if ($codigo_asignatura) {
            $qb->andWhere($qb->expr()->eq("m.codigoMateria", ':codigo_materia'));
            $qb->setParameter(':codigo_materia', $codigo_asignatura);
        }

        if ($nro_modulo) {
            $qb->andWhere($qb->expr()->eq("m.nroModulo", ':nro_modulo'));
            $qb->setParameter(':nro_modulo', $nro_modulo);
        }

        $qb->setParameter(':carrera', $carrera);
        $matRecursantes = $qb->getQuery()->getResult();

        return $matRecursantes;
    }

    /**
     * Devuelve las asignaturas para cierta carrera.
     * Es llamada desde New y edit de InfoBasicaController
     *
     * @param string $carrera Codigo de la carrera a buscar
     * @return array|false
     */
    public function getAsignatura($carrera, $codigo_asignatura, $nro_modulo = null, $recursantes = null) {

        //estoy probando con un id estatico,  hasta que lo pase por parametros
        //$idAsignatura = 43 ;
        //Agregamos este if, porque si la asignatura tiene id es porque esta cargada en tabla materias        
        if (is_numeric($recursantes)) {
            //se esta buscando un asginatura que se dicta para recursantes
            $materiaRecursante = $this->getMatRecursantes($carrera, $codigo_asignatura, $nro_modulo);
            dump($materiaRecursante);exit;
            if (!empty($materiaRecursante)) {
                return array_shift($materiaRecursante);
            }
            return null;
        }
        
        
        if (is_numeric($nro_modulo)) {
            //se esta buscando un modulo
            $modulo = $this->getModulos($carrera, $codigo_asignatura, $nro_modulo);
            if (!empty($modulo)) {
                return array_shift($modulo);
            }
            return null;
        }

        $carreras_fich = $this->getCarreras(array($carrera));

        if (count($carreras_fich) > 0) {

            $c = array_shift($carreras_fich);
            $query = new \FICH\APIInfofich\Query\Carreras\QueryMateriasCarrera();

            $query->setUnidadAcademica(WSHelper::UA_FICH)
                    ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO)
                    ->setCarrera($c->getCodigoCarrera())
                    ->setPlan($c->getPlanCarrera())
                    ->setVersion($c->getVersionPlan())
                    ->soloMaterias(array($codigo_asignatura))
                    ->setWsEnv($this->wsEnv)
                    ->setCacheEnabled($this->wsCacheEnabled);

            $asignaturas = $query->getResultado();

            if (!$asignaturas) {
                $this->ultimoError = $query->getError();
                return false;
            } else if (count($asignaturas) > 0) {
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

        if (!empty($docentes)) {
            uasort($docentes, function($a, $b) {
                return strcasecmp($a->getApellido(), $b->getApellido());
            });
        }
        return $docentes;
    }

}
