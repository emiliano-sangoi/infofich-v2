<?php

namespace VehiculosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\EstadoReserva;
use VehiculosBundle\Entity\HistoricoEstadosReserva;
use VehiculosBundle\Repository\HistoricoEstadosReservaRepository;
use VehiculosBundle\Entity\Reserva;;
use VehiculosBundle\Form\ReservaType;
use VehiculosBundle\Form\CambiarEstadoReservaType;



class ReservaController extends Controller {



    public function listadoAction(Request $request) {


        //Chequear los permisos para acceder a este listado

        //Buscar los vehículos
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository(Reserva::class);
        $qb = $repo->createQueryBuilder('r');
        $qb->where($qb->expr()->isNull('r.fechaBaja'));
        $qb->addOrderBy('r.fechaInicio', 'DESC');
        $paginator = $this->get('knp_paginator');
        $reservas = $paginator->paginate(
            $qb->getQuery(), /* query NOT result */ $request->query->getInt('page', 1), /* page number */ 10 /* limit per page */
        );

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Reservas", $this->get("router")->generate("reservas_listado"));


        return $this->render('VehiculosBundle:Reserva:listado.html.twig', array(
                    'page_title' => 'InfoFICH - Reserva Vehículos',
                    'reservas' => $reservas,
        ));
    }

     public function newAction(Request $request) {

        //TODO DESCOMENTAR Y COMPLETAR CUANDO TENGAMOS LA BD
        $reserva = new Reserva();
        $reserva->setUsuarioAlta($this->getUser());
        $form = $this->createForm(ReservaType::class, $reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $reserva->setFechaAlta(new \DateTime());
            $em->persist($reserva);
            $em->flush();

            //asignar estado: nueva
            //---------------------------------------------------------------------------
            /* @var $repoHistorico HistoricoEstadosRepository */
            $repoHistorico = $em->getRepository(HistoricoEstadosReserva::class);            

            $usuario = $this->getUser();
            //$repoHistorico->setEstadoCreada($reserva, $usuario);
            $repoHistorico->setEstadoNueva($reserva, $usuario);

            $this->addFlash('success', 'Reserva creada correctamente');

            return $this->redirectToRoute('reservas_listado');

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

    public function showAction(Reserva $reserva, Request $request) {
        
        //$this->denyAccessUnlessGranted(Permisos::PLANIF_PUBLICAR, array('data' => $planificacion));

        //dump($planificacion);exit;
        $form = $this->createForm(CambiarEstadoReservaType::class, null, array(
            'reserva_original' => $reserva
        ));
        
        $form->handleRequest($request);
        //var_dump($form->isSubmitted());exit;
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            //Crear un registro en el historico de estados
            //---------------------------------------------------------------------------
            /* @var $repoHistorico HistoricoEstadosRepository */
            $repoHistorico = $em->getRepository(HistoricoEstadosReserva::class);

            $usuario = $this->getUser();
            //$repoHistorico->setEstadoCreada($reserva, $usuario); ya esta creada en este caso.
            $repoHistorico->asignarEstado($reserva, EstadoReserva::ACEPTADA, $usuario, 'Cambio de estado por SI ' . $usuario->getUsername());
            //---------------------------------------------------------------------------
            $this->addFlash('success', 'Se generó el cambio de estado correctamente.');

            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $reserva->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Reservas", $this->get("router")->generate("reservas_listado"));
        $breadcrumbs->addItem($reserva);
        //$breadcrumbs->addItem("CAMBIAR ESTADO");

        return $this->render('VehiculosBundle:Reserva:show.html.twig', array(
                    'page_title' => 'Reserva - Ver',
                    'reserva' => $reserva,
                    'form' => $form->createView(),
                    // 'paginado' => $paginado,
                  //  'puede_borrar' => $this->isGranted(Permisos::PLANIF_PUBLICAR, array('data' => $reserva))
        ));
        
        
        
        //dump($reserva);exit;
       /* $form = $this->createForm(ReservaType::class, $reserva, [
            'disabled' => true
        ]);

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Reservas", $this->get("router")->generate("reservas_listado"));
        $breadcrumbs->addItem($reserva, $this->get("router")->generate("reservas_show", array('id' => $reserva->getId())));
        $breadcrumbs->addItem('Ver');

        $deleteForm = $this->createDeleteForm($reserva);
        
        return $this->render('VehiculosBundle:Reserva:show.html.twig', array(
            'reserva' => $reserva,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
            'page_title' => 'Reserva - Ver',
        ));*/
    }

    /**
     * Displays a form to edit an existing TipoVehiculo entity.
     *
     */
    public function editAction(Request $request, Reserva $reserva) {

        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(ReservaType::class, $reserva);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($reserva);
            $em->flush();

            $this->addFlash('success', 'Datos de la reserva modificados correctamente.');

            return $this->redirectToRoute('reservas_show', array('id' => $reserva->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Reservas", $this->get("router")->generate("reservas_listado"));
        $breadcrumbs->addItem($reserva, $this->get("router")->generate("reservas_show", array('id' => $reserva->getId())));
        $breadcrumbs->addItem('Editar');

        $deleteForm = $this->createDeleteForm($reserva);

        return $this->render('VehiculosBundle:Reserva:edit.html.twig', array(
            'reserva' => $reserva,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'page_title' => 'Editar reserva',
        ));
    }

    /**
     * Deletes a TipoVehiculo entity.
     *
     */
    public function deleteAction(Request $request, Reserva $reserva) {
        $form = $this->createDeleteForm($reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reserva->setFechaBaja(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Reserva dada de baja correctamente.');
        }
        return $this->redirectToRoute('reservas_listado');
    }

    /**
     * Creates a form to delete a Tipo Vehiculo entity.
     *
     * @param Reserva $reserva The Reserva entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Reserva $reserva) {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservas_delete', array('id' => $reserva->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
