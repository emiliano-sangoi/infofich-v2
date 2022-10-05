<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use PlanificacionesBundle\Entity\CargaHoraria;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PlanificacionesBundle\Traits\PlanificacionTrait;

class CargaHorariaController extends Controller {

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

        $cargaHoraria = $planificacion->getCargaHoraria();

        if (!$cargaHoraria) {
            $cargaHoraria = new CargaHoraria();
        }

        $form = $this->createForm(\PlanificacionesBundle\Form\CargaHorariaType::class, $cargaHoraria, array(
            'planificacion' => $planificacion,
            'disabled' => $planificacion->isPublicada()
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($cargaHoraria);
                $planificacion->setCargaHoraria($cargaHoraria);
                $em->flush();

                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

                //$statusCode = Response::HTTP_OK;
                //Causar redireccion para evitar "re-submits" del form:
                return $this->redirectToRoute('planif_dist_carga_horaria_editar', array('id' => $planificacion->getId()));
            } else {
                $this->addFlash('error', 'Hay errores en el formulario.');
            }
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Distribución de carga horaria', $this->get("router")->generate('planif_dist_carga_horaria_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:8-dist-carga-horaria:edit.html.twig', array(
                    'form' => $form->createView(),
                    'planificacion' => $planificacion,
                    'cargaHoraria' => $cargaHoraria,
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Distribución de carga horaria',
        ));
    }

}
