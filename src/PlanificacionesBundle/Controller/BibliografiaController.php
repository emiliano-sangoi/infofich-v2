<?php

namespace PlanificacionesBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Bibliografia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BibliografiaController extends Controller {

    /**
     * Metodo que maneja la edicion del formulario.
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return Response
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\BibliografiasType", $planificacion);
        $form->handleRequest($request);
//var_dump($form); 
//exit; 
        
        if ($form->isSubmitted() && $form->isValid()) {

            //dump($planificacion);exit;
            $em = $this->getDoctrine()->getManager();                       
            
            ////////////////////////////////////////////////////////////////////////////////
            // PARA QUE ANDE EL DELETE LEER:
            // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
            
            
            //Buscar las bibliografias de la base de datos
            $BibliografiaOriginal = $em->getRepository('PlanificacionesBundle:Bibliografia')
                    ->findBy(array('planificacion' => $planificacion));
            
            
            foreach ($BibliografiaOriginal as $bibliografia) {
                if (false === $planificacion->getBibliografiasPlanificacion()->contains($bibliografia)) {
                    // remove the Task from the Tag
                    $planificacion->getBibliografiasPlanificacion->removeElement($bibliografia);
                    $em->remove($bibliografia);
                }
            }
            ////////////////////////////////////////////////////////////////////////////////

            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planificacion_ajax_bibliografia_editar', array('id' => $planificacion->getId()));
        }

        return $this->render('PlanificacionesBundle:Planificacion:tab-bibliografia.html.twig', array(
                    'form' => $form->createView(),
                    'planificacion' => $planificacion
        ));
    }

}
