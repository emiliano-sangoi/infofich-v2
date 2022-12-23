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
        $breadcrumbs->addItem("Vehículos / Reservas", $this->get("router")->generate("vehiculos_index"));


        return $this->render('VehiculosBundle:Reserva:listado.html.twig', array(
                    'page_title' => 'InfoFICH - Reserva Vehículos',
                        //s'docentes_paginado' => $docentes_paginado
        ));
    }
    
     public function newAction(Request $request) {

        //TODO DESCOMENTAR Y COMPLETAR CUANDO TENGAMOS LA BD
        //$docenteAdscripto = new DocenteAdscripto();
        //$form = $this->createForm(DocenteAdscriptoType::class, $docenteAdscripto);
        //    $form->handleRequest($request);

        /*  if ($form->isSubmitted() && $form->isValid()) {

          $em = $this->getDoctrine()->getManager();

          if ($docenteAdscripto->getPersona()->getId()) {
          $persona = $em->merge($docenteAdscripto->getPersona());
          $docenteAdscripto->setPersona($persona);
          }

          $em->persist($docenteAdscripto);
          $em->flush();

          $this->addFlash('success', 'Docente adscripto creado correctamente');

          return $this->redirectToRoute('docentes_adscriptos');

          //return $this->redirectToRoute('docentes_adscriptos_show', array('id' => $docenteAdscripto->getId()));
          } */

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos / Reservas", $this->get("router")->generate("reservas_listado"));
        $breadcrumbs->addItem("Nuevo");

        return $this->render('VehiculosBundle:Reserva:new.html.twig', array(
                    //'docenteAdscripto' => $docenteAdscripto,
                   // 'form' => $form->createView(),
                    'page_title' => 'Reserva - Nueva',
        ));
    }

}
