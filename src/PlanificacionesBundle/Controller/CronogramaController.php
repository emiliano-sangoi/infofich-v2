<?php

namespace PlanificacionesBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\ActividadCurricular;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CronogramaController extends Controller {

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\ActividadesCurricularesType", $planificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //dump($planificacion);exit;
            $em = $this->getDoctrine()->getManager();                       
            
            ////////////////////////////////////////////////////////////////////////////////
            // PARA QUE ANDE EL DELETE LEER:
            // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
            
            
            //Buscar los temarios de la base de datos
            $actCurricularOriginal = $em->getRepository('PlanificacionesBundle:ActividadCurricular')
                    ->findBy(array('planificacion' => $planificacion));
            
            
            foreach ($actCurricularOriginal as $actCurricular) {
                if (false === $planificacion->getTemario()->contains($actCurricularOriginal)) {
                    // remove the Task from the Tag
                    $planificacion->getTemario()->removeElement($actCurricular);
                    $em->remove($actCurricular);
                }
            }
            ////////////////////////////////////////////////////////////////////////////////

            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_cronograma_editar', array('id' => $planificacion->getId()));
        }

        return $this->render('PlanificacionesBundle:cronograma:edit.html.twig', array(
                    'form' => $form->createView(),
                    'planificacion' => $planificacion
        ));
    }

}
