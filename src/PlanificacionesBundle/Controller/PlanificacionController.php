<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlanificacionController extends Controller {

    public function indexAction(Request $request) {

        return $this->render('PlanificacionesBundle:planificacion:inicio.html.twig');
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function newAction(Request $request) {

        $planificacion = new Planificacion();
        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion, array(
            'api_infofich_service' => $this->get('api_infofich_service')
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($planificacion);
            $em->flush();
            
            //asignar estado:
            $repoHistorico = $em->getRepository('\PlanificacionesBundle\Entity\HistoricoEstados');
            $repoHistorico->asignarEstado($planificacion, \PlanificacionesBundle\Entity\Estado::PREPARACION);

            $this->addFlash('success', 'La planificacion creada correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $planificacion->getId()));
        }


        return $this->render('PlanificacionesBundle:1-info-basica:edit.html.twig', array(
                    'form' => $form->createView(),
                    'info_basica_route' => $this->generateUrl('planificaciones_nueva'),
                    'planificacion' => $planificacion,
                    'page_title' => 'Nueva planificación'
        ));
    }

    /**
     * Muestra el contenido cargado de la planificacion.
     * 
     * @param Request $request
     * @return type
     */
    public function revisarAction(Request $request, Planificacion $planificacion) {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:planificacion:revisar.html.twig', array(
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
        return $this->render('PlanificacionesBundle:planificacion:mensaje.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }

}
