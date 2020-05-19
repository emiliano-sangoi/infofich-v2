<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Bibliografia;
use PlanificacionesBundle\Entity\CargaHoraria;
use PlanificacionesBundle\Entity\RequisitosAprobacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * En esta clase van todas las funciones que permiten la gestion de las planificaciones via Ajax
 */
class PlanificacionAjaxController extends Controller {
    






    public function getRequisitosAprobFormAction(Request $request) {
        $requisitosAprob = new RequisitosAprobacion();
        $form = $this->createForm("PlanificacionesBundle\Form\RequisitosAprobacionType", $requisitosAprob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($requisitosAprob);
                $em->flush();

                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

                //$statusCode = Response::HTTP_OK;
                
                //Causar redireccion para evitar "re-submits" del form:
                return $this->redirectToRoute('planificaciones_ajax_aprob_asig_edit', 
                array('id' => $requisitosAprob->getId()));
            }else{
                $this->addFlash('error', 'Hay errores en el formulario.');
            }
        }
        return $this->render('PlanificacionesBundle:Planificacion:tab-aprobacion-asignatura.html.twig', array(
                    'form' => $form->createView(),
                        // ...
        ));
    }

    public function getObjetivosFormAction() {
        return $this->render('PlanificacionesBundle:Planificacion:tab-objetivos.html.twig', array(
                        // ...
        ));
    }



    public function getBibliografiaFormAction(Request $request) {
        
        $bibliografia = new Bibliografia();
        $form = $this->createForm("PlanificacionesBundle\Form\BibliografiaType", $bibliografia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
        }

        return $this->render('PlanificacionesBundle:Planificacion:tab-bibliografia.html.twig', array(
                    'form' => $form->createView()
        ));
        
    }

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
