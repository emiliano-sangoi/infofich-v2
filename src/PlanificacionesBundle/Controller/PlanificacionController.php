<?php

namespace PlanificacionesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlanificacionController extends Controller {

    public function indexAction(Request $request) {
        
        return $this->render('PlanificacionesBundle:Planificacion:inicio.html.twig');        
    }

    public function newAction() {
        return $this->render('PlanificacionesBundle:Planificacion:new.html.twig', array(
                        // ...
        ));
    }

    public function editAction() {
        return $this->render('PlanificacionesBundle:Planificacion:edit.html.twig', array(
                        // ...
        ));
    }

}
