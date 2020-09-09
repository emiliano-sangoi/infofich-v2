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
    
    /**
     * Muestra el contenido cargado de la planificacion.
     * 
     * @param Request $request
     * @return type
     */
    public function revisarAction(Request $request, \PlanificacionesBundle\Entity\Planificacion $planificacion)
    {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:revisar:revisar.html.twig', array(
            'planificacion' => $planificacion,
            'page_title' => 'Revisar borrador'
        ));
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }

//    public function newAction(Request $request) {
//
//        $planificacion = new \PlanificacionesBundle\Entity\Planificacion();
//        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion, array(
//            'api_infofich_service' => $this->get('api_infofich_service')
//        ));
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($planificacion);
//            $em->flush();
//
//            $this->addFlash('success', 'La planificacion creada correctamente.');
//
//            //Causar redireccion para evitar "re-submits" del form:
//            return $this->redirectToRoute('planificaciones_edit', array('id' => $planificacion->getId()));
//        }
//
//
//        return $this->render('PlanificacionesBundle:Planificacion:new.html.twig', array(
//                    'form' => $form->createView(),
//                    'planificacion' => $planificacion,
//                    'page_title' => 'Nueva planificación'
//        ));
//    }

//    public function editAction(Request $request, \PlanificacionesBundle\Entity\Planificacion $planificacion) {
//                  
//        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion, array(
//            'api_infofich_service' => $this->get('api_infofich_service')
//        ));
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $em = $this->getDoctrine()->getManager();            
//            $em->flush();
//
//            $this->addFlash('success', 'La planificacion fue modificada correctamente.');
//
//            //Causar redireccion para evitar "re-submits" del form:
//            return $this->redirectToRoute('planificaciones_edit', array('id' => $planificacion->getId()));
//        }
//
//
//        // dump($planificacion, $this->get('api_infofich_service'));exit;
////        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion);
////        $form->handleRequest($request);
////
////        if ($form->isSubmitted() && $form->isValid()) {
////
////            $em = $this->getDoctrine()->getManager();
////            $em->flush();
////
////            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');
////
////            //Causar redireccion para evitar "re-submits" del form:
////            return $this->redirectToRoute('planificaciones_edit', array('id' => $planificacion->getId()));
////        }
//
//
//        return $this->render('PlanificacionesBundle:Planificacion:edit.html.twig', array(
//                    'page_title' => 'Modificar planificación',
//                    'planificacion' => $planificacion
//        ));
//    }

    public function showNotificacionAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:Planificacion:mensaje.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }

}
