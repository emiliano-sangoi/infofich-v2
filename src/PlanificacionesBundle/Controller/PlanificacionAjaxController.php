<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\ActividadCurricular;
use PlanificacionesBundle\Entity\CargaHoraria;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\RequisitosAprobacion;
use PlanificacionesBundle\Entity\Temario;
use PlanificacionesBundle\Entity\ViajeAcademico;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * En esta clase van todas las funciones que permiten la gestion de las planificaciones via Ajax
 */
class PlanificacionAjaxController extends Controller {
    




    public function getFormEquipoDocenteAction(Request $request, Planificacion $planificacion = null) {
        return $this->render('PlanificacionesBundle:Planificacion:tab-equipo_docente.html.twig', array(
                    'planificacion' => $planificacion
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

    public function getViajesAcademicosFormAction(Request $request) {

        $viajeAcademico = new ViajeAcademico();
        $form = $this->createForm("PlanificacionesBundle\Form\ViajeAcademicoType", $viajeAcademico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
        }

        return $this->render('PlanificacionesBundle:Planificacion:tab-viajes_academicos.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}