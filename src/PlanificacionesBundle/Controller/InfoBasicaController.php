<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InfoBasicaController extends Controller {

    public function editAction(Request $request, Planificacion $planificacion) {

        $api_infofich_service = $this->get('api_infofich_service');

        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion, array(
            'api_infofich_service' => $api_infofich_service,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            //nombre de la asignatura:      
            $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());                        
            $nombreAsignatura = Texto::ucWordsCustom($asignatura->getNombreMateria());
            $planificacion->setNombreAsignatura($nombreAsignatura);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Cambios guardados correctamente.');

            //Redireccionar para evitar posibles "re-submits" del form:
            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $planificacion->getId()));
        }

        //titulo principal:
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());
        
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion, $this->get("router")->generate("planif_info_basica_editar", array('id' => $planificacion->getId())));
        $breadcrumbs->addItem("EDITAR");

        return $this->render('PlanificacionesBundle:1-info-basica:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $page_title,                    
                    'planificacion' => $planificacion,
                    'info_basica_route' => $this->generateUrl('planif_info_basica_editar', array('id' => $planificacion->getId())),
        ));
    }

}
