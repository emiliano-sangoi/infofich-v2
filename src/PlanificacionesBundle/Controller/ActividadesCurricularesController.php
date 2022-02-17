<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use PlanificacionesBundle\Entity\ActividadCurricular;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\ActividadCurricularType;
use PlanificacionesBundle\Form\ActividadesCurricularesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActividadesCurricularesController extends Controller {

    use PlanificacionTrait;

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $form = $this->createForm(ActividadesCurricularesType::class, $planificacion, array(
            'disabled' => $planificacion->isPublicada()
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarActividadCurricular($planificacion);

            $em = $this->getDoctrine()->getManager();
            /*
              $em->flush();

              $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

              return $this->redirectToRoute('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
             */

            try {
                $em->flush();
                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');
                //return $this->redirectToRoute('planif_temario_editar', array('id' => $planificacion->getId()));
            } catch (ForeignKeyConstraintViolationException $ex) {
                $msg = 'Las actividades curriculares definidos no pueden ser borrados porque estan siendo utilizados en otra sección.';
                $this->addFlash('error', $msg);
                //$form->addError(new \Symfony\Component\Form\FormError($msg));
            }
            return $this->redirectToRoute('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Cronograma de actividades', $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:7-cronograma:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'planificacion' => $planificacion
        ));
    }

    /**
     * Funcion auxiliar para remover los items que fueron borrados por el formulario.
     * 
     * @param Planificacion $planificacion
     */
    private function actualizarActividadCurricular(Planificacion $planificacion) {

        $em = $this->getDoctrine()->getManager();

        ////////////////////////////////////////////////////////////////////////////////
        // ESTO ES NECESARIO PARA QUE ANDE EL DELETE EN LAS COLLECCIONES
        // VER:
        // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
        // obtener los registros de la base de datos:
        $actCurricularOriginal = $em->getRepository('PlanificacionesBundle:ActividadCurricular')
                ->findBy(array('planificacion' => $planificacion));

        foreach ($actCurricularOriginal as $actCurricular) {
            if (false === $planificacion->getActividadCurricular()->contains($actCurricular)) {
                // remove the Task from the Tag
                $planificacion->getActividadCurricular()->removeElement($actCurricular);
                $em->remove($actCurricular);
            }
        }
    }

    public function newAction(Planificacion $planificacion, Request $request) {

        $ac = new ActividadCurricular();
        $ac->setPlanificacion($planificacion);
        $form = $this->createForm(ActividadCurricularType::class, $ac, array(
            'planificacion' => $planificacion
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($ac);
            $em->flush();
            $this->addFlash('success', 'Nueva actividad creada correctamente.');

            return $this->redirectToRoute('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Cronograma de actividades', $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:7-cronograma:new.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'planificacion' => $planificacion
        ));
    }

    public function showAction(ActividadCurricular $actividadCurricular, Request $request) {

        $planificacion = $actividadCurricular->getPlanificacion();

        $form = $this->createForm(ActividadCurricularType::class, $actividadCurricular, array(
            'planificacion' => $planificacion,
            'disabled' => true
        ));

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Cronograma de actividades', $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId())));

        $deleteForm = $this->crearDeleteForm($actividadCurricular);

        return $this->render('PlanificacionesBundle:7-cronograma:show.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'planificacion' => $planificacion,
                    'actividad' => $actividadCurricular,
                    'delete_form' => $deleteForm->createView()
        ));
    }

    public function editActividadAction(ActividadCurricular $actividadCurricular, Request $request) {

        $planificacion = $actividadCurricular->getPlanificacion();

        $form = $this->createForm(ActividadCurricularType::class, $actividadCurricular, array(
            'planificacion' => $planificacion
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Actividad modificada correctamente.');

            return $this->redirectToRoute('planif_act_curriculares_editar_act', array('id' => $actividadCurricular->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Cronograma de actividades', $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId())));

        $deleteForm = $this->crearDeleteForm($actividadCurricular);

        return $this->render('PlanificacionesBundle:7-cronograma:edit-act.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'planificacion' => $planificacion,
                    'actividad' => $actividadCurricular,
                    'delete_form' => $deleteForm->createView()
        ));
    }

    public function duplicarAction(ActividadCurricular $actividadCurricular, Request $request) {

        $copia = clone $actividadCurricular;

        $em = $this->getDoctrine()->getManager();
        $em->persist($copia);
        $em->flush();
        $this->addFlash('success', 'Copia creada correctamente. A continuación se muestran las copia realizada para modificar los campos que desee.');

        return $this->redirectToRoute('planif_act_curriculares_editar_act', array('id' => $copia->getId()));
    }

    public function borrarAction(Request $request, ActividadCurricular $ac) {
        $form = $this->crearDeleteForm($ac);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($ac);
            $em->flush();

            $this->addFlash('success', 'La actividad fue borrada correctamente.');
        }

        return $this->redirectToRoute('planif_act_curriculares_editar', array('id' => $ac->getPlanificacion()->getId()));
    }

    /**
     * Crea un formulario para borrar una actividad curricular.
     * 
     * @param ActividadCurricular $actividadCurricular
     * 
     * @return Form The form
     */
    private function crearDeleteForm(ActividadCurricular $actividadCurricular) {

        $options = array(
            'attr' => array(
                'class' => 'd-inline'
        ));

        return $this->createFormBuilder(null, $options)
                        ->setAction($this->generateUrl('planif_act_curriculares_borrar', array('id' => $actividadCurricular->getId())))
                        ->setMethod('DELETE')
                        ->getForm();
    }

}
