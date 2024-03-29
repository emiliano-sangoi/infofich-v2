<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\Vehiculo;


class DefaultController extends Controller {

    public function indexAction() {

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));

        return $this->render('VehiculosBundle:Default:index.html.twig', array(
                    'page_title' => 'InfoFICH - Vehículos',
                        //s'docentes_paginado' => $docentes_paginado
        ));
    }
}
