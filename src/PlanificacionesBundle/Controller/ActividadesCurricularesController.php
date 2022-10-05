<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use PlanificacionesBundle\Entity\ActividadCurricular;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\ActividadCurricularType;
use PlanificacionesBundle\Form\ActividadesCurricularesType;
use Proxies\__CG__\PlanificacionesBundle\Entity\Temario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PlanificacionesBundle\Traits\PlanificacionTrait;

class ActividadesCurricularesController extends Controller {

    use PlanificacionTrait;

    /**
     * Muestra el listado de temas
     *
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function indexAction(Request $request, Planificacion $planificacion) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $ruta_index = $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
        $breadcrumbs->addItem('Cronograma de actividades', $ruta_index);

        //Buscamos la asignatura y sus datos con el web service
        $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $cargaHorariaTotal = $asignatura->getCargaHoraria();

        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Temario::class)->getQb($planificacion);
        $qb->orderBy('t.unidad', 'ASC');
        //dump($em->getRepository(ActividadCurricular::class)->findBy(array('planificacion' => $planificacion)));exit;

        //En la variable errores, Validamos si hay errrores en la planifacacion, incluido carga horaria de la asignatura.
        return $this->render('PlanificacionesBundle:7-cronograma:index.html.twig', array(
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'cargaHorariaTotal' => $cargaHorariaTotal,
                    'planificacion' => $planificacion,
                    'temario' => $qb->getQuery()->getResult(),
        ));
    }

    /**
     * Permite dar de alta una nueva actividad.
     *
     * @param Planificacion $planificacion
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response|null
     */
    public function newAction(Planificacion $planificacion, Request $request) {

        //Buscamos la asignatura y sus datos con el web service
        $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $cargaHorariaTotal = $asignatura->getCargaHoraria() ?: 0;

        $ac = new ActividadCurricular();
        $ac->setPlanificacion($planificacion);
        $form = $this->createForm(ActividadCurricularType::class, $ac, array(
            'planificacion' => $planificacion
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $sumaCargaHoraria = $planificacion->getTotalCargaHorariaAula();

            //sumar al total la cant de hs de la actividad que se esta creando:
            $sumaCargaHoraria += $ac->getCargaHorariaAula();

            if ( $sumaCargaHoraria > $cargaHorariaTotal ) {
                //Hay que controlar que no se pase de la carg horaria total
                $msg = 'La carga horaria definida en la planificacion (' . $sumaCargaHoraria . ') Hs. es distinta a la carga horaria total definida en la asignatura (' . $cargaHorariaTotal . ' Hs.).';
                $form->get('cargaHorariaAula')->addError(new \Symfony\Component\Form\FormError($msg));
            } else {

                $em->persist($ac);
                $em->flush();
                $this->addFlash('success', 'Nueva actividad creada correctamente.');

                return $this->redirectToRoute('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
            }
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $ruta_index = $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
        $breadcrumbs->addItem('Cronograma de actividades', $ruta_index);
        $breadcrumbs->addItem('NUEVA');

        return $this->render('PlanificacionesBundle:7-cronograma:new.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'cargaHorariaTotal' => $cargaHorariaTotal,
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'planificacion' => $planificacion
        ));
    }

    /**
     * Muestra los datos de una actividad
     *
     * @param ActividadCurricular $actividadCurricular
     * @param Request $request
     * @return Response|null
     */
    public function showAction(ActividadCurricular $actividadCurricular, Request $request) {

        $planificacion = $actividadCurricular->getPlanificacion();

        $form = $this->createForm(ActividadCurricularType::class, $actividadCurricular, array(
            'planificacion' => $planificacion,
            'disabled' => true
        ));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $ruta_index = $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
        $breadcrumbs->addItem('Cronograma de actividades', $ruta_index);
        $breadcrumbs->addItem('VER');

        $deleteForm = $this->crearDeleteForm($actividadCurricular);

        //Buscamos la asignatura y sus datos con el web service
        $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $cargaHorariaTotal = $asignatura->getCargaHoraria();

        return $this->render('PlanificacionesBundle:7-cronograma:show.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'planificacion' => $planificacion,
                    'actividad' => $actividadCurricular,
                    'cargaHorariaTotal' => $cargaHorariaTotal,
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Permite editar los datos de una actividad
     *
     * @param ActividadCurricular $actividadCurricular
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response|null
     */
    public function editAction(ActividadCurricular $actividadCurricular, Request $request) {

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

        //Buscamos la asignatura y sus datos con el web service
        $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $cargaHorariaTotal = $asignatura->getCargaHoraria();

        return $this->render('PlanificacionesBundle:7-cronograma:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'planificacion' => $planificacion,
                    'actividad' => $actividadCurricular,
                    'cargaHorariaTotal' => $cargaHorariaTotal,
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Permite copiar una actividad.
     *
     * @param ActividadCurricular $actividadCurricular
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response|null
     */
    public function duplicarAction(ActividadCurricular $actividadCurricular, Request $request) {

        $planificacion = $actividadCurricular->getPlanificacion();
        $copia = clone $actividadCurricular;

        $form = $this->createForm(ActividadCurricularType::class, $copia, array(
            'planificacion' => $planificacion
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($copia);
            $em->flush();
            $this->addFlash('success', 'Copia creada correctamente.');

            return $this->redirectToRoute('planif_act_curriculares_ver', array('id' => $actividadCurricular->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $ruta_index = $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
        $breadcrumbs->addItem('Cronograma de actividades', $ruta_index);
        $breadcrumbs->addItem('DUPLICAR');

         //Buscamos la asignatura y sus datos con el web service
        $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $cargaHorariaTotal = $asignatura->getCargaHoraria();

        return $this->render('PlanificacionesBundle:7-cronograma:duplicar.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'planificacion' => $planificacion,
                    'actividad' => $copia,
                    'cargaHorariaTotal' => $cargaHorariaTotal,
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'actividadOriginal' => $actividadCurricular,
        ));
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
