<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\RequisitosAprobacion;
use PlanificacionesBundle\Entity\ActividadCurricular;
use PlanificacionesBundle\Entity\Temario;
use PlanificacionesBundle\Entity\CargaHoraria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * En esta clase van todas las funciones que permiten la gestion de las planificaciones via Ajax
 */
class PlanificacionAjaxController extends Controller {

    /**
     * Primer pantalla de la planificacion
     * 
     * Muestra la informacion basica de una planificacion:
     *      - Carrera
     *      - Asignatura
     *      - Año academico
     *      - Departamento
     *      - Contenidos minimos
     * 
     * En el caso de que id de planificacion sea null va a crear una planificacion vacia.
     * 
     * @param Request $request
     * @param int|null $id_planificacion
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getInfoBasicaFormAction(Request $request, $id_planificacion = null) {

        $em = $this->getDoctrine()->getManager();
        if ($id_planificacion) {
            $planificacion = $em->getRepository('PlanificacionesBundle:Planificacion')->findOneBy($id_planificacion);
            if (!$planificacion) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("No se encontro ninguna planificacion con id $id_planificacion.");
            }
        } else {
            $planificacion = new Planificacion();
        }


        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($planificacion);
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planificacion_ajax_get_info_basica_form', array('id' => $planificacion->getId()));
        }

        return $this->render('PlanificacionesBundle:Planificacion:tab-informacion-basica.html.twig', array(
                    'form' => $form->createView(),
                    'planificacion' => $planificacion
        ));
    }

    
    
    
    
    public function getFormEquipoDocenteAction(Request $request, Planificacion $planificacion) {
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

    public function getViajesAcademicosFormAction() {
        return $this->render('PlanificacionesBundle:Planificacion:tab-viajes_academicos.html.twig', array(
                        // ...
        ));
    }

}
