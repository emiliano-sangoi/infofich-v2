<?php

namespace PlanificacionesBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Temario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TemarioController extends Controller {
//    public function getTemarioFormAction(Request $request) {
//
//        $temario = new Temario();
//        $form = $this->createForm("PlanificacionesBundle\Form\TemarioType", $temario);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            
//        }
//
//        return $this->render('PlanificacionesBundle:Planificacion:tab-temario.html.twig', array(
//                    'form' => $form->createView()
//        ));
//    }

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\TemarioType", $planificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //dump($planificacion);exit;
            $em = $this->getDoctrine()->getManager();                       
            
            ////////////////////////////////////////////////////////////////////////////////
            // PARA QUE ANDE EL DELETE LEER:
            // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
            
            
            //Buscar los temarios de la base de datos
            $temarioOriginal = $em->getRepository('PlanificacionesBundle:Temario')
                    ->findBy(array('planificacion' => $planificacion));
            
            
            foreach ($temarioOriginal as $temario) {
                if (false === $planificacion->getTemario()->contains($temario)) {
                    // remove the Task from the Tag
                    $planificacion->getTemario()->removeElement($temario);
                    $em->remove($temario);
                }
            }
            ////////////////////////////////////////////////////////////////////////////////

            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_temario_editar', array('id' => $planificacion->getId()));
        }

        return $this->render('PlanificacionesBundle:temario:edit.html.twig', array(
                    'form' => $form->createView(),
            'page_title' => 'Temario',                    
                    'planificacion' => $planificacion
        ));
    }

}
