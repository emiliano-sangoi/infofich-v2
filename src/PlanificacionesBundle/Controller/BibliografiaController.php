<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Form\BibliografiasType;
use PlanificacionesBundle\Entity\BibliografiaPlanificacion;
use PlanificacionesBundle\Entity\Bibliografia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BibliografiaController extends Controller {

    use PlanificacionTrait;

    public function indexAction(Request $request, Planificacion $planificacion) {
        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $repo = $this->getDoctrine()->getManager()->getRepository(BibliografiaPlanificacion::class);
        $bibliografiaPlanif = $repo->findBy(array(
            'planificacion' => $planificacion
        ));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem('Bibliografía');

        return $this->render('PlanificacionesBundle:6-bibliografia:index.html.twig', array(
                    'page_title' => $this->getPageTitle($planificacion) . ' - Bibliografía',
                    'bibliografias' => $bibliografiaPlanif,
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

        $em = $this->getDoctrine()->getManager();
        
        $form = $this->crearFormNuevaBibliografia($planificacion);
        
        //$form = $this->createForm(BibliografiasType::class, $planificacion, $config);
        $form->handleRequest($request);


        /*if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarBibliografias($planificacion);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_bibliografia_editar', array('id' => $planificacion->getId()));
        }
*/
        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Bibliografía', $this->get("router")->generate('planif_bibliografia_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:6-bibliografia:new.html.twig', array(
                    'form' => $form->createView(),
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Bibliografía',
                    'planificacion' => $planificacion
        ));

    }
    
    private function crearFormNuevaBibliografia(Planificacion $planificacion)
    {

        $form = $this->createForm(BibliografiaType::class, $planificacion);
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
    

    public function verAction(Request $request, BibliografiaPlanificacion $bibliografia)
    {
        $form = $this->createForm(BibliografiasType::class, $bibliografia, array(
            'disabled' => true
        ));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($bibliografia->getPlanificacion());
        $current_route = $this->get("router")->generate('planif_bibliografia_ver', array('id' => $tema->getPlanificacion()->getId()));
        //$breadcrumbs->addItem('Unidad ' . $tema->getUnidad(), $current_route);
        $breadcrumbs->addItem('VER');

        $delete_form = $this->crearFormBorrado($tema);

        return $this->render('PlanificacionesBundle:6-bibliografia:ver.html.twig', array(
            'form' => $form->createView(),
            'delete_form' => $delete_form->createView(),
            'bibliografia' => $bibliografia,
            'planificacion' => $tema->getPlanificacion(),
            'page_title' => $this->getPageTitle($tema->getPlanificacion()) . ' - Bibliografia'
        ));
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

        //Deshabilitar el campo cuando la planificación este en revision o publicada
        $config = array();
        $ea = $planificacion->getEstadoActual();
        if ($ea && in_array($ea->getCodigo(), [Estado::REVISION, Estado::PUBLICADA])) {
            $config = array('disabled' => true);
        }

        $form = $this->createForm(BibliografiasType::class, $planificacion, $config);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarBibliografias($planificacion);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_bibliografia_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Bibliografía', $this->get("router")->generate('planif_bibliografia_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:6-bibliografia:edit.html.twig', array(
                    'form' => $form->createView(),
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Bibliografía',
                    'planificacion' => $planificacion
        ));
    }

    /**
     * Funcion auxiliar para remover los items que fueron borrados por el formulario.
     * 
     * @param Planificacion $planificacion
     */
    private function actualizarBibliografias(Planificacion $planificacion) {

        $em = $this->getDoctrine()->getManager();

        ////////////////////////////////////////////////////////////////////////////////
        // ESTO ES NECESARIO PARA QUE ANDE EL DELETE EN LAS COLLECCIONES
        // VER:
        // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
        //Buscar los temarios de la base de datos

        $bibliografiasPlanificacion = $em->getRepository('PlanificacionesBundle:BibliografiaPlanificacion')
                ->findBy(array('planificacion' => $planificacion));


        foreach ($bibliografiasPlanificacion as $bp) {
            if (false === $planificacion->getBibliografiasPlanificacion()->contains($bp)) {
                // remove the Task from the Tag
                $planificacion->getBibliografiasPlanificacion()->removeElement($bp);
                $em->remove($bp);
            }
        }
    }

    public function renderBtnBorrarAction(BibliografiaPlanificacion $bibliografia, $label) {

        $delete_form = $this->crearFormBorrado($bibliografia);

        return $this->render('PlanificacionesBundle:6-bibliografia:btn-borrar.html.twig', array(
                    'delete_form' => $delete_form->createView(),
                    'label' => $label
        ));
    }

}
