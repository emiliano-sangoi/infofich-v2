<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DocentesController extends Controller {

    /**
     * 
     * @param Planificacion $planificacion
     * @return Symfony\Component\Form\Form
     */
    private function crearForm(Planificacion $planificacion) {

        $action = $this->generateUrl('planificacion_ajax_equipo_docente_edit', array('id' => $planificacion->getId()));

        $form = $this->createForm("PlanificacionesBundle\Form\DocentesType", $planificacion, array(
            'method' => 'POST',
            'action' => $action
        ));

        return $form;
    }

    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->crearForm($planificacion);
        
       // dump($planificacion);exit;

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
            }
        }

        return $this->render('PlanificacionesBundle:Planificacion:tab-equipo_docente.html.twig', array(
                    'planificacion' => $planificacion,
                    'form' => $form->createView()
        ));
    }
    
    /**
     * 
     * @param Request $request
     * @param type $pos
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws type
     */
    public function getDocenteAction(Request $request, $pos) {
        
        $q = new \FICH\APIInfofich\Query\Docentes\QueryDocentes();        
        $docentes = $q->setCacheEnabled(true)
                ->getDocentes();
        
        if(!isset($docentes[$pos])){
            throw $this->createNotFoundException('No se encontro el docente especificado');
        }
        
        return new \Symfony\Component\HttpFoundation\JsonResponse($docentes[$pos]);
        
    }

}
