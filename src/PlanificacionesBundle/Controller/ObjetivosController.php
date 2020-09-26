<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 
 */
class ObjetivosController extends Controller {

    /**
     * Metodo que maneja la modificacion de los campos "objetivos generales y especificos de la planificación".
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\ObjetivosType", $planificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //los campos objetivos esta dentro de la entidad Planificacion
            $em->persist($planificacion);
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_objetivos_editar', array('id' => $planificacion->getId()));
        }
        
        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());

        return $this->render('PlanificacionesBundle:4-objetivos-asignatura:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $page_title,
                    'planificacion' => $planificacion
        ));
    }

}
