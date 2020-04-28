<?php

namespace PlanificacionesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
ini_set('display_errors', 1);
class PlanificacionController extends Controller {

    public function indexAction(Request $request) {
        
        return $this->render('PlanificacionesBundle:Planificacion:inicio.html.twig');        
    }

    public function newAction() {
        return $this->render('PlanificacionesBundle:Planificacion:new.html.twig', array(
                       'page_title' => 'Nueva planificación',
        ));
    }

    public function editAction(Request $request, \PlanificacionesBundle\Entity\Planificacion $planificacion) {
        
        
        
        
        
        return $this->render('PlanificacionesBundle:Planificacion:edit.html.twig', array(
                        'page_title' => 'Modificar planificación',
        ));
    }

}
