<?php

namespace PlanificacionesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    
    public function cargaPlanificacionAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:Planificaciones:carga.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }
    
    /*
     * @Route("/carga1", name="carga1")
     */
//    public function carga1Action(Request $request)
//    {
//        // replace this example code with whatever you need
//        return $this->render('PlanificacionesBundle:Planificaciones:carga1.html.twig');
//        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
//    }

        /*
     * @Route("/carga2", name="carga2")
     */
//    public function carga2Action(Request $request)
//    {
//        // replace this example code with whatever you need
//        return $this->render('PlanificacionesBundle:Planificaciones:carga2.html.twig');
//        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
//    }

    public function indexAcademicaAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:Planificacion:sa_inicio.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }
    
    public function revisarPlanificacionAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:Planificacion:sa_revision.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }
    
    
}
