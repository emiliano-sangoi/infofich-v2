<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Planificaciones controller.
 *
 * @Route("planificaciones")
 */

class PlanificacionesController extends Controller
{
    
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Planificaciones:index.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }
    
    
    /**
     * @Route("/carga1", name="carga1")
     */
    public function carga1Action(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Planificaciones:carga1.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }
}
