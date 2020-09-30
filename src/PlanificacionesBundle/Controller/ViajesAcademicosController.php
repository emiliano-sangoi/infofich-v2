<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViajesAcademicosController extends Controller {

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\ViajesAcademicosType", $planificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarViajes($planificacion);
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_viajes_acad_editar', array('id' => $planificacion->getId()));
        }

        return $this->render('PlanificacionesBundle:9-viajes-acad:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => 'Viajes Académicos',
                    'planificacion' => $planificacion
        ));
    }

    /**
     * Funcion auxiliar para remover los items que fueron borrados por el formulario.
     * 
     * @param Planificacion $planificacion
     */
    private function actualizarViajes(Planificacion $planificacion) {

        $em = $this->getDoctrine()->getManager();

        ////////////////////////////////////////////////////////////////////////////////
        // ESTO ES NECESARIO PARA QUE ANDE EL DELETE EN LAS COLLECCIONES
        // VER:
        // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
        //Buscar los temarios de la base de datos

        $viajesAcadOriginal = $em->getRepository('PlanificacionesBundle:ViajeAcademico')
                ->findBy(array('planificacion' => $planificacion));


        foreach ($viajesAcadOriginal as $viajeAcad) {
            if (false === $planificacion->getViajesAcademicos()->contains($viajeAcad)) {
                // remove the Task from the Tag
                $planificacion->getViajesAcademicos()->removeElement($viajeAcad);
                $em->remove($viajeAcad);
            }
        }
    }

}
