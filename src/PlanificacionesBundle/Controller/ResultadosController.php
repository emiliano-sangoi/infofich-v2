<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\ResultadosAprendizajeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 
 */
class ResultadosController extends Controller {

    use PlanificacionTrait;

    /**
     * Metodo que maneja la modificacion de los campos "resultados de aprendizajes de la planificación".
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $form = $this->createForm(ResultadosAprendizajeType::class, $planificacion, array(
            'disabled' => $planificacion->isPublicada()
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //los campos resultados esta dentro de la entidad Planificacion
            $em->persist($planificacion);
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_resultados_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Resultados de Aprendizajes', $this->get("router")->generate('planif_resultados_editar', array('id' => $planificacion->getId())));

        //return $this->render('PlanificacionesBundle:11-resultados-asignatura:edit.html.twig', array(
        return $this->render('PlanificacionesBundle:4b-resultados-asignatura:edit.html.twig', array(
                    'form' => $form->createView(),
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Resultados de aprendizajes',
                    'planificacion' => $planificacion
        ));
    }

}
