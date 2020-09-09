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

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($requisitosAprob);
            $planificacion->setRequisitosAprobacion($requisitosAprob);
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            //$statusCode = Response::HTTP_OK;
            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_aprobacion_edit', array('id' => $planificacion->getId()));
        }

        return $this->render('PlanificacionesBundle:aprobacion-asignatura:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => 'Requisitos de aprobación de la asignatura',
                    'planificacion' => $planificacion
        ));
    }

}
