<?php

namespace VehiculosBundle\Controller;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use VehiculosBundle\Entity\Reserva;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Form\VehiculoType;
use VehiculosBundle\Repository\VehiculoRepository;

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

            $this->addFlash('success', 'El Vehículo fue creado correctamente');

            return $this->redirectToRoute('vehiculos_listado');
        } 

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Nuevo");

        return $this->render('VehiculosBundle:Vehiculo:new.html.twig', array(
                    'vehiculo' => $vehiculo,
                    'form' => $form->createView(),
                    'page_title' => 'Vehículos - Nuevo',
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

            $this->addFlash('success', ' Vehículo modificado correctamente.');
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

            //$planificaciones = $em->getRepository(DocenteAdscripto::class)->getPlanificacionesDocente($docenteAdscripto);
            
            $reservas = $em->getRepository(Vehiculo::class)->getReservasVehiculo($vehiculo);
            
            $c = count($reservas);

            if($c>0){
                 //baja logica
                $vehiculo->setFechaBaja(new \DateTime());
                $em->flush();
                $this->addFlash('Aviso', 'El vehículo esta siendo utilizado en ' . $c . ' reserva(s). Se realizó una baja lógica');
                //return $this->redirectToRoute('vehiculos_show', array('id' => $vehiculo->getId()));
            }else{
                $em->remove($vehiculo);
                $em->flush();
                $this->addFlash('success', 'El vehículo fue dado de baja correctamente.');
            }     

          //      $this->addFlash('warning', 'El vehículo fue dado de baja correctamente (baja lógica).');
                   

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
