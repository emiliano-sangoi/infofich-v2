<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Form\VehiculoType;


class VehiculoController extends Controller {

   

    public function listadoAction(Request $request){

        //Chequear los permisos para acceder a este listado

        //Buscar los vehículos
        $em = $this->getDoctrine()->getManager();


        $qb = $em->getRepository(Vehiculo::class)->createQueryBuilder('v');
        $qb->where($qb->expr()->isNull('v.fechaBaja'));
        $qb->addOrderBy('v.descripcion ', 'ASC');
        $qb->addOrderBy('v.habilitado', 'DESC');
        $paginator = $this->get('knp_paginator');
        $vehiculos = $paginator->paginate(
            $qb->getQuery(), /* query NOT result */ $request->query->getInt('page', 1), /* page number */ 10 /* limit per page */
        );
      
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

            $em->persist($vehiculo);
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
     * Displays a form to edit an existing Vehiculo entity.
     *
     */
    public function editAction(Request $request, Vehiculo $vehiculo) {

        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($vehiculo);
        $editForm = $this->createForm(VehiculoType::class, $vehiculo);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($vehiculo);
            $em->flush();

            $this->addFlash('success', ' Vehiculo modificado correctamente.');
            return $this->redirectToRoute('vehiculos_show', array('id' => $vehiculo->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("vehículos", $this->get("router")->generate("vehiculos_listado"));
        $breadcrumbs->addItem($vehiculo, $this->get("router")->generate("vehiculos_show", array('id' => $vehiculo->getId())));
        //$breadcrumbs->addItem($docenteAdscripto->__toString(), $this->get("router")->generate("docentes_adscriptos_show", array('id' => $docenteAdscripto->getId())));
        $breadcrumbs->addItem('Editar');

        return $this->render('VehiculosBundle:Vehiculo:edit.html.twig', array(
                    'vehiculo' => $vehiculo,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'page_title' => 'Editar Vehículo',
        ));
    }

    
     /**
     * Ver información del VEHICULO
     *
     */
    public function showAction(Request $request, Vehiculo $vehiculo) {

        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($vehiculo);
        $editForm = $form = $this->createForm(VehiculoType::class, $vehiculo, array(
            'disabled' => true
        ));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Vehiculos", $this->get("router")->generate("vehiculos_listado"));
        $breadcrumbs->addItem($vehiculo, $this->get("router")->generate("vehiculos_show", array('id' => $vehiculo->getId())));
        $breadcrumbs->addItem('Ver');

        return $this->render('VehiculosBundle:Vehiculo:show.html.twig', array(
            'vehiculo' => $vehiculo,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page_title' => 'Ver Vehículo',
        ));
    }



     /**
     * Deletes a Vehiculo entity.
     *
     */
    public function deleteAction(Request $request, Vehiculo $vehiculo) {
        $form = $this->createDeleteForm($vehiculo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $vehiculo = $em->getRepository(Vehiculo::class)->findOneByTipo($tipoVehiculo);
            if($vehiculo){
                //baja logica
                $vehiculo->setFechaBaja(new \DateTime());
            }else{
                $em->remove($vehiculo);
            }

            $em->flush();
            $this->addFlash('success', 'Vehículo borrado correctamente.');

        }
        return $this->redirectToRoute('vehiculos_listado');
    }

    /**
     * Creates a form to delete a Vehiculo entity.
     *
     * @param Vehiculo $vehiculo The Vehiculo entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Vehiculo $vehiculo) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('vehiculos_delete', array('id' => $vehiculo->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
