<?php

namespace VehiculosBundle\Controller;

use AppBundle\Seguridad\Permisos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VehiculosBundle\Entity\EstadoReserva;
use VehiculosBundle\Entity\HistoricoEstadosReserva;
use VehiculosBundle\Entity\Reserva;
use VehiculosBundle\Form\ReservaType;

class ReservaController extends Controller
{


    public function listadoAction(Request $request)
    {
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

    public function newAction(Request $request)
    {

        $reserva = new Reserva();
        $reserva->setUsuarioAlta($this->getUser());
        $form = $this->createForm(ReservaType::class, $reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Si 
            // la fecha de inicio es <= fecha de Fin anterior. y 
            // la fecha de inicio es >= fecha Inicio anterior.


            //SELECT * from vehiculo_reserva WHERE DATE(fecha_fin) >= '2023-09-26' AND DATE(fecha_inicio) <= '2023-09-26' 
            //SELECT r FROM VehiculosBundle\Entity\Reserva r WHERE 'DATE(r.fecha_fin)' >= :fechaInicioReserva AND 'DATE(r.fecha_inicio)' <= :fechaInicioReserva
            $em = $this->getDoctrine()->getManager();
            //Consulta si el vehiculo esta reservado para la fecha que eligio
            $fechaInicioReserva = $reserva->getFechaInicio();            
            $repository = $em->getRepository(Reserva::class);
              
            //Con qb 
            $qb = $repository->createQueryBuilder('r');
            //gte crea una expresión que verifica si el valor de r.fecha_fin es mayor o igual al valor vinculado :fechaInicioReserva.
            // lte Crear una expresión de menor o igual comparando las fechas
            // Crear una expresión para extraer solo la parte de la fecha de r.fecha_fin
            $fechaFinExpression = $qb->expr()->literal('DATE(r.fecha_fin)');
            $fechaInicioExpression = $qb->expr()->literal('DATE(r.fecha_inicio)');

            //24/08/2023 fechaFinExpression es mayor o igual fechaInicioReserva que 23/08/2023 y
            //23/08/2023 fechaInicioReserva es menor o igual fechaInicioReserva que 23/08/2023 
   
            $qb->where($qb->expr()->gte($fechaFinExpression, ':fechaInicioReserva'))
            ->andWhere($qb->expr()->lte($fechaInicioExpression, ':fechaInicioReserva'))
            ->setParameter('fechaInicioReserva', $fechaInicioReserva->format('Y-m-d'));

            $resultados = $qb->getQuery()->getResult();
            $querySQL = $qb->getDQL();
            //SELECT * FROM vehiculo_reserva r WHERE DATE(r.fecha_fin) >= '2023-07-26' AND DATE(r.fecha_inicio) <= '2023-07-26' 
            //var_dump($querySQL);exit;
            if (!empty($resultados)) {
                $this->addFlash('warning', 'El vehiculo no se encuentra disponible en esa fecha.');
                return $this->redirectToRoute('reservas_new');

            } else {
                $reserva->setFechaAlta(new \DateTime());
                $em->persist($reserva);
                $em->flush();

                //asignar estado: nueva
                //---------------------------------------------------------------------------
                /* @var $repoHistorico HistoricoEstadosRepository */
                $repoHistorico = $em->getRepository(HistoricoEstadosReserva::class);

                $usuario = $this->getUser();
                $repoHistorico->setEstadoNueva($reserva, $usuario);

                $this->addFlash('success', 'Reserva creada correctamente');

                return $this->redirectToRoute('reservas_show', ['id' => $reserva->getId()]);
            }
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

    public function showAction(Reserva $reserva, Request $request){

        $form = $this->createForm(ReservaType::class, $reserva, [
            'disabled' => true
        ]);

        $form_avalar_reserva = $this->crearFormCambioEstado($reserva, 'reservas_avalar_reserva');
        $form_rechazar_reserva = $this->crearFormCambioEstado($reserva, 'reservas_rechazar_reserva');

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Vehículos", $this->get("router")->generate("vehiculos_index"));
        $breadcrumbs->addItem("Reservas", $this->get("router")->generate("reservas_listado"));
        $breadcrumbs->addItem($reserva);
        //$breadcrumbs->addItem("CAMBIAR ESTADO");

        $deleteForm = $this->createDeleteForm($reserva);

        return $this->render('VehiculosBundle:Reserva:show.html.twig', array(
            'page_title' => 'Reserva - Ver',
            'reserva' => $reserva,
            'form' => $form->createView(),
            'form_avalar_reserva' => $form_avalar_reserva->createView(),
            'form_rechazar_reserva' => $form_rechazar_reserva->createView(),
            'delete_form' => $deleteForm->createView()
        ));

    }

    public function avalarAction(Request $request, Reserva $reserva)
    {
        //$this->denyAccessUnlessGranted(Permisos::?????, array('data' => $reserva->getPlanificacion()));

        $form = $this->crearFormCambioEstado($reserva, 'reservas_avalar_reserva');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            //Crear un registro en el historico de estados
            //---------------------------------------------------------------------------
            /* @var $repoHistorico HistoricoEstadosRepository */
            $repoHistorico = $em->getRepository(HistoricoEstadosReserva::class);

            $usuario = $this->getUser();

            $repoHistorico->asignarEstado($reserva, EstadoReserva::ACEPTADA, $usuario, 'Reserva avalada por el usuario ' . $usuario->getUsername());
            $this->addFlash('success', 'Se generó el cambio de estado correctamente.');

        }

        return $this->redirectToRoute('reservas_show', array('id' => $reserva->getId()));
    }

    private function crearFormCambioEstado(Reserva $reserva, $path)
    {
        $options = array('attr' => array('class' => 'd-inline'));
        $url = $this->generateUrl($path, array('id' => $reserva->getId()));

        return $this->createFormBuilder(null, $options)
            ->setAction($url)
            ->setMethod('POST')
            ->getForm();
    }

    public function rechazarAction(Request $request, Reserva $reserva)
    {
        //$this->denyAccessUnlessGranted(Permisos::?????, array('data' => $reserva->getPlanificacion()));

        $form = $this->crearFormCambioEstado($reserva, 'reservas_rechazar_reserva');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            //Crear un registro en el historico de estados
            //---------------------------------------------------------------------------
            /* @var $repoHistorico HistoricoEstadosRepository */
            $repoHistorico = $em->getRepository(HistoricoEstadosReserva::class);

            $usuario = $this->getUser();

            $repoHistorico->asignarEstado($reserva, EstadoReserva::RECHAZADA, $usuario, 'Reserva rechazada por el usuario ' . $usuario->getUsername());
            $this->addFlash('success', 'La reserva ha sido rechazada.');
        }

        return $this->redirectToRoute('reservas_show', array('id' => $reserva->getId()));
    }

    /**
     * Displays a form to edit an existing TipoVehiculo entity.
     *
     */
    public function editAction(Request $request, Reserva $reserva)
    {

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
    public function deleteAction(Request $request, Reserva $reserva)
    {
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
    private function createDeleteForm(Reserva $reserva)
    {

        $options = array('attr' => array('class' => 'd-inline'));
        $url = $this->generateUrl('reservas_delete', array('id' => $reserva->getId()));

        return $this->createFormBuilder(null, $options)
            ->setAction($url)
            ->setMethod('DELETE')
            ->getForm();
    }

}
