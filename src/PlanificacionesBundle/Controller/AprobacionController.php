<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\RequisitosAprobacion;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AprobacionController extends Controller {

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {
        //var_dump($planificacion);exit;

        $requisitosAprob = $planificacion->getRequisitosAprobacion();
        
        if (!$requisitosAprob) {
            $requisitosAprob = new RequisitosAprobacion();
            
        }      
        
        $form = $this->createForm("PlanificacionesBundle\Form\RequisitosAprobacionType", $requisitosAprob);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($requisitosAprob);
                $planificacion->setRequisitosAprobacion($requisitosAprob);
                $em->flush();

                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

                //$statusCode = Response::HTTP_OK;
                //Causar redireccion para evitar "re-submits" del form:
                return $this->redirectToRoute('planificacion_ajax_aprobacion_editar', array('id' => $planificacion->getId()));
            } else {
                $this->addFlash('error', 'Hay errores en el formulario.');
            }
        }
        return $this->render('PlanificacionesBundle:Planificacion:tab-aprobacion-asignatura.html.twig', array(
                    'form' => $form->createView(),
                    'planificacion' =>  $planificacion
        ));
    }

}
