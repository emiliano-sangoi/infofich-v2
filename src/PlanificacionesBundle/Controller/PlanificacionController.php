<?php

namespace PlanificacionesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlanificacionController extends Controller {

    private $router = array(
            //'info-basica': 
    );

    public function indexAction(Request $request) {

        return $this->render('PlanificacionesBundle:Planificacion:inicio.html.twig');
    }

    public function newAction() {
        return $this->render('PlanificacionesBundle:Planificacion:new.html.twig', array(
                    'page_title' => 'Nueva planificación',
        ));
    }

    public function editAction(Request $request, \PlanificacionesBundle\Entity\Planificacion $planificacion) {
        
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


        return $this->render('PlanificacionesBundle:Planificacion:edit.html.twig', array(
                    'page_title' => 'Modificar planificación',
                    'planificacion' => $planificacion
        ));
    }

    public function showNotificacionAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:Planificacion:mensaje.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }

}
