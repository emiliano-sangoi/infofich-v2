<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\RequisitosAprobacion;
use PlanificacionesBundle\Form\RequisitosAprobacionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AprobacionController extends Controller {

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

        $requisitosAprob = $planificacion->getRequisitosAprobacion();

        if (!$requisitosAprob) {
            $requisitosAprob = new RequisitosAprobacion();
            $requisitosAprob->setPlanificacion($planificacion);
        }

        //Deshabilitar el campo cuando la planificación este en revision o publicada
        $config = array();
        $ea = $planificacion->getEstadoActual();
        if($ea && in_array($ea->getCodigo(), [Estado::REVISION, Estado::PUBLICADA])){
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

        return $this->render('PlanificacionesBundle:3-aprobacion-asignatura:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Aprobación de la asignatura',
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'planificacion' => $planificacion
        ));
    }


    private function crearFormUtilizaEvalCont(RequisitosAprobacion $ra){

        $options = array(
            'attr' => array(
                'class' => 'd-inline'
            ),
            'data_class' => RequisitosAprobacion::class
        );

        $fb = $this->createFormBuilder(null, $options);

        return $fb->setAction($this->generateUrl('planif_temario_borrar', array('id' => $ra->getId())))
            ->setMethod('POST')
            ->getForm();

    }

}
