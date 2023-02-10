<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\TipoVehiculo;
use VehiculosBundle\Form\TipoVehiculoType;

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


        $tipoVehiculo = new TipoVehiculo;
        $form = $this->createForm(TipoVehiculoType::class, $tipoVehiculo);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

            $em->persist($tipoVehiculo);
            $em->flush();

            $this->addFlash('success', 'El Tipo de Vehiculo fue creado correctamente');

            return $this->redirectToRoute('tipo_vehiculos_listado');

          //return $this->redirectToRoute('docentes_adscriptos_show', array('id' => $docenteAdscripto->getId()));
        } 
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Nuevo");
        
        return $this->render('VehiculosBundle:TipoVehiculo:new.html.twig', array(
                    'tipoVehiculo' => $tipoVehiculo,
                    'form' => $form->createView(),
                    'page_title' => 'Tipo de Vehiculos - Nuevo',
        ));


        
    }

      /**
     * Displays a form to edit an existing TipoVehiculo entity.
     *
     */
    public function editAction(Request $request, TipoVehiculo $tipoVehiculo) {

        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($tipoVehiculo);
        $editForm = $form = $this->createForm(TipoVehiculoType::class, $tipoVehiculo);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
              
            $em->persist($tipoVehiculo);
            $em->flush();

            $this->addFlash('success', 'Tipo Vehiculo modificado correctamente.');

            return $this->redirectToRoute('tipo_vehiculos_listado');
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Tipo de Vehiculos", $this->get("router")->generate("tipo_vehiculos_listado"));
        //$breadcrumbs->addItem($docenteAdscripto->__toString(), $this->get("router")->generate("docentes_adscriptos_show", array('id' => $docenteAdscripto->getId())));
        $breadcrumbs->addItem('Editar');

        return $this->render('VehiculosBundle:TipoVehiculo:edit.html.twig', array(
                    'tipoVehiculo' => $tipoVehiculo,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'page_title' => 'Editar tipo Vehículo',
        ));
    }

    /**
     * Deletes a TipoVehiculo entity.
     *
     */
    public function deleteAction(Request $request, TipoVehiculo $tipoVehiculo) {
        $form = $this->createDeleteForm($tipoVehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($tipoVehiculo);
            $em->flush();
            $this->addFlash('success', 'Tipo de vehículo borrado correctamente.');
        }

        return $this->redirectToRoute('tipo_vehiculos_listado');
    }

    /**
     * Creates a form to delete a Tipo Vehiculo entity.
     *
     * @param TipoVehiculo $tipoVehiculo The TipoVehiculo entity
     *
     * @return Form The form
     */
    private function createDeleteForm(TipoVehiculo $tipoVehiculo) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('tipo_vehiculos_delete', array('id' => $tipoVehiculo->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}