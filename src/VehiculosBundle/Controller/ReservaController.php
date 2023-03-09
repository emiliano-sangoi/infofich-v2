<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\Reserva;
use VehiculosBundle\Form\ReservaType;


class ReservaController extends Controller {

   

    public function listadoAction() {

        
        //Chequear los permisos para acceder a este listado

        //Buscar los vehículos
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository(Reserva::class);
        $reservas = $repo->findBy(array(), 
                        array('fechaInicio' => 'ASC'));

        
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos / Reservas", $this->get("router")->generate("vehiculos_index"));


        return $this->render('VehiculosBundle:Reserva:listado.html.twig', array(
                    'page_title' => 'InfoFICH - Reserva Vehículos',
                    'reservas' => $reservas,                        
        ));
    }
    
     public function newAction(Request $request) {

        //TODO DESCOMENTAR Y COMPLETAR CUANDO TENGAMOS LA BD
        $reserva = new Reserva();
        $form = $this->createForm(ReservaType::class, $reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($reserva);
            $em->flush();

            $this->addFlash('success', 'Reserva creada correctamente');

            return $this->redirectToRoute('reservas_listado');

          //return $this->redirectToRoute('docentes_adscriptos_show', array('id' => $docenteAdscripto->getId()));
        } 

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos / Reservas", $this->get("router")->generate("reservas_listado"));
        $breadcrumbs->addItem("Nuevo");

        return $this->render('VehiculosBundle:Reserva:new.html.twig', array(
                    'reserva' => $reserva,
                    'form' => $form->createView(),
                    'page_title' => 'Reserva - Nueva',
        ));
    }

}
