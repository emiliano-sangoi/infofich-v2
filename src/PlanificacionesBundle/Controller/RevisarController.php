<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use FICH\APIInfofich\Model\Carrera;
use FICH\APIInfofich\Model\Materia;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\HistoricoEstados;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto;
use PlanificacionesBundle\Entity\PlanificacionDocenteColaborador;
use PlanificacionesBundle\Repository\HistoricoEstadosRepository;
use PlanificacionesBundle\Service\PlanificacionService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PlanificacionesBundle\Entity\ActividadCurricular;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Acciones relacionadas a la revision de una planificacion
 *
 * @author emi88
 */
class RevisarController extends Controller {

    private $resumen;
    private $infofichService;
    private $errores;

    use PlanificacionTrait;

    /**
     * Muestra el contenido cargado de la planificacion.
     *
     * @param Request $request
     * @return type
     */
    public function revisarAction(Request $request, Planificacion $planificacion) {

        /* @var $planifService PlanificacionService */
        $planifService = $this->get('planificaciones_service');

        $params = array(
            'planificacion' => $planificacion,
            'errores' => $planifService->getErrores($planificacion),
            'page_title' => $this->getPageTitle($planificacion) . ' - Revisar planificación',
            'form_publicar' => $this->crearFormPublicarPlanif($planificacion)->createView()
        );

        if ($planificacion->enPreparacion() || $planificacion->enCorreccion()) {

            $form = $this->crearFormEnviarPlanif($planificacion);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                if (!$planifService->getHayErrores($planificacion)) {

                    /* @var $repoHistorico HistoricoEstadosRepository */
                    $repoHistorico = $this->getDoctrine()->getManager()->getRepository(HistoricoEstados::class);

                    $usuario = $this->getUser();
                    $repoHistorico->asignarEstado($planificacion, Estado::REVISION, $usuario);

                    $this->addFlash('success', 'Planificación enviada a revisión.');
                    return $this->redirectToRoute('planificaciones_revisar', array('id' => $planificacion->getId()));
                } else {
                    $this->addFlash('error', 'La planificación posee errores. Intente nuevamente luego de corregirlos.');
                }
            }

            $params['form_enviar_revision'] = $form->createView();                                               
            
        } elseif( $planificacion->enRevision() ) {
            
            $params['form_enviar_correccion'] = $this->crearFormEnviarACorreccion($planificacion)->createView();
            
        } else {
            $this->addFlash('danger', 'Solo puede enviar planificaciones que se encuentren en revisión o corrección');
            //return $this->redirectToRoute('planificaciones_revisar', array('id' => $planificacion->getId()));
        }

        //titulo principal:
        $infofichService = $this->get('api_infofich_service');
        $asignatura = $infofichService->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $params['asignatura'] = $asignatura;

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem("REVISAR");

        //Resumen de la planificacion
        $this->setInfoPlanif($planificacion);
        $params['resumen'] = $this->resumen;

        //Permisos:
        $params['puede_enviar_a_revision'] = $this->isGranted(Permisos::PLANIF_ENVIAR_REVISION);


