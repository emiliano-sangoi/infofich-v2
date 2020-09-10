<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InfoBasicaController extends Controller {   

    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion, array(
            'api_infofich_service' => $this->get('api_infofich_service'),
//            'planificacion' => $planificacion
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Cambios guardados correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_equipo_docente_editar', array('id' => $planificacion->getId()));
        }


        // dump($planificacion, $this->get('api_infofich_service'));exit;
//        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $em = $this->getDoctrine()->getManager();
//            $em->flush();
//
//            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');
//
//            //Causar redireccion para evitar "re-submits" del form:
//            return $this->redirectToRoute('planificaciones_edit', array('id' => $planificacion->getId()));
//        }


        return $this->render('PlanificacionesBundle:1-info-basica:edit.html.twig', array(
             'form' => $form->createView(),
                    'page_title' => 'Modificar planificación',
                    'planificacion' => $planificacion,
                    'info_basica_route' => $this->generateUrl('planif_info_basica_editar', array('id' => $planificacion->getId())),
        ));
    }

//    public function editAction(Request $request) {
//
//        $planificacion = new Planificacion();
//        $form = $this->crearForm($planificacion);
////dump($planificacion, $this->get('api_infofich_service'));exit;
//        return $this->render('PlanificacionesBundle:info-basica:index.html.twig', array(
//                    'form' => $form->createView(),
//                    'planificacion' => $planificacion
//        ));
//    }

//    private function crearForm(Planificacion $planificacion, $action = null) {
//
//        if (!$action) {
//            $action = $this->generateUrl('planificaciones_ajax_info_basica_post');
//        }
//
//        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion, array(
//            'method' => 'POST',
//            'action' => $action,
//            'api_infofich_service' => $this->get('api_infofich_service')
//        ));
//
//        return $form;
//    }

    /**
     * Controlador que muestra el formulario inicialmente
     * 
     * Cada vez que el usuario haga F5 se va a llegar a este controlador.
     * 
     * @return Response
     */
//    public function getAction() {
//
//        $planificacion = new Planificacion();
//        $form = $this->crearForm($planificacion);
////dump($planificacion, $this->get('api_infofich_service'));exit;
//        return $this->render('PlanificacionesBundle:Planificacion:tab-informacion-basica.html.twig', array(
//                    'form' => $form->createView(),
//                    'planificacion' => $planificacion
//        ));
//    }

    /**
     * Metodo que maneja la creacion del formulario.
     * 
     * Muestra la informacion basica de una planificacion:
     *      - Carrera
     *      - Asignatura
     *      - Año academico
     *      - Departamento
     *      - Contenidos minimos
     * 
     * En el caso de que id de planificacion sea null va a crear una planificacion vacia.
     * 
     * @param Request $request
     * @param int|null $id_planificacion
     * @return Response
     * @throws NotFoundHttpException
     */
//    public function postAction(Request $request) {
//
//        $planificacion = new Planificacion();
//        $form = $this->crearForm($planificacion);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted()) {
//            if ($form->isValid()) {
//                $em = $this->getDoctrine()->getManager();
//                $em->persist($planificacion);
//                $em->flush();
//
//                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');
//
//                return new Response($planificacion->getId());
//            } else {
//                $this->addFlash('error', 'Hay errores en el formulario.');
//            }
//        }
//
//        $response = $this->render('PlanificacionesBundle:Planificacion:tab-informacion-basica.html.twig', array(
//            'form' => $form->createView(),
//            'planificacion' => $planificacion
//        ));
//        $response->setStatusCode(Response::HTTP_BAD_REQUEST);
//
//        return $response;
//    }

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    /*  public function editAction(Request $request, Planificacion $planificacion) {

      $action = $this->generateUrl('planificaciones_ajax_info_basica_edit', array('id' => $planificacion->getId()));
      $form = $this->crearForm($planificacion, $action);

      // dump($planificacion);exit;

      $statusCode = Response::HTTP_OK;

      $form->handleRequest($request);
      if ($form->isSubmitted()) {
      if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($planificacion);
      $em->flush();

      $this->addFlash('success', 'Los datos de esta sección fueron modificados correctamente.');

      //Causar redireccion para evitar "re-submits" del form:
      return $this->redirect($action);
      } else {
      $statusCode = Response::HTTP_BAD_REQUEST;
      $this->addFlash('error', 'Hay errores en el formulario.');
      }
      }

      $response = $this->render('PlanificacionesBundle:Planificacion:tab-informacion-basica.html.twig', array(
      'form' => $form->createView(),
      'planificacion' => $planificacion
      ));
      //$response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
      $response->setStatusCode($statusCode);

      return $response;
      }
     */
}
