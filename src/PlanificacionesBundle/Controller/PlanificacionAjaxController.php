<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\CargaHoraria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * En esta clase van todas las funciones que permiten la gestion de las planificaciones via Ajax
 */
class PlanificacionAjaxController extends Controller {

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

}
