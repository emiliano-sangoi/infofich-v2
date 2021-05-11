<?php

namespace PlanificacionesBundle\Controller;

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

//        $form = $this->createForm("PlanificacionesBundle\Form\ResultadosType", $planificacion);
        $form = $this->createForm(ResultadosAprendizajeType::class, $planificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //los campos resultados esta dentro de la entidad Planificacion
            $em->persist($planificacion);
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_resultados_editar', array('id' => $planificacion->getId()));
        }
        
        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());
        
        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Resultados de Aprendizajes', 
                $this->get("router")->generate('planif_resultados_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:4b-resultados-asignatura:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $page_title,
                    'planificacion' => $planificacion
        ));
    }

}
