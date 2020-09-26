<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Util\Texto;
use Doctrine\Common\Collections\ArrayCollection;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Temario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TemarioController extends Controller {

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
           
            $this->actualizarTemario($planificacion);
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_temario_editar', array('id' => $planificacion->getId()));
        }

        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());

        return $this->render('PlanificacionesBundle:5-temario:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $page_title,
                    'planificacion' => $planificacion
        ));
    }

    /**
     * Funcion auxiliar para remover los items que fueron borrados por el formulario.
     * 
     * @param Planificacion $planificacion
     */
    private function actualizarTemario(Planificacion $planificacion) {

        $em = $this->getDoctrine()->getManager();

        ////////////////////////////////////////////////////////////////////////////////
        // ESTO ES NECESARIO PARA QUE ANDE EL DELETE EN LAS COLLECCIONES
        // VER:
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
        
    }

}
