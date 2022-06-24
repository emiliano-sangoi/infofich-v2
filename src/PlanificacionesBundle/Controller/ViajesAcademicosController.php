<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\ViajesAcademicosType;
use PlanificacionesBundle\Form\ViajeAcademicoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PlanificacionesBundle\Entity\ViajeAcademico;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use PlanificacionesBundle\Entity\Estado;


class ViajesAcademicosController extends Controller {

    use PlanificacionTrait;
    
    
    
    public function indexAction(Request $request, Planificacion $planificacion)
    {
        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $repo = $this->getDoctrine()->getManager()->getRepository(ViajeAcademico::class);
        $viajes = $repo->findBy(array(
            'planificacion' => $planificacion
        ), array('fechaTentativa' => 'ASC'));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem('Viaje');

        return $this->render('PlanificacionesBundle:9-viajes-acad:index.html.twig', array(
            'page_title' => $this->getPageTitle($planificacion) . ' - Viaje Academico',
            'viajes' => $viajes,
            'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
            'planificacion' => $planificacion
        ));

    }
    
    
    public function newAction(Request $request, Planificacion $planificacion)
    {
        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        //Deshabilitar el campo cuando la planificación este en revision o publicada
        $config = array();
        $ea = $planificacion->getEstadoActual();
        if ($ea && in_array($ea->getCodigo(), array(Estado::REVISION, Estado::PUBLICADA))) {
            $this->addFlash('warning', 'No es posible agregar nuevos viajes en esta planificación');
            return $this->redirectToRoute('planif_viaje_index', array('id' => $planificacion->getId()));
        }

        $viaje = new ViajeAcademico();

        $em = $this->getDoctrine()->getManager();
        /*$nroUnidad = $em->getRepository(Temario::class)->getProximoNroUnidad($planificacion);
        $tema->setUnidad($nroUnidad);
        $tema->setTitulo('Unidad ' . $nroUnidad);*/
        $viaje->setPosicion(1);

        $form = $this->crearFormNuevoViaje($viaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $viaje->setPlanificacion($planificacion);
            $planificacion->addViajesAcademico($viaje);

            $em->persist($viaje);
            $em->flush();

            $this->addFlash('success', 'El viaje fue creado correctamente.');

            if ($form->get('btnCrear')->isClicked()) {
                return $this->redirectToRoute('planif_viaje_index', array('id' => $planificacion->getId()));
            } else {
                return $this->redirectToRoute('planif_viaje_nuevo', array('id' => $planificacion->getId()));
            }

        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem('ViajesAcademicos');
        $breadcrumbs->addItem('NUEVO');

        return $this->render('PlanificacionesBundle:9-viajes-acad:new.html.twig', array(
            'form' => $form->createView(),
            'page_title' => $this->getPageTitle($planificacion) . ' - Viajes Academicos',
            'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
            'planificacion' => $planificacion
        ));

    }

    private function crearFormNuevoViaje(ViajeAcademico $viaje)
    {

        $form = $this->createForm(ViajeAcademicoType::class, $viaje);
        $form->add('btnCrear', SubmitType::class, array(
            'label' => 'Crear',
            'attr' => array('class' => 'btn btn-success'),
        ));
        $form->add('btnCrearYContinuar', SubmitType::class, array(
            'label' => 'Crear y continuar',
            'attr' => array('class' => 'btn btn-outline-success'),
        ));

        return $form;
    }

     public function verAction(Request $request, ViajeAcademico $viaje)
    {
        $form = $this->createForm(ViajeAcademicoType::class, $viaje, array(
            'disabled' => true
        ));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($viaje->getPlanificacion());
        $current_route = $this->get("router")->generate('planif_viaje_ver', array('id' => $viaje->getPlanificacion()->getId()));
        $breadcrumbs->addItem('Viajes academicos', $current_route);
        $breadcrumbs->addItem('VER');

        $delete_form = $this->crearFormBorrado($viaje);

        return $this->render('PlanificacionesBundle:9-viajes-acad:ver.html.twig', array(
            'form' => $form->createView(),
            'delete_form' => $delete_form->createView(),
            'viaje' => $viaje,
            'planificacion' => $viaje->getPlanificacion(),
            'page_title' => $this->getPageTitle($viaje->getPlanificacion()) . ' - Viaje Academico'
        ));
    }
    
    private function crearFormBorrado(ViajeAcademico $viaje){

        $options = array(
            'attr' => array(
                'class' => 'd-inline'
            ));

        return $this->createFormBuilder(null, $options)
            ->setAction($this->generateUrl('planif_viaje_borrar', array('id' => $viaje->getId())))
            ->setMethod('DELETE')
            ->getForm();

    }
    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param ViajeAcademico $viaje
     * @return Response
     */
    public function editAction(Request $request, ViajeAcademico $viaje) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $viaje->getPlanificacion()));

        $form = $this->createForm(ViajeAcademicoType::class, $viaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'El viaje fue editado correctamente.');
            return $this->redirectToRoute('planif_viaje_index', array('id' => $viaje->getPlanificacion()->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($viaje->getPlanificacion());
        $current_route = $this->get("router")->generate('planif_viaje_editar', array('id' => $viaje->getPlanificacion()->getId()));
        //$breadcrumbs->addItem('Unidad ' . $tema->getUnidad(), $current_route);
        $breadcrumbs->addItem('EDITAR');

        return $this->render('PlanificacionesBundle:9-viajes-acad:edit.html.twig', array(
            'form' => $form->createView(),
            'viaje' => $viaje,
            'planificacion' => $viaje->getPlanificacion(),
            'page_title' => $this->getPageTitle($viaje->getPlanificacion()) . ' - Viajes académicos',
        ));
    }

    public function borrarAction(Request $request, ViajeAcademico $viaje)
    {
        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $viaje->getPlanificacion()));

        $form = $this->crearFormBorrado($viaje);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($viaje);
            $em->flush();

            $this->addFlash('success', 'El viaje fue borrado correctamente.');
        }

        return $this->redirectToRoute('planif_viaje_index', array('id' => $viaje->getPlanificacion()->getId()));
    }

    public function renderBtnBorrarAction(ViajeAcademico $viaje, $label){

        $delete_form = $this->crearFormBorrado($viaje);

        return $this->render('PlanificacionesBundle:9-viajes-acad:btn-borrar.html.twig', array(
            'delete_form' => $delete_form->createView(),
            'label' => $label
        ));

    }




    /**
     * Funcion auxiliar para remover los items que fueron borrados por el formulario.
     * 
     * @param Planificacion $planificacion
     */
    /*private function actualizarViajes(Planificacion $planificacion) {

        $em = $this->getDoctrine()->getManager();

        ////////////////////////////////////////////////////////////////////////////////
        // ESTO ES NECESARIO PARA QUE ANDE EL DELETE EN LAS COLLECCIONES
        // VER:
        // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
        //Buscar los temarios de la base de datos

        $viajesAcadOriginal = $em->getRepository('PlanificacionesBundle:ViajeAcademico')
                ->findBy(array('planificacion' => $planificacion));


        foreach ($viajesAcadOriginal as $viajeAcad) {
            if (false === $planificacion->getViajesAcademicos()->contains($viajeAcad)) {
                // remove the Task from the Tag
                $planificacion->getViajesAcademicos()->removeElement($viajeAcad);
                $em->remove($viajeAcad);
            }
        }
    }*/

}
