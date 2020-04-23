<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\RequisitosAprobacion;
use PlanificacionesBundle\Entity\ActividadCurricular;
use PlanificacionesBundle\Entity\Temario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * En esta clase van todas las funciones que permiten la gestion de las planificaciones via Ajax
 */
class PlanificacionAjaxController extends Controller {

    public function getInfoBasicaFormAction(Request $request) {

        $planificacion = new Planificacion();
        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
        }

        //sleep(25);

        return $this->render('PlanificacionesBundle:Planificacion:tab-informacion-basica.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    
    public function getFormEquipoDocenteAction() {
        return $this->render('PlanificacionesBundle:Planificacion:tab-equipo_docente.html.twig', array(
        ));
    }

    public function getRequisitosAprobFormAction(Request $request) {
        $requisitosAprob = new RequisitosAprobacion();
        $form = $this->createForm("PlanificacionesBundle\Form\RequisitosAprobacionType", $requisitosAprob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
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

    public function getTemarioFormAction(Request $request) {

        $temario = new Temario();
        $form = $this->createForm("PlanificacionesBundle\Form\TemarioType", $temario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
        }

        return $this->render('PlanificacionesBundle:Planificacion:tab-temario.html.twig', array(
                        'form' => $form->createView()
        ));
    }

    public function getBibliografiaFormAction() {
        return $this->render('PlanificacionesBundle:Planificacion:tab-bibliografia.html.twig', array(
                        // ...
        ));
    }

    public function getCronogramaFormAction(Request $request) {
        
        $actividadCurricular = new ActividadCurricular();
        $form = $this->createForm("PlanificacionesBundle\Form\ActividadCurricularType", $actividadCurricular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
        }
        return $this->render('PlanificacionesBundle:Planificacion:tab-cronograma.html.twig', array(
                    'form' => $form->createView(),
        // ...
        ));        
        
    }

    public function getCargaHorariaFormAction() {
        return $this->render('PlanificacionesBundle:Planificacion:tab-distribucion.html.twig', array(
                        // ...
        ));
    }

    public function getViajesAcademicosFormAction() {
        return $this->render('PlanificacionesBundle:Planificacion:tab-viajes_academicos.html.twig', array(
                        // ...
        ));
    }

}
