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

            //dump($planificacion);exit;
            $em = $this->getDoctrine()->getManager();                       
            
            ////////////////////////////////////////////////////////////////////////////////
            // PARA QUE ANDE EL DELETE LEER:
            // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
            
            
            //Buscar los viajes academicos de la base de datos
            $viajesAcadOriginal = $em->getRepository('PlanificacionesBundle:ViajeAcademico')
                    ->findBy(array('planificacion' => $planificacion));
            
            
            foreach ($viajesAcadOriginal as $viajeAcad) {
                if (false === $planificacion->getViajesAcademicos()->contains($viajeAcad)) {
                    // remove the Task from the Tag
                    $planificacion->getViajesAcademicos()->removeElement($viajeAcad);
                    $em->remove($viajeAcad);
                }
            }
            ////////////////////////////////////////////////////////////////////////////////

            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_viajes_acad_editar', array('id' => $planificacion->getId()));
        }

        return $this->render('PlanificacionesBundle:viajes-acad:edit.html.twig', array(
                    'form' => $form->createView(),
                    'planificacion' => $planificacion
        ));
    }

}
