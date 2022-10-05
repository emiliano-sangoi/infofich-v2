<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\ObjetivosType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PlanificacionesBundle\Traits\PlanificacionTrait;

/**
 *
 */
class ObjetivosController extends Controller {

    use PlanificacionTrait;

    /**
     * Metodo que maneja la modificacion de los campos "objetivos generales y especificos de la planificación".
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
        if($ea && in_array($ea->getCodigo(), [Estado::REVISION, Estado::PUBLICADA])){
            $config = array('disabled' => true);
        }

        $form = $this->createForm(ObjetivosType::class, $planificacion, $config);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //los campos objetivos esta dentro de la entidad Planificacion
            $em->persist($planificacion);
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_objetivos_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Objetivos de la asignatura', $this->get("router")->generate('planif_objetivos_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:4-objetivos-asignatura:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Objetivos de la asignatura',
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'planificacion' => $planificacion
        ));
    }

}
