<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\Temario;
use PlanificacionesBundle\Form\BibliografiasType;
use PlanificacionesBundle\Entity\Bibliografia;
use PlanificacionesBundle\Form\BibliografiaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BibliografiaController extends Controller {

    use PlanificacionTrait;

    public function indexAction(Request $request, Planificacion $planificacion) {
        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository(Bibliografia::class)->getQb($planificacion);
        $qb->orderBy('tb.codigo', 'ASC');
        $paginator = $this->get('knp_paginator');
        $bibliografias = $paginator->paginate(
            $qb->getQuery(), /* query NOT result */ $request->query->getInt('page', 1), /* page number */ 10 /* limit per page */
        );

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem('Bibliografía');

        return $this->render('PlanificacionesBundle:6-bibliografia:index.html.twig', array(
                    'page_title' => $this->getPageTitle($planificacion) . ' - Bibliografía',
                    'bibliografias' => $bibliografias,
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'planificacion' => $planificacion
        ));
    }
    
    
    public function newAction(Request $request, Planificacion $planificacion)
    {
        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        //Deshabilitar el campo cuando la planificación este en revision o publicada
        $ea = $planificacion->getEstadoActual();
        if ($ea && in_array($ea->getCodigo(), [Estado::REVISION, Estado::PUBLICADA])) {
            $this->addFlash('warning', 'No es posible agregar nueva bibliografía en esta planificación');
            return $this->redirectToRoute('planif_bibliografia_index', array('id' => $planificacion->getId()));
        }

        $bibliografia = new Bibliografia();
        $bibliografia->setPlanificacion($planificacion);

        $form = $this->crearFormBibliografia($bibliografia);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $this->getDoctrine()->getManager();

            $pos = $em->getRepository(Bibliografia::class)->getProximaPosicion($planificacion);
            $bibliografia->setPosicion($pos);

            $em->persist($bibliografia);
            $em->flush();

            $this->addFlash('success', 'La bibliografía fue creada correctamente.');

            if ($form->get('btnCrear')->isClicked()) {
                return $this->redirectToRoute('planif_bibliografia_index', array('id' => $planificacion->getId()));
            } else {
                return $this->redirectToRoute('planif_bibliografia_nuevo', array('id' => $planificacion->getId()));
            }

        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem('Bibliografía', $this->get("router")->generate("planif_bibliografia_index", ['id' => $planificacion->getId()]));
        $breadcrumbs->addItem('Nueva');

        return $this->render('PlanificacionesBundle:6-bibliografia:new.html.twig', array(
                    'form' => $form->createView(),
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Bibliografía',
                    'planificacion' => $planificacion
        ));

    }
    
    private function crearFormBibliografia(Bibliografia $bibliografia)
    {

        $form = $this->createForm(BibliografiaType::class, $bibliografia);
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
    

    public function verAction(Request $request, Bibliografia $bibliografia)
    {
        $form = $this->createForm(BibliografiaType::class, $bibliografia, array(
            'disabled' => true
        ));

        $planificacion = $bibliografia->getPlanificacion();

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $r1= $this->get("router")->generate("planif_bibliografia_index", array('id' => $planificacion->getId()));
        $breadcrumbs->addItem('Bibliografía', $r1);
        $r2 = $this->get("router")->generate("planif_bibliografia_ver", array('id' => $bibliografia->getId()));
        $label = '#' . $bibliografia->getPosicion() . ' - ' . $bibliografia->getTipoBibliografia();
        $breadcrumbs->addItem($label, $r2);
        $breadcrumbs->addItem('Ver');

        $delete_form = $this->crearFormBorrado($bibliografia);

        return $this->render('PlanificacionesBundle:6-bibliografia:ver.html.twig', array(
            'form' => $form->createView(),
            'delete_form' => $delete_form->createView(),
            'bibliografia' => $bibliografia,
            'planificacion' => $planificacion,
            'page_title' => $this->getPageTitle($planificacion) . ' - Bibliografia'
        ));
    }

    
    
    
    /**
     * Metodo que maneja la edicion de una bibliografia
     *
     * @param Request $request
     * @param Bibliografia $bibliografia
     * @return Response
     */
    public function editAction(Request $request, Bibliografia $bibliografia)
    {
        $planificacion = $bibliografia->getPlanificacion();

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $form = $this->createForm(BibliografiaType::class, $bibliografia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'La bibliofrafía fue editada correctamente.');
            return $this->redirectToRoute('planif_bibliografia_ver', array('id' => $bibliografia->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $r1= $this->get("router")->generate("planif_bibliografia_index", array('id' => $planificacion->getId()));
        $breadcrumbs->addItem('Bibliografía', $r1);
        $r2 = $this->get("router")->generate("planif_bibliografia_ver", array('id' => $bibliografia->getId()));
        $label = '#' . $bibliografia->getPosicion() . ' - ' . $bibliografia->getTipoBibliografia();
        $breadcrumbs->addItem($label, $r2);
        $breadcrumbs->addItem('Editar');

        return $this->render('PlanificacionesBundle:6-bibliografia:edit.html.twig', array(
            'form' => $form->createView(),
            'bibliografia' => $bibliografia,
            'planificacion' => $planificacion,
            'page_title' => $this->getPageTitle($planificacion) . ' - Temario',
        ));
    }

    public function renderBtnBorrarAction(Bibliografia $bibliografia, $label) {

        $delete_form = $this->crearFormBorrado($bibliografia);

        return $this->render('PlanificacionesBundle:6-bibliografia:btn-borrar.html.twig', array(
                    'delete_form' => $delete_form->createView(),
                    'label' => $label
        ));
    }

    public function borrarAction(Request $request, Bibliografia $bibliografia)
    {
        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $bibliografia->getPlanificacion()));

        $form = $this->crearFormBorrado($bibliografia);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($bibliografia);
            $em->flush();

            $this->addFlash('success', 'Bibliografía borrada correctamente.');
        }

        return $this->redirectToRoute('planif_bibliografia_index', array('id' => $bibliografia->getPlanificacion()->getId()));
    }

    private function crearFormBorrado(Bibliografia $bibliografia){

        $options = array(
            'attr' => array(
                'class' => 'd-inline'
            ));

        return $this->createFormBuilder(null, $options)
            ->setAction($this->generateUrl('planif_bibliografia_borrar', array('id' => $bibliografia->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}
