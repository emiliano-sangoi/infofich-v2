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
            'page_title' => $this->getPageTitle($planificacion) . ' - Temario',
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

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $form = $this->createForm(ViajesAcademicosType::class, $planificacion, array(
            'disabled' => $planificacion->isPublicada()
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarViajes($planificacion);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_viajes_acad_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Viajes académicos', $this->get("router")->generate('planif_viajes_acad_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:9-viajes-acad:edit.html.twig', array(
                    'form' => $form->createView(),
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Viajes académicos',
                    'planificacion' => $planificacion
        ));
    }

    /**
     * Funcion auxiliar para remover los items que fueron borrados por el formulario.
     * 
     * @param Planificacion $planificacion
     */
    private function actualizarViajes(Planificacion $planificacion) {

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
    }

}
