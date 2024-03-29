<?php

namespace VehiculosBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\TipoVehiculo;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Form\TipoVehiculoType;

class TipoVehiculoController extends Controller {

//    public function indexAction() {
//
//        // Breadcrumbs
//        $breadcrumbs = $this->get("white_october_breadcrumbs");
//        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
//        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
//        $breadcrumbs->addItem("Tipos", $this->get("router")->generate("tipo_vehiculos_listado"));
//
//
//        return $this->render('VehiculosBundle:TipoVehiculo:index.html.twig', array(
//                    'page_title' => 'InfoFICH - Vehículos',
//                        //s'docentes_paginado' => $docentes_paginado
//        ));
//    }

    public function listadoAction(Request $request) {
        //Chequear los permisos para acceder a este listado

        //Buscar los tipos de vehículos
        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository(TipoVehiculo::class)->createQueryBuilder('tv');
        $qb->where($qb->expr()->isNull('tv.fechaBaja'));
        $qb->addOrderBy('tv.nombre', 'ASC');
        $qb->addOrderBy('tv.habilitado', 'DESC');
        $paginator = $this->get('knp_paginator');
        $tipos = $paginator->paginate(
            $qb->getQuery(), /* query NOT result */ $request->query->getInt('page', 1), /* page number */ 10 /* limit per page */
        );

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Tipos", $this->get("router")->generate("tipo_vehiculos_listado"));

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

            try{
                $em = $this->getDoctrine()->getManager();          

                $em->persist($tipoVehiculo);
                $em->flush();

                $this->addFlash('success', 'El tipo fue creado correctamente');

                return $this->redirectToRoute('tipo_vehiculos_show', array('id' => $tipoVehiculo->getId()));

            } catch (UniqueConstraintViolationException $ex) {
                $this->addFlash('error', 'Ocurrió un error al intentar crear un nuevo Tipo de Vehículo. Nombre de Tipo de Vehículo duplicado.');
            }
            

        }
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Tipos", $this->get("router")->generate("tipo_vehiculos_listado"));
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
        $editForm = $this->createForm(TipoVehiculoType::class, $tipoVehiculo);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($tipoVehiculo);
            $em->flush();

            $this->addFlash('success', 'Tipo de vehiculo modificado correctamente.');

            return $this->redirectToRoute('tipo_vehiculos_show', array('id' => $tipoVehiculo->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Tipos de vehiculos", $this->get("router")->generate("tipo_vehiculos_listado"));
        $breadcrumbs->addItem($tipoVehiculo, $this->get("router")->generate("tipo_vehiculos_show", array('id' => $tipoVehiculo->getId())));
        //$breadcrumbs->addItem($docenteAdscripto->__toString(), $this->get("router")->generate("docentes_adscriptos_show", array('id' => $docenteAdscripto->getId())));
        $breadcrumbs->addItem('Editar');

        return $this->render('VehiculosBundle:TipoVehiculo:edit.html.twig', array(
                    'tipoVehiculo' => $tipoVehiculo,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'page_title' => 'Editar tipo Vehículo',
        ));
    }

    public function showAction(Request $request, TipoVehiculo $tipoVehiculo) {

        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($tipoVehiculo);
        $editForm = $form = $this->createForm(TipoVehiculoType::class, $tipoVehiculo, array(
            'disabled' => true
        ));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Tipo de Vehiculos", $this->get("router")->generate("tipo_vehiculos_listado"));
        $breadcrumbs->addItem($tipoVehiculo, $this->get("router")->generate("tipo_vehiculos_show", array('id' => $tipoVehiculo->getId())));
        $breadcrumbs->addItem('Ver');

        return $this->render('VehiculosBundle:TipoVehiculo:show.html.twig', array(
            'tipoVehiculo' => $tipoVehiculo,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page_title' => 'Ver tipo Vehículo',
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

            $vehiculo = $em->getRepository(Vehiculo::class)->findOneByTipo($tipoVehiculo);
            if($vehiculo){
                //baja logica
                $tipoVehiculo->setFechaBaja(new \DateTime());
                
            }else{
                $em->remove($tipoVehiculo);
            }

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

//    public function deleteTipoAction(TipoVehiculo $tipoVehiculo){
//        if (!$tipoVehiculo) {
//            throw $this->createNotFoundException('No hay un tipo de vehículo seleccionado.');
//        }
//
//        $em = $this->getDoctrine()->getEntityManager();
//        $em->remove($tipoVehiculo);
//        $em->flush();
//
//        //return $this->redirect($this->generateUrl('tipo_vehiculos_listado'));
//        $this->addFlash('success', 'Tipo de vehículo borrado correctamente.');
//            return $this->redirectToRoute('tipo_vehiculos_listado');
//    }

}
