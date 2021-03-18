<?php

namespace DocentesBundle\Service;

use AppBundle\Entity\Persona;
use AppBundle\Repository\PersonaRepository;
use AppBundle\Service\APIInfofichService;
use DateTime;
use DocentesBundle\Entity\DocenteGrado;
use DocentesBundle\Repository\DocenteGradoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use FICH\APIInfofich\Model\Docente;
use FICH\APIRectorado\Config\WSHelper;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of DocenteService
 *
 * @author emi88
 */
class DocenteService {

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
     * @var DocenteGradoRepository 
     */
    private $repoDocentesGrado;

    /**
     *
     * @var PersonaRepository 
     */
    private $repoPersona;

    /**
     *
     * @var APIInfofichService 
     */
    private $apiInfofichService;

    /**
     *
     * @var array 
     */
    private $docentesBD;

    /**
     *
     * @var array 
     */
    private $docentesWS;

    /**
     *
     * @var array 
     */
    private $reporte;

    /**
     *
     * @var ValidatorInterface 
     */
    private $validator;

    public function __construct(EntityManager $entityManager, APIInfofichService $apiInfofichService, ValidatorInterface $validator) {

        $this->em = $entityManager;
        $this->repoDocentesGrado = $this->em->getRepository(DocenteGrado::class);
        $this->repoPersona = $this->em->getRepository(Persona::class);
        $this->apiInfofichService = $apiInfofichService;
        $this->validator = $validator;
    }

    /**
     * Actualiza los datos en la BD en funcion de los nuevos usuarios y bajas del reporte.
     * 
     * @return boolean
     */
    public function actualizar() {
        return $this->procesar(false);
    }

    /**
     * Permite generar estadisticas sobre los nuevos docentes, actualizaciones y bajas en función de la consulta al WS de rectorado.
     * 
     * @return boolean
     */
    public function generarReporte() {
        return $this->procesar(true);
    }

    /**
     * Permite realizar una comparación entre lo existente en el web service y lo de la base de datos.
     * El metodo permite actualizar o crear nuevos registros en función del parametro dryrun ingresado.
     * 
     * @param boolean $dryrun Si es true la ejecucion es segura, es decir que no se impactan en la BD
     * 
     * @return boolean
     */
    private function procesar($dryrun = true) {

        $this->reporte = array(
            'nuevos' => array(),
            'nuevos_cant' => 0,
            'inactivos' => array(),
            'inactivos_cant' => 0,
            'actualizados' => array(),
            'actualizados_cant' => 0,
            'personas_nuevas' => array(),
            'personas_nuevas_cant' => 0,
        );

        if (!$this->docentesWS) {
            $this->docentesWS = $this->apiInfofichService->getDocentesActivos();
        }

        $legajos = array();

        /* @var $qb QueryBuilder */
        $qb = $this->repoDocentesGrado->createQueryBuilder('d');
        $qb->andWhere($qb->expr()->isNull('d.fechaInactivo'));

        $cn = $ca = $ci = $tot = 0;

        $it = $qb->getQuery()->iterate();

        foreach ($it as $row) {

            /* @var $docenteBD DocenteGrado */
            $docenteBD = $row[0];

            $leg = $docenteBD->getNroLegajo();
            if (!isset($this->docentesWS[$leg])) {
                //dar de baja
                $this->reporte['inactivos'][] = $docenteBD;
                if (!$dryrun) {
                    $docenteBD->setFechaBaja(new DateTime());
                    $this->em->flush();
                }
                $ci++;
            } else {
                //actualizar
                $this->reporte['actualizados'][] = $docenteBD;

                if (!$dryrun && !$this->updateDocente($docenteBD, $this->docentesWS[$leg])) {
                    return false;
                }

                $ca++;
            }

            $legajos[] = $docenteBD->getNroLegajo();
        }

        /* @var $docenteWS Docente */
        foreach ($this->docentesWS as $docenteWS) {
            if (!in_array($docenteWS->getNumeroLegajo(), $legajos)) {
                $this->reporte['nuevos'][] = $docenteWS;
                $legajos[] = $docenteWS->getNumeroLegajo();

                if (!$dryrun && !$this->newDocente($docenteWS)) {
                    return false;
                    //$this->actualizarDocente($docenteBD, $this->docentesWS[$leg]);
                }

                $cn++;
            }
        }

        $this->reporte['nuevos_cant'] = $cn;
        $this->reporte['inactivos_cant'] = $ci;
        $this->reporte['actualizados_cant'] = $ca;

        return true;
    }

