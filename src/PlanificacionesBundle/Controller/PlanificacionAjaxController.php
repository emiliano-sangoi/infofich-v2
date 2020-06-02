<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\CargaHoraria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * En esta clase van todas las funciones que permiten la gestion de las planificaciones via Ajax
 */
class PlanificacionAjaxController extends Controller {

    /**
     * Metodo que maneja la edicion del formulario de Objetivos.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editObjetivosAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\ObjetivosType", $planificacion);
        $form->handleRequest($request);

        $statusCode = Response::HTTP_OK;

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                //los campos objetivos esta dentro de la entidad Planificacion
                $em->persist($planificacion);
                $em->flush();


                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

                return $this->redirectToRoute('planificacion_ajax_objetivos_editar', array('id' => $planificacion->getId()));
                
            } else {
                $statusCode = Response::HTTP_BAD_REQUEST;
                $this->addFlash('error', 'Hay errores en el formulario.');
            }
        }
        return $this->render('PlanificacionesBundle:Planificacion:tab-objetivos.html.twig', array(
                    'form' => $form->createView()
                        // ...
        ));
    }

    /*
      public function getBibliografiaFormAction(Request $request) {
      /*
      $bibliografia = new Bibliografia();
      $form = $this->createForm("PlanificacionesBundle\Form\BibliografiaType", $bibliografia);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

      } */
    /*
      return $this->render('PlanificacionesBundle:Planificacion:tab-bibliografia.html.twig', array(
      //    'form' => $form->createView()
      ));

      } */

    public function getCargaHorariaFormAction(Request $request) {

        $cargaHoraria = new CargaHoraria();
        $form = $this->createForm("PlanificacionesBundle\Form\CargaHorariaType", $cargaHoraria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
        }

        return $this->render('PlanificacionesBundle:Planificacion:tab-distribucion.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
