<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Exception;
use FICH\APIInfofich\Query\Query;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\HistoricoEstados;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\BuscadorType;
use PlanificacionesBundle\Form\DuplicarPlanificacionType;
use PlanificacionesBundle\PDF\PlanificacionesPDF;
use PlanificacionesBundle\Repository\HistoricoEstadosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanificacionController extends Controller {

    use PlanificacionTrait;

    public function indexAction(Request $request) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_LISTAR, array('data' => null));

        $form_filtros = $this->createForm(BuscadorType::class, null);
        $form_filtros->handleRequest($request);

        $paginator = $this->get('knp_paginator');
        $paginado = $paginator->paginate(
                $this->getPlanificacionesUsuario($form_filtros), /* query NOT result */ $request->query->getInt('page', 1), /* page number */ 10 /* limit per page */
        );

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("PLANIFICACIONES");


        return $this->render('PlanificacionesBundle:planificacion:inicio.html.twig', array(
                    'page_title' => 'Planificaciones de grado',
                    'form' => $form_filtros->createView(),
                    'paginado' => $paginado,
                    'puede_crear' => $this->isGranted(Permisos::PLANIF_CREAR, array('data' => null))
        ));
    }

    /**
     *
     * @param Form $form_filtros
     * @return Query|array
     */
    private function getPlanificacionesUsuario(Form $form_filtros) {

        $usuario = $this->getUser();
        $carrera = $form_filtros->get('carrera')->getData();
        $codigoAsignatura = $form_filtros->get('codigoAsignatura')->getData();
        $anioAcad = $form_filtros->get('anioAcad')->getData();

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Planificacion::class);
        return $repo->getPlanificacionesUsuario($usuario, $carrera, $codigoAsignatura, $anioAcad);
    }

    /**
     *
     *
     * @param Request $request
     * @return type
     */
    public function newAction(Request $request) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_CREAR, array('data' => null));

        $planificacion = new Planificacion();
        $form = $this->crearForm($planificacion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //nombre de la asignatura:
            $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
            $nombreAsignatura = Texto::ucWordsCustom($asignatura->getNombreMateria());
            $planificacion->setNombreAsignatura($nombreAsignatura);


            $em = $this->getDoctrine()->getManager();
            $em->persist($planificacion);
            $em->flush();

            //asignar estado: creada + en preparacion
            //---------------------------------------------------------------------------
            /* @var $repoHistorico HistoricoEstadosRepository */
            $repoHistorico = $em->getRepository(HistoricoEstados::class);

            $usuario = $this->getUser();
            $repoHistorico->setEstadoCreada($planificacion, $usuario);
            $repoHistorico->asignarEstado($planificacion, Estado::PREPARACION, $usuario);
            //---------------------------------------------------------------------------

            $this->addFlash('success', 'La planificacion fué creada correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem("NUEVA");


        return $this->render('PlanificacionesBundle:1-info-basica:edit.html.twig', array(
                    'form' => $form->createView(),
                    'info_basica_route' => $this->generateUrl('planificaciones_nueva'),
                    'planificacion' => $planificacion,
                    'page_title' => 'Nueva planificación'
        ));
    }

    public function borrarAction(Planificacion $planificacion, Request $request) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_BORRAR, array('data' => $planificacion));

        $form = $this->crearFormBorrarPlanif($planificacion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            try {

                //Borrar todos los estados
                $estados = $em->getRepository(HistoricoEstados::class)->findBy(array('planificacion' => $planificacion));
                foreach ($estados as $estado) {
                    $em->remove($estado);
                }

                //Borrar la planificacion:
                $em->remove($planificacion);

                //Impactar cambios:
                $em->flush();

                $this->addFlash('success', 'La planificacion fué borrada correctamente.');

                //Causar redireccion para evitar "re-submits" del form:
                return $this->redirectToRoute('planificaciones_homepage');
            } catch (ForeignKeyConstraintViolationException $ex) {
                
            } catch (Exception $ex) {
                
            }

            $this->addFlash('warning', 'Ocurrió un error al intentar borrar la planificación.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planificaciones_borrar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem("BORRAR");

        return $this->render('PlanificacionesBundle:planificacion:borrar.html.twig', array(
                    'page_title' => 'Borrar planificación',
                    'planificacion' => $planificacion,
                    'form' => $form->createView(),
                    // 'paginado' => $paginado,
                    'puede_borrar' => $this->isGranted(Permisos::PLANIF_BORRAR, array('data' => $planificacion))
        ));
    }


    /**
     * Crea una copia de una planificacion
     *
     * @param Request $request
     * @return Response
     */
    public function duplicarAction(Request $request, Planificacion $planificacion) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_DUPLICAR, array('data' => $planificacion));

        //dump($planificacion);exit;
        $form = $this->createForm(DuplicarPlanificacionType::class, $planificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            dump($planificacion);
            exit;
        }


        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem("DUPLICAR");


        return $this->render('PlanificacionesBundle:planificacion:duplicar.html.twig', array(
                    'page_title' => 'Duplicar planificación',
                    'planificacion' => $planificacion,
                    'form' => $form->createView(),
                    // 'paginado' => $paginado,
                    'puede_borrar' => $this->isGranted(Permisos::PLANIF_DUPLICAR, array('data' => $planificacion))
        ));
    }

    /**
     * Exporta la información de la planificacion a un archivo PDF
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     */
    public function imprimirAction(Request $request, Planificacion $planificacion) {
        
    //Datos que precisa 
    $detalleItems = array();

    //nombre de la asignatura:      
    $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
    $nombreAsignatura = Texto::ucWordsCustom($asignatura->getNombreMateria());
    $periodoLectivo = $asignatura->getPeriodoCursada();
    $anioCursada = $asignatura->getAnioCursada();
    $caracter  = $asignatura->getTipoCursada();
    $carrera = $this->get('api_infofich_service')->getCarrera($planificacion->getCarrera());
    $nombreCarrera = TexTo::ucWordsCustom($carrera->getNombreCarrera());
    $planEstudio =  TexTo::ucWordsCustom($carrera->getPlanCarrera());

    //Equipo Docente
    $docenteResponsable = $planificacion->getDocenteResponsable();
    $docentesColaboradores = $planificacion->getDocentesColaboradores();
    $docentesAdscriptos = $planificacion->getDocentesAdscriptos();

    
    //$docente_a_cargo = planificaciones_obtener_datos_docente_responsable($id_planificacion);

	//$plan = planificaciones_obtener_plan_estudio($planificacion['id_plan']);

	//$materia = planificaciones_obtener_materia($planificacion['id_asignatura']);

	//$departamento = planificaciones_obtener_departamento($materia['id_departamento']);


	//$docentes = planificaciones_obtener_docentes($id_planificacion);


        // buscamos la historia laboral detallada
      //  $filtros = array();
        
       /* foreach ($resultado as $item) {
            $arrayItem = array();
            array_push($arrayItem, $item['codigo']);
            array_push($arrayItem, $item['mes'] . '/' . $item['anio']);
            array_push($arrayItem, $item['tipoLiquidacion']);
            array_push($arrayItem, (strlen($item['nombre']) > 25) ? substr($item['nombre'], 0, 25) . '...' : $item['nombre']);
            array_push($arrayItem, (strlen($item['revista']) > 12) ? substr($item['revista'], 0, 12) . '.' : $item['revista']);
            array_push($arrayItem, number_format($item['remunerativo'], 2, ',', '.'));
            array_push($arrayItem, number_format($item['aportePersonal'], 2, ',', '.'));
            array_push($arrayItem, number_format($item['contribucionPatronal'], 2, ',', '.'));
            array_push($arrayItem, number_format($item['otrosConceptos'], 2, ',', '.'));

            array_push($detalleItems, $arrayItem);
        }*/

        $tabla_cab = array('Código', 'Periodo', 'T.Liq', 'Organismo', 'Revista', 'Remun.', 'Ap.Personal', 'Cont.Patronal', 'Otros Conc.');
        $tabla_det = $detalleItems;

        $parametros = array(
            'titulo' =>  'Planificaciones 2021',
            'anio' => '2021',
            'id' => 1,// $persona->getId(),
            'nombreAsignatura' => $nombreAsignatura, //$persona->getApeNom(),
            'nombreCarrera' => $nombreCarrera,
            'departamento' => $planificacion->getDepartamento(),
            'planEstudio' => $planEstudio,
            'periodoLectivo' => $periodoLectivo,
            'anioCursada' => $anioCursada,
            'caracter' => $caracter,
            'docenteResponsable' => $docenteResponsable,
            'docentesColaboradores' => $docentesColaboradores,
            'docentesAdscriptos' => $docentesAdscriptos,
            /*'nombre' => 'romina', // $persona->getNombres(),
            'cuil' => 4444,
            'tipoDocumento' => 'romina', 
            'nroDocumento' => 'romina',
            //'tabla_cab' => $tabla_cab,*/
            //'tabla_det' => $tabla_det
        );

        $em = $this->getDoctrine()->getManager();

        
        $parametros['usuario'] = 'romina';//$this->getUser()->getUsername();
        $pdf = new PlanificacionesPDF($parametros);
        $pdf->render();
//ver que sale mal el nombre cuando tiene acentos
        $nombreArch = 'PLANIFICACION_'.utf8_encode($parametros['nombreAsignatura']).'.pdf';

        $pdf->Output($nombreArch, 'I');
    }


    public function getAsJsonAction(Planificacion $planificacion) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_VER, array('data' => $planificacion));

        return new JsonResponse($planificacion, Response::HTTP_OK);
    }

    public function enviarACorreccionAction(Request $request, Planificacion $planificacion) {
        
        $this->denyAccessUnlessGranted(Permisos::PLANIF_ENVIAR_CORRECCION, array('data' => $planificacion));

        if (!$planificacion->enRevision()) {
            $this->addFlash('warning', 'No se puede enviar a corrección esta planificación. Estado actual incorrecto.');

            return $this->redirectToRoute('planificaciones_revisar', array('id' => $planificacion->getId()));
        }

        $form = $this->crearFormEnviarACorreccion($planificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            /* @var $repoHistorico HistoricoEstadosRepository */
            $repoHistorico = $em->getRepository(HistoricoEstados::class);
            
            $histEstadoActual = $planificacion->getHistoricoEstadoActual();
            $comentario = $histEstadoActual->getComentario();

            $usuario = $this->getUser();
            $repoHistorico->asignarEstado($planificacion, Estado::CORRECCION, $usuario, $comentario);

            $this->addFlash('success', 'Planificación enviada a corrección.');
            return $this->redirectToRoute('planificaciones_revisar', array('id' => $planificacion->getId()));
        }


        $this->addFlash('danger', 'Ocurrieron errores al enviar la planificación a corrección.');
        return $this->redirectToRoute('planificaciones_revisar', array('id' => $planificacion->getId()));
    }    

}
