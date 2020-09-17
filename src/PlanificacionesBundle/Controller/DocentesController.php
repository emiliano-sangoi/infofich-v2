<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Util\Texto;
use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DocentesController extends Controller {

    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\DocentesType", $planificacion, array(
                //'planificacion' => $planificacion,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Cambios guardados correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $planificacion->getId()));
        }

        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());

        return $this->render('PlanificacionesBundle:2-equipo-docente:edit.html.twig', array(
                    'planificacion' => $planificacion,
                    'page_title' => $page_title,
                    'form' => $form->createView(),
                    'subtitulo' => 'Modificar equipo docente',
        ));
    }

    /*
     * 
     * @param Planificacion $planificacion
     * @return Symfony\Component\Form\Form
     */
//    private function crearForm(Planificacion $planificacion) {
//
//        $action = $this->generateUrl('planificacion_ajax_equipo_docente_edit', array('id' => $planificacion->getId()));
//
//        $form = $this->createForm("PlanificacionesBundle\Form\DocentesType", $planificacion, array(
//            'method' => 'POST',
//            'action' => $action
//        ));
//
//        return $form;
//    }
//    public function editAction(Request $request, Planificacion $planificacion) {
//
//        $form = $this->crearForm($planificacion);
//        
//       // dump($planificacion);exit;
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted()) {
//            if ($form->isValid()) {
//                $em = $this->getDoctrine()->getManager();
//                $em->flush();
//            }
//        }
//
//        return $this->render('PlanificacionesBundle:Planificacion:tab-equipo_docente.html.twig', array(
//                    'planificacion' => $planificacion,
//                    'form' => $form->createView()
//        ));
//    }

    /**
     * 
     * @param Request $request
     * @param type $pos
     * @return JsonResponse
     * @throws type
     */
    public function getDocenteAction(Request $request, $pos) {

        $q = new QueryDocentes();
        $docentes = $q->setCacheEnabled(true)
                ->getDocentes();

        if (!isset($docentes[$pos])) {
            throw $this->createNotFoundException('No se encontro el docente especificado');
        }

        return new JsonResponse($docentes[$pos]);
    }

}
