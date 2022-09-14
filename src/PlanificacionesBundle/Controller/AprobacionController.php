<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\RequisitosAprobacion;
use PlanificacionesBundle\Form\RequisitosAprobacionType;
use PlanificacionesBundle\Form\UtilizaEvalContinuaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;

class AprobacionController extends Controller
{

    use PlanificacionTrait;

    public function editarUtilizaEvalContAction(Request $request, Planificacion $planificacion)
    {
        $requisitosAprob = $planificacion->getRequisitosAprobacion();

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $form = $this->createForm(UtilizaEvalContinuaType::class, $requisitosAprob);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($requisitosAprob->getUtilizaEvalContinua() && empty($requisitosAprob->getDescEvalContinua())){
                $form->get('descEvalContinua')->addError(new FormError(
                    'Este campo es obligatorio si utiliza evaluación continua.'
                ));
            }else{
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->addFlash('success', 'Metodología de enseñanza actualizada correctamente.');

                //Causar redireccion para evitar "re-submits" del form:
                return $this->redirectToRoute('planif_aprobacion_editar', array('id' => $planificacion->getId()));
            }

        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Aprobación de la asignatura',
            $this->get("router")->generate('planif_aprobacion_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:3-aprobacion-asignatura:edit-ec.html.twig', array(
            'form' => $form->createView(),
            'page_title' => $this->getPageTitle($planificacion) . ' - Aprobación de la asignatura',
            'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
            'planificacion' => $planificacion
        ));

    }

    /**
     * Metodo que maneja la edicion del formulario.
     *
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion)
    {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $requisitosAprob = $planificacion->getRequisitosAprobacion();

        if (!$requisitosAprob) {
            $requisitosAprob = new RequisitosAprobacion();
            $requisitosAprob->setPlanificacion($planificacion);
        }

        //Deshabilitar el campo cuando la planificación este en revision o publicada
        $config = array();
        $ea = $planificacion->getEstadoActual();
        if ($ea && in_array($ea->getCodigo(), [Estado::REVISION, Estado::PUBLICADA])) {
            $config = array('disabled' => true);
        }

        $form = $this->createForm(RequisitosAprobacionType::class, $requisitosAprob, $config);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($requisitosAprob);
            $planificacion->setRequisitosAprobacion($requisitosAprob);
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_aprobacion_editar', array('id' => $planificacion->getId()));
        }

        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Aprobación de la asignatura', $this->get("router")->generate('planif_aprobacion_editar', array('id' => $planificacion->getId())));

        $form_ec = $this->crearFormUtilizaEvalContinua($requisitosAprob, true);

        return $this->render('PlanificacionesBundle:3-aprobacion-asignatura:edit.html.twig', array(
            'form' => $form->createView(),
            'form_ec' => $form_ec->createView(),
            'page_title' => $this->getPageTitle($planificacion) . ' - Aprobación de la asignatura',
            'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
            'planificacion' => $planificacion
        ));
    }

    private function crearFormUtilizaEvalContinua(RequisitosAprobacion $ra, $disabled = false)
    {
        $options = array(
            'attr' => array(
                'class' => '',
                'id' => 'form-eval-continua'
            ),
            'data_class' => RequisitosAprobacion::class
        );

//        $ea = $ra->getPlanificacion()->getEstadoActual();
//        if ($ea && in_array($ea->getCodigo(), [Estado::REVISION, Estado::PUBLICADA])) {
            $options['disabled'] = $disabled;
//        }

        $fb = $this->createFormBuilder($ra, $options);

        $fb->add('utilizaEvalContinua', ChoiceType::class, array(
            'label' => 'Metodoloía de enseñanza',
            'required' => true,
            'choices' => array('Sí' => true, 'No' => false),
            'choices_as_values' => true,
            'expanded' => true,
            'multiple' => false,
            'attr' => array('class' => 'd-inline')
        ));

        $opt = array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'placeholder' => 'Descripción de la metodología de enseñanza utilizada',
                'class' => 'form-control',
                'rows' => 5,
            ),
        );

        $fb->add('descEvalContinua', TextareaType::class, $opt);

        return $fb->setAction($this->generateUrl('planif_aprobacion_actualizar_utiliza_ec', array('id' => $ra->getPlanificacion())))
            ->setMethod('POST')->getForm();
    }

    /**
     * Manejador del formulario que actualiza el metodo de enseñanza.
     *
     * @param RequisitosAprobacion $ra
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function actualizarUtilizaEvalContAction(RequisitosAprobacion $ra, Request $request)
    {
        $planificacion = $ra->getPlanificacion();

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $form = $this->crearFormUtilizaEvalContinua($ra);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($ra->getUtilizaEvalContinua()) {
                //Si utiliza evaluacion continua se deben vaciar ciertos campos
                $ra->setFechaSegundoParcial(null);
                $ra->setFechaRecupSegundoParcial(null);
            } else {
                $ra->setDescEvalContinua(null);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Método de enseñanza actualizado correctamente.');

            //Redireccionar a la misma pagina:
            return $this->redirectToRoute('planif_aprobacion_editar', array('id' => $ra->getPlanificacion()->getId()));
        }

        return $this->editAction($request, $planificacion);

    }

}
