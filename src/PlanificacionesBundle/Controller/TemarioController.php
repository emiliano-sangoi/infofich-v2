<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use PlanificacionesBundle\Entity\Estado;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Temario;
use PlanificacionesBundle\Form\TemarioType;
use PlanificacionesBundle\Form\TemaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TemarioController extends Controller
{

    use PlanificacionTrait;

    public function indexAction(Request $request, Planificacion $planificacion)
    {
        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Temario', $this->get("router")->generate('planif_temario_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:5-temario:index.html.twig', array(
            'page_title' => $this->getPageTitle($planificacion) . ' - Temario',
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
            $this->addFlash('warning', 'No es posible agregar nuevos temas en esta planificación');
            return $this->redirectToRoute('planif_temario_index', array('id' => $planificacion->getId()));
        }

        $tema = new Temario();

        $em = $this->getDoctrine()->getManager();
        $nroUnidad = $em->getRepository(Temario::class)->getProximoNroUnidad($planificacion);
        $tema->setUnidad($nroUnidad);
        $tema->setTitulo('Unidad ' . $nroUnidad);
        $tema->setPosicion($nroUnidad);

        $form = $this->crearFormNuevoTema($tema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tema->setPlanificacion($planificacion);
            $planificacion->addTemario($tema);

            $em->persist($tema);
            $em->flush();

            $this->addFlash('success', 'El tema con título: \'' . $tema->getTitulo() . '\' fúe creado correctamente.');

            if ($form->get('btnCrear')->isClicked()) {
                return $this->redirectToRoute('planif_temario_index', array('id' => $planificacion->getId()));
            } else {
                return $this->redirectToRoute('planif_temario_nuevo', array('id' => $planificacion->getId()));
            }

        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Temario', $this->get("router")->generate('planif_temario_nuevo', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:5-temario:new.html.twig', array(
            'form' => $form->createView(),
            'page_title' => $this->getPageTitle($planificacion) . ' - Temario',
            'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
            'planificacion' => $planificacion
        ));

    }

    private function crearFormNuevoTema(Temario $tema)
    {

        $form = $this->createForm(TemaType::class, $tema);
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

    public function editAction(Request $request, Temario $tema)
    {
        $form = $this->createForm(TemaType::class, $tema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'El tema con título: \'' . $tema->getTitulo() . '\' fúe editado correctamente.');
            return $this->redirectToRoute('planif_temario_index', array('id' => $tema->getPlanificacion()->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($tema->getPlanificacion(), 'Temario', $this->get("router")->generate('planif_temario_nuevo', array('id' => $tema->getPlanificacion()->getId())));

        return $this->render('PlanificacionesBundle:5-temario:edit.html.twig', array(
            'form' => $form->createView(),
            'tema' => $tema,
            'planificacion' => $tema->getPlanificacion(),
            'page_title' => $this->getPageTitle($tema->getPlanificacion()) . ' - Temario',
            'errores' => $this->get('planificaciones_service')->getErrores($tema->getPlanificacion()),
        ));
    }

    /**
     * Metodo que maneja la edicion del formulario.
     *
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     * @deprecated
     */
    public function editOldAction(Request $request, Planificacion $planificacion)
    {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        //Deshabilitar el campo cuando la planificación este en revision o publicada
        $config = array();
        $ea = $planificacion->getEstadoActual();
        if ($ea && in_array($ea->getCodigo(), array(Estado::REVISION, Estado::PUBLICADA))) {
            $config = array('disabled' => true);
        }

        $form = $this->createForm(TemarioType::class, $planificacion, $config);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarTemario($planificacion);

            $em = $this->getDoctrine()->getManager();

            try {
                $em->flush();
                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');
                //return $this->redirectToRoute('planif_temario_editar', array('id' => $planificacion->getId()));
            } catch (ForeignKeyConstraintViolationException $ex) {
                $msg = 'Los temas definidos no pueden ser borrados porque estan siendo utilizados en la sección Cronograma de actividades.';
                $this->addFlash('error', $msg);
                //$form->addError(new \Symfony\Component\Form\FormError($msg));
            }

            return $this->redirectToRoute('planif_temario_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Temario', $this->get("router")->generate('planif_temario_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:5-temario:edit.html.twig', array(
            'form' => $form->createView(),
            'page_title' => $this->getPageTitle($planificacion) . ' - Temario',
            'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
            'planificacion' => $planificacion
        ));
    }

    /**
     * Funcion auxiliar para remover los items que fueron borrados por el formulario.
     *
     * @param Planificacion $planificacion
     */
    private function actualizarTemario(Planificacion $planificacion)
    {

        $em = $this->getDoctrine()->getManager();

        ////////////////////////////////////////////////////////////////////////////////
        // ESTO ES NECESARIO PARA QUE ANDE EL DELETE EN LAS COLLECCIONES
        // VER:
        // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
        //Buscar los temarios de la base de datos
        $temarioOriginal = $em->getRepository('PlanificacionesBundle:Temario')
            ->findBy(array('planificacion' => $planificacion));

        foreach ($temarioOriginal as $temario) {
            if (false === $planificacion->getTemario()->contains($temario)) {
                // remove the Task from the Tag
                $planificacion->getTemario()->removeElement($temario);
                $em->remove($temario);
            }
        }
    }

}