    /**
     * Actualiza un docente existen en la BD.
     * 
     * Como ejemplo, los datos que vienen en WS son:
     * 
     * FICH\APIInfofich\Model\Docente {#1182
     *       -numeroLegajo: "013282"
     *       -tipoDocumento: "DNI"
     *       -numeroDocumento: "35239029"
     *       -cuil: "27-35239029-7"
     *       -apellido: "ABRILE"
     *       -nombre: "MARIANA GUADALUPE"
     *       -email: "marianaabrile@gmail.com"
     *       -cargosAsociados: array:1 [
     *         0 => FICH\APIInfofich\Model\Cargo {#1183
     *           -numeroCargo: "000135313"
     *           -escalafon: "D"
     *          -codigoCategoria: "JTP1"
     *           -descripcionCategoria: "Jefe Trab. Prácticos"
     *          -codigoCaracter: "CONT"
     *           -descripcionCaracter: "Docente Contratado"
     *           -dedicacion: "Simple              "
     *           -horas: "10"
     *           -horasCatedra: "-1"
     *           -tipoHoras: "s"
     *           -codigoUADesignacion: "321"
     *           -uaDesignacion: "Fac. de Ing. y Cs. Hídricas"
     *           -codigoLugarDesempenio: "    "
     *           -lugarDesempenio: ""
     *           -fechaAlta: "2020-04-01"
     *           -fechaBaja: "2021-03-31"
     *           -estado: "activo"
     *         }
     *       ]
     *   }
     *
     * 
     * @param DocenteGrado $docente
     * @param Docente $docenteWS
     * 
     * @return boolean
     */
    private function updateDocente(DocenteGrado $docente, Docente $docenteWS) {

        $this->ultimoError = '';
        $cod_tipo_doc = WSHelper::getCodigoTipoDocPorDesc($docenteWS->getTipoDocumento());

        $persona = $docente->getPersona();
        $persona->setTipoDocumento($cod_tipo_doc);
        $persona->setDocumento($docenteWS->getNumeroDocumento());
        $persona->setCuil($docenteWS->getCuil());
        
        $ape = ucwords( strtolower($docenteWS->getApellido()) );
        $persona->setApellidos( $ape );
        
        $nom = ucwords( strtolower($docenteWS->getNombre()) );
        $persona->setNombres($nom);
        
        $persona->getEmail($docenteWS->getEmail());

        $docente->setFechaUltimaActualizacion(new \DateTime());

        $errors = $this->validator->validate($docente);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $this->ultimoError = (string) $errors;
            $this->ultimoError .= " - Persona: " . $persona;
        } else {
            // $this->em->persist($docente);
            //  $docentes[] = $docente;
            $this->em->flush();
            return true;
        }

        return false;
    }

    /**
     * Crea un nuevo docente en la base de datos a partir del docente del web service.
     * 
     * @param Docente $docenteWS
     * @return boolean
     */
    private function newDocente(Docente $docenteWS) {

        $cod_tipo_doc = WSHelper::getCodigoTipoDocPorDesc($docenteWS->getTipoDocumento());
        /* @var $persona Persona */
        $persona = $this->repoPersona->findOneBy(array(
            'tipoDocumento' => $cod_tipo_doc,
            'documento' => $docenteWS->getNumeroDocumento(),
        ));

        if (!$persona) {
            $persona = new Persona();
            $persona->setTipoDocumento($cod_tipo_doc);
            $persona->setDocumento($docenteWS->getNumeroDocumento());
            $persona->setCuil($docenteWS->getCuil());
            $persona->setApellidos($docenteWS->getApellido());
            $persona->setNombres($docenteWS->getNombre());
            $persona->getEmail($docenteWS->getEmail());
            $this->reporte['personas_nuevas'][] = $persona;
            $this->reporte['personas_nuevas_cant'] ++;
        }

        $docente = new DocenteGrado();
        $docente->setPersona($persona);
        $docente->setEmail($docenteWS->getEmail());
        $docente->setNroLegajo($docenteWS->getNumeroLegajo());

        $errors = $this->validator->validate($docente);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $this->ultimoError = (string) $errors;
        } else {
            $this->em->persist($docente);
            $this->em->flush();
            return true;
        }

        return false;
    }

    public function getUltimoError() {
        return $this->ultimoError;
    }

    public function getReporte() {
        return $this->reporte;
    }

}
