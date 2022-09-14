<?php

namespace PlanificacionesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    
    public function cargaPlanificacionAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:planificaciones:carga.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }
    
    public function indexAcademicaAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:planificacion:sa_inicio.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }
    
    public function revisarPlanificacionAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:planificacion:sa_revision.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }
    
    
}
