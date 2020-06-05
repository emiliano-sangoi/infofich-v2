<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\CargaHoraria;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CargaHorariaController extends Controller {

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {
        //var_dump($planificacion);exit;

        $cargaHoraria = $planificacion->getCargaHoraria();
        
        if (!$cargaHoraria) {
            $cargaHoraria = new CargaHoraria();
            
        }      
        
        $form = $this->createForm("PlanificacionesBundle\Form\CargaHorariaType", $cargaHoraria);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($cargaHoraria);
                $planificacion->setCargaHoraria($cargaHoraria);
                $em->flush();

                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

                //$statusCode = Response::HTTP_OK;
                //Causar redireccion para evitar "re-submits" del form:
                return $this->redirectToRoute('planificacion_ajax_distribucion_editar', array('id' => $planificacion->getId()));
            } else {
                $this->addFlash('error', 'Hay errores en el formulario.');
            }
        }
        return $this->render('PlanificacionesBundle:Planificacion:tab-distribucion.html.twig', array(
                    'form' => $form->createView(),
                    'planificacion' =>  $planificacion
        ));
    }

}
