<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\RequisitosAprobacion;
use PlanificacionesBundle\Form\RequisitosAprobacionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;

class AprobacionController extends Controller
{

    use PlanificacionTrait;

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

        $form_ec = $this->crearFormUtilizaEvalContinua($planificacion->getRequisitosAprobacion());
        $form_ec->handleRequest($request);

        return $this->render('PlanificacionesBundle:3-aprobacion-asignatura:edit.html.twig', array(
            'form' => $form->createView(),
            'form_ec' => $form_ec->createView(),
            'page_title' => $this->getPageTitle($planificacion) . ' - Aprobación de la asignatura',
            'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
            'planificacion' => $planificacion
        ));
    }

    private function crearFormUtilizaEvalContinua(RequisitosAprobacion $ra)
    {
        $options = array(
            'attr' => array(
                'class' => '',
                'id' => 'form-eval-continua'
            ),
            'data_class' => RequisitosAprobacion::class
        );

        if($ra->getUtilizaEvalContinua()) {
            $options['validation_groups'] = array('eval_continua', 'default');
        }else{
            $options['validation_groups'] = array('sin_eval_continua', 'default');
        }

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

//        $fb->get('descEvalContinua')->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
//            $ra = $event->getData();
//            $form = $event->getForm();
//dump($ra, $form);exit;
//
//
//            // dump($ra);exit;
//
//        });

        return $fb->setAction($this->generateUrl('planif_aprobacion_actualizar_utiliza_ec', array('id' => $ra->getId())))
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

        $form = $this->crearFormUtilizaEvalContinua($ra);
        
        $form->handleRequest($request);
        dump($ra, $form->isValid(), (string )$form->getErrors(true));exit;
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

            $this->addFlash('success', 'Método de enseñansa actualizado correctamente.');

            //Redireccionar a la misma pagina:
            //return $this->redirectToRoute('planif_aprobacion_editar', array('id' => $ra->getPlanificacion()->getId()));
        }

        //Redireccionar a la misma pagina:
        return $this->redirectToRoute('planif_aprobacion_editar', array('id' => $ra->getPlanificacion()->getId()));
    }

    private function ajaxActualizarUtilizaEvalContinua(RequisitosAprobacion $ra, $nuevo_valor)
    {

        $nuevo_valor = (int)$nuevo_valor;

        if (!in_array($nuevo_valor, [0, 1], true)) {
            return new JsonResponse(
                array(
                    'statusCode' => Response::HTTP_BAD_REQUEST,
                    'mensaje' => 'El nuevo valor debe ser 0 o 1'
                ),
                Response::HTTP_BAD_REQUEST
            );
        }

        $ra->setUtilizaEvalContinua($nuevo_valor === 1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new JsonResponse(array(
            'statusCode' => Response::HTTP_OK,
            'mensaje' => 'Cambios realizados correctamente.'
        ), Response::HTTP_OK);

    }

}
