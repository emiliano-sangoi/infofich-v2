<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\Vehiculo;


class ReservaController extends Controller {

   

    public function listadoAction() {

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));


        return $this->render('VehiculosBundle:Reserva:listado.html.twig', array(
                    'page_title' => 'InfoFICH - Reserva Vehículos',
                        //s'docentes_paginado' => $docentes_paginado
        ));
    }

}
