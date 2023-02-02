<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Form\VehiculoType;


class VehiculoController extends Controller {

   

    public function listadoAction() {

        //Chequear los permisos para acceder a este listado

        //Buscar los vehículos
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository(Vehiculo::class);
        $vehiculos = $repo->findBy(array(), 
                        array('descripcion' => 'ASC'));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));

        return $this->render('VehiculosBundle:Vehiculo:listado.html.twig', array(
                    'page_title' => 'InfoFICH - Vehículos',
                    'vehiculos' => $vehiculos,
        ));
    }

    public function newAction(Request $request) {

        $vehiculo = new Vehiculo;
        $form = $this->createForm(VehiculoType::class, $vehiculo);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

            $em->persist($tipoVehiculo);
            $em->flush();

            $this->addFlash('success', 'El Vehiculo fue creado correctamente');

            return $this->redirectToRoute('vehiculos_listado');

          //return $this->redirectToRoute('docentes_adscriptos_show', array('id' => $docenteAdscripto->getId()));
        } 

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Nuevo");

        return $this->render('VehiculosBundle:Vehiculo:new.html.twig', array(
                    //'vehiculos' => $vehiculos,
                    'form' => $form->createView(),
                    'page_title' => 'Vehiculos - Nuevo',
        ));
    }
    
     /**
     * Ver información del VEHICULO
     *
     */
    public function showAction(){//(Vehiculo $vehiculo) {

        //TODO DESCOMENTAR Y COMPLETAR CUANDO TENGAMOS LA BD
       // $deleteForm = $this->createDeleteForm($docenteAdscripto);
     /*   $form = $this->createForm(DocenteAdscriptoType::class, $docenteAdscripto, array(
            'disabled' => true
        ));*/

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        //$breadcrumbs->addItem($docenteAdscripto->__toString());

        $em = $this->getDoctrine()->getManager();
        //$planificaciones = $em->getRepository(DocenteAdscripto::class)->getPlanificacionesDocente($docenteAdscripto);

        return $this->render('VehiculosBundle:Vehiculo:show.html.twig', array(
                /*    'docenteAdscripto' => $docenteAdscripto,
                    'delete_form' => $deleteForm->createView(),
                    'form' => $form->createView(),
                    'planificaciones' => $planificaciones,*/
                    'page_title' => 'Vehiculos - Ver vehículo',
        ));
    }

}
