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
                return $this->redirectToRoute('planif_dist_carga_horaria_editar', array('id' => $planificacion->getId()));
            } else {
                $this->addFlash('error', 'Hay errores en el formulario.');
            }
        }
        return $this->render('PlanificacionesBundle:8-dist-carga-horaria:edit.html.twig', array(
                    'form' => $form->createView(),
                    'planificacion' => $planificacion,
                    'page_title' => 'Distribución de carga horaria'
        ));
    }

}
