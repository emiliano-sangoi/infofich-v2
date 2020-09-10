<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\CargaHoraria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 
 */
class ObjetivosController extends Controller {

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\ObjetivosType", $planificacion);
        $form->handleRequest($request);

//        $statusCode = Response::HTTP_OK;

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //los campos objetivos esta dentro de la entidad Planificacion
            $em->persist($planificacion);
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_objetivos_editar', array('id' => $planificacion->getId()));
        }

        return $this->render('PlanificacionesBundle:4-objetivos-asignatura:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => 'Objetivos de la asignatura',
                    'planificacion' => $planificacion
        ));
    }

//     public function editAction(Request $request, Planificacion $planificacion) {
//
//        $form = $this->createForm("PlanificacionesBundle\Form\ObjetivosType", $planificacion);
//        $form->handleRequest($request);
//
//        $statusCode = Response::HTTP_OK;
//
//        if ($form->isSubmitted()) {
//            if ($form->isValid()) {
//                $em = $this->getDoctrine()->getManager();
//                //los campos objetivos esta dentro de la entidad Planificacion
//                $em->persist($planificacion);
//                $em->flush();
//
//                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');
//
//                return $this->redirectToRoute('planificacion_ajax_objetivos_editar', array('id' => $planificacion->getId()));
//                
//            } else {
//                $statusCode = Response::HTTP_BAD_REQUEST;
//                $this->addFlash('error', 'Hay errores en el formulario.');
//            }
//        }
//        return $this->render('PlanificacionesBundle:Planificacion:tab-objetivos.html.twig', array(
//                    'form' => $form->createView()
//                        // ...
//        ));
//    }
}