        //dump($planificacion->getDocenteResponsable()->getDocente()->getPersona()->getApellidos());exit;
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:planificacion:revisar2.html.twig', $params);
    }


    public function publicarAction(Request $request, Planificacion $planificacion) {
        
        $this->denyAccessUnlessGranted(Permisos::PLANIF_PUBLICAR, array('data' => $planificacion));
        
        $form = $this->crearFormPublicarPlanif($planificacion);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            /* @var $planifService PlanificacionService */
            $planifService = $this->get('planificaciones_service');
            
            if (!$planifService->getHayErrores($planificacion)) {

                    /* @var $repoHistorico HistoricoEstadosRepository */
                    $repoHistorico = $this->getDoctrine()->getManager()->getRepository(HistoricoEstados::class);

                    $usuario = $this->getUser();
                    $repoHistorico->asignarEstado($planificacion, Estado::PUBLICADA, $usuario);

                    $this->addFlash('success', 'La planificación fue publicada correctamente.');                    
                } else {
                    $this->addFlash('error', 'La planificación posee errores. Intente nuevamente luego de corregirlos.');
                }
            
            
        }
        
        return $this->redirectToRoute('planificaciones_revisar', array('id' => $planificacion->getId()));        
        
    }

    /**
     * Metodo que permite actualizar las correcciones o comentarios de una planificacion
     * 
     * @param Planificacion $planificacion
     * @param Request $request
     * @return \PlanificacionesBundle\Controller\JsonResponse
     */
    public function actualizarComentariosAction(Planificacion $planificacion, Request $request) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'mensaje' => 'Esta accion solo se puede utilizar via AJAX.'
                    ), Response::HTTP_BAD_REQUEST);
        }

        $histEstadoActual = $planificacion->getHistoricoEstadoActual();
        $eActual = $histEstadoActual->getEstado();
        if ($eActual && !in_array($eActual->getCodigo(), array(Estado::REVISION, Estado::CORRECCION))) {
            return new JsonResponse(array(
                'mensaje' => 'Solo se puede actualizar comentarios de planificaciones en revision.'
                    ), Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent());
        
        if (!$data) {            
            return new JsonResponse(array(
                'mensaje' => 'No se pudo extraer el contenido a actualizar. El formato de los datos debe ser JSON.'
                    ), Response::HTTP_BAD_REQUEST);
        }
  
        $comentarios = filter_var($data->comentarios, FILTER_SANITIZE_STRING);

        $histEstadoActual->setComentario($comentarios);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse(array(
            'data' => $planificacion
                ), Response::HTTP_OK);
        
    }

    /**
     * Funcion auxiliar que setea toda la informacion de la planificacion
     * 
     * @param Planificacion $planificacion
     */
    private function setInfoPlanif(Planificacion $planificacion) {

        $this->resumen = array();
        $this->infofichService = $this->get('api_infofich_service');

        $this->addInfoBasica($planificacion);
        $this->addDocentes($planificacion);
        // validación datos cargados
        $requisitos = $planificacion->getRequisitosAprobacion();
        if (isset($requisitos)) {
            $this->addRequisitos($planificacion);
            $this->resumen['ver_requisitos'] = 1;
        } else {
            $this->resumen['ver_requisitos'] = 0;
        }
        $this->addObjetivos($planificacion);
        //Resultados
        $resultados = $planificacion->getResultados();
        if (isset($resultados)) {
            $this->resumen['ver_resultados'] = 1;
            $this->addResultados($planificacion);
        } else {
            $this->resumen['ver_resultados'] = 0;
        }

        $this->addTemario($planificacion);
        $this->addBibliografia($planificacion);
        $this->addCronograma($planificacion);
        $this->addCronogramaSemana($planificacion);
        $this->addDistribucion($planificacion);
        $this->addViaje($planificacion);
    }

    public function showNotificacionAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:planificacion:mensaje.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }

    /**
     * Funcion auxiliar que busca y valida los campos a mostrar en el resumen.
     * Se encarga de asugar que los campos necesarios esten seteados, con valores o null en su defecto.
     * Tambien les da el formato final a utilizar en la twig.
     *
     * @param Planificacion $planificacion
     */
    private function addInfoBasica(Planificacion $planificacion) {

        $this->resumen['carrera'] = null;
        $this->resumen['carrera_plan'] = null;
        $this->resumen['anioAcad'] = $planificacion->getAnioAcad();
        $this->resumen['nombreMateria'] = null;
        $this->resumen['contenidosMinimos'] = $planificacion->getContenidosMinimos();


        /* Carrera {#796 ▼
          #codigoCarrera: "03"
          #nombreCarrera: "INGENIERÍA EN INFORMÁTICA"
          #planCarrera: "2006"
          #versionPlan: "29"
          #estado: "V"
          #tipoTitulo: 1
          #tipoCarrera: "Grado"
         */
        //obtiene las carreras de grado de la fich:
        $carrera = $this->infofichService->getCarrera($planificacion->getCarrera());
        if ($planificacion->getCarrera() && $carrera instanceof Carrera) {
            $this->resumen['carrera'] = $planificacion->getCarrera() . ' - ' . $carrera->getNombreCarrera();
            $this->resumen['carrera_plan'] = $carrera->getPlanCarrera();
        }

        //Ejemplo de campos de una materia:
        /* Materia {#787 ▼
          #codigoMateria: "00716"
          #nombreMateria: "INTELIGENCIA ARTIFICIAL"
          #tipoMateria: "O"
          #horasSemanales: null
          #cargaHoraria: null
          #valorMateria: "60"
          #promediable: true
          #obligatoria: false
          }
         */
        $asignatura = $this->infofichService->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        if ($asignatura instanceof Materia) {
            $this->resumen['nombreMateria'] = $asignatura->getNombreMateria();
        }
    }

    /**
     * Funcion auxiliar que busca y valida los campos a mostrar en el resumen.
     * Se encarga de asugar que los campos necesarios esten seteados, con valores o null en su defecto.
     * Tambien les da el formato final a utilizar en la twig.
     *
     * @param Planificacion $planificacion
     */
    private function addDocentes(Planificacion $planificacion) {

        $this->resumen['docente_resp'] = null;

        if ($planificacion->getDocenteResponsable()) {
            $this->resumen['docente_resp'] = $planificacion->getDocenteResponsable()->getPersona()->getApeNom(true);
        }

        $this->resumen['docentes_colab'] = null;
        $i = 0;
        /* @var $docente PlanificacionDocenteColaborador */
        foreach ($planificacion->getDocentesColaboradores() as $docente) {
            $this->resumen['docentes_colab'][] = $docente->getDocenteGrado()->getPersona()->getApeNom(true);
            $i++;
        }
        $this->resumen['docentes_colab_count'] = $i;


        $this->resumen['docentes_adscriptos'] = null;
        $i = 0;
        /* @var $docente PlanificacionDocenteAdscripto */
        foreach ($planificacion->getDocentesAdscriptos() as $docente) {
            $cod_ape_nom = $docente->getDocenteAdscripto()->__toString();
            // dump($cod_ape_nom, $docente->getDocente());exit;
            $cod_ape_nom .= ' (Resolución N° ' . $docente->getDocenteAdscripto()->getResolucion() . ')';
            $this->resumen['docentes_adscriptos'][] = $cod_ape_nom;
            $i++;
        }
        $this->resumen['docentes_adscriptos_count'] = $i;

        //  dump($this->resumen);exit;
    }

    /**
     *
     * @param Planificacion $planificacion
     */
    private function addRequisitos(Planificacion $planificacion) {

        $requisitos = $planificacion->getRequisitosAprobacion();

        $this->resumen['porcentajeAsistencia'] = null;
        $this->resumen['fechaPrimerParcial'] = null;
        $this->resumen['fechaSegundoParcial'] = null;
        $this->resumen['fechaRecupPrimerParcial'] = null;
        $this->resumen['fechaRecupSegundoParcial'] = null;
        $this->resumen['prevePromParcialTeoria'] = null;
        $this->resumen['prevePromParcialPractica'] = null;
        $this->resumen['preveCfi'] = null;
        $this->resumen['modalidadCfi'] = null;
        $this->resumen['fechaParcialCfi'] = null;
        $this->resumen['fechaRecupCfi'] = null;
        $this->resumen['examenFinalModalidadRegulares'] = null;
        $this->resumen['examenFinalModalidadLibres'] = null;

        if ($requisitos) {
            $this->resumen['porcentajeAsistencia'] = $requisitos->getPorcentajeAsistencia();
            //parciales y recuperatorios
            $this->resumen['fechaPrimerParcial'] = $requisitos->getFechaPrimerParcial();
            $this->resumen['fechaSegundoParcial'] = $requisitos->getFechaSegundoParcial();

            $this->resumen['fechaRecupPrimerParcial'] = $requisitos->getFechaRecupPrimerParcial();
            $this->resumen['fechaRecupSegundoParcial'] = $requisitos->getFechaRecupSegundoParcial();

            if ($requisitos->getPrevePromParcialTeoria()) {
                $this->resumen['prevePromParcialTeoria'] = 'Sí';
            } else {
                $this->resumen['prevePromParcialTeoria'] = 'No';
            }

            if ($requisitos->getPrevePromParcialPractica()) {
                $this->resumen['prevePromParcialPractica'] = 'Sí';
            } else {
                $this->resumen['prevePromParcialPractica'] = 'No';
            }

            if ($requisitos->getPreveCfi()) {
                $this->resumen['preveCfi'] = 'Sí';
            } else {
                $this->resumen['preveCfi'] = 'No';
            }

            //$this->resumen['modalidadCfi'] = $requisitos->getModalidadCfi();
            if ($requisitos->getModalidadCfi()) {
                $this->resumen['modalidadCfi'] = $requisitos->getModalidadCfi();
            }

            $this->resumen['fechaParcialCfi'] = $requisitos->getFechaParcailCfi();
            $this->resumen['fechaRecupCfi'] = $requisitos->getFechaRecupCfi();

            $this->resumen['examenFinalModalidadRegulares'] = $requisitos->getExamenFinalModalidadRegulares();
            $this->resumen['examenFinalModalidadLibres'] = $requisitos->getExamenFinalModalidadLibres();
        }
    }

    /**
     *
     * @param Planificacion $planificacion
     */
    private function addObjetivos(Planificacion $planificacion) {
        $this->resumen['objetivosGral'] = null;
        $this->resumen['objetivosEspecificos'] = null;

        $this->resumen['objetivosGral'] = $planificacion->getObjetivosGral();
        $this->resumen['objetivosEspecificos'] = $planificacion->getObjetivosEspecificos();
    }

    /**
     *
     * @param Planificacion $planificacion
     */
    private function addResultados(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['resultados'] = null;
        $resultados = $planificacion->getResultados();
        $this->resumen['resultados'] = $resultados;
    }

    /**
     *
     * @param Planificacion $planificacion
     */
    private function addTemario(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['temario'] = null;
        $temario = $planificacion->getTemario();
        $this->resumen['temario'] = $temario;
    }

    /**
     *
     * @param Planificacion $planificacion
     */
    private function addBibliografia(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['bibliografia'] = null;
        $this->resumen['bibliografia'] = $planificacion->getBibliografias();
    }

    /**
     *
     * @param Planificacion $planificacion
     */
    private function addCronograma(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['cronograma'] = null;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(ActividadCurricular::class);
//        $qb = $repo->crearQueryBuilder($planificacion);
//        $qb->join('a.temario', 't');
//        $qb->orderBy('t.unidad', 'ASC');
//        $qb->addOrderBy('a.fecha', 'ASC');
//dump($repo->getActividadesPorTema($planificacion));exit;
        $this->resumen['cronograma'] = $repo->getActividadesPorTema($planificacion);
    }

    private function addCronogramaSemana(Planificacion $planificacion) {
        $this->resumen['cronograma2'] = null;
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(ActividadCurricular::class);

        $this->resumen['cronograma2'] = $repo->getActividadesPorSemana($planificacion);
    }

    /**
     *
     * @param Planificacion $planificacion
     */
    private function addDistribucion(Planificacion $planificacion) {
        $this->resumen['totalCargaHorariaAula'] = $planificacion->getTotalCargaHorariaAula();
        $this->resumen['totalCargaHorariaAutonomo'] = $planificacion->getTotalCargaHorariaAutonomo();
        $this->resumen['totalTeoria'] = $planificacion->getTotalTeoria();
        $this->resumen['totalColoquio'] = $planificacion->getTotalColoquio();
        $this->resumen['totalTeoricoPractica'] = $planificacion->getTotalTeoricoPractica();
        $this->resumen['totalFormacionPractica'] = $planificacion->getTotalFormacionPractica();
        $this->resumen['totalConsulta'] = $planificacion->getTotalConsulta();
        $this->resumen['totalEvaluacion'] = $planificacion->getTotalEvaluacion();
        $this->resumen['totalOtrasAct'] = $planificacion->getTotalOtrasAct();
    }

    /**
     *
     * @param Planificacion $planificacion
     */
    private function addViaje(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['viajes'] = null;
        $viajes = $planificacion->getViajesAcademicos();
        $this->resumen['viajes'] = $viajes;
    }

}
