<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InfoBasicaController extends Controller {

    private function crearForm(Planificacion $planificacion, $action = null) {
        
        if(!$action){
            $action = $this->generateUrl('planificaciones_ajax_info_basica_post');
        }
        
        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion, array(
            'method' => 'POST',
            'action' => $action
        ));
        
        return $form;
    }

    /**
     * Controlador que muestra el formulario inicialmente
     * 
     * Cada vez que el usuario haga F5 se va a llegar a este controlador.
     * 
     * @return Response
     */
    public function getAction() {

        $planificacion = new Planificacion();
        $form = $this->crearForm($planificacion);

        return $this->render('PlanificacionesBundle:Planificacion:tab-informacion-basica.html.twig', array(
                    'form' => $form->createView(),
                    'planificacion' => $planificacion
        ));
    }

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
    public function postAction(Request $request) {

       /* $em = $this->getDoctrine()->getManager();
        if ($id_planificacion) {
            $planificacion = $em->getRepository('PlanificacionesBundle:Planificacion')->findOneBy($id_planificacion);
            if (!$planificacion) {
                throw new NotFoundHttpException("No se encontro ninguna planificacion con id $id_planificacion.");
            }
        } else {
            $planificacion = new Planificacion();
        }*/
        //$statusCode = Response::HTTP_BAD_REQUEST;
        
        $planificacion = new Planificacion();
        $form = $this->crearForm($planificacion);
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($planificacion);
                $em->flush();

                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

                //$statusCode = Response::HTTP_OK;
                return new Response($planificacion->getId());
                //Causar redireccion para evitar "re-submits" del form:
                //return $this->redirectToRoute('planificaciones_ajax_info_basica_edit', array('id' => $planificacion->getId()));
            }else{
                $this->addFlash('error', 'Hay errores en el formulario.');
            }
        }

        $response = $this->render('PlanificacionesBundle:Planificacion:tab-informacion-basica.html.twig', array(
            'form' => $form->createView(),
            'planificacion' => $planificacion
        ));
        //$response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        $response->setStatusCode(Response::HTTP_BAD_REQUEST);

        return $response;
    }
    
    
    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {
        
        $action = $this->generateUrl('planificaciones_ajax_info_basica_edit');
        $form = $this->crearForm($planificacion, $action);
        
        $statusCode = Response::HTTP_OK;
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($planificacion);
                $em->flush();

                $this->addFlash('success', 'Los datos de esta sección fueron modificados correctamente.');

                //Causar redireccion para evitar "re-submits" del form:
                return $this->redirectToRoute($action, array('id' => $planificacion->getId()));
            }else{
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

}