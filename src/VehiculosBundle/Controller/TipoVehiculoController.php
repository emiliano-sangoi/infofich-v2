<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\TipoVehiculo;


class TipoVehiculoController extends Controller {

    public function indexAction() {

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));


        return $this->render('VehiculosBundle:TipoVehiculo:index.html.twig', array(
                    'page_title' => 'InfoFICH - Vehículos',
                        //s'docentes_paginado' => $docentes_paginado
        ));
    }

    public function listadoAction() {
        //Chequear los permisos para acceder a este listado

        //Buscar los tipos de vehículos
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository(TipoVehiculo::class);
        $tipos = $repo->findBy(array(), 
                        array('nombre' => 'ASC'));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));


        return $this->render('VehiculosBundle:TipoVehiculo:listado.html.twig', array(
                    'page_title' => 'InfoFICH - Tipo de Vehículos',
                    'tiposVehiculos' => $tipos,
                        //s'docentes_paginado' => $docentes_paginado
        ));
    }

    public function newAction(Request $request) {


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
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Nuevo");

        return $this->render('VehiculosBundle:Default:new.html.twig', array(
                    //'docenteAdscripto' => $docenteAdscripto,
                   // 'form' => $form->createView(),
                    'page_title' => 'Vehiculos - Nuevo',
        ));
    }

}
