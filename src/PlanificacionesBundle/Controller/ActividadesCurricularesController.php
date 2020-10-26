<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ActividadesCurricularesController extends Controller {
    
    use PlanificacionTrait;

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

            $this->actualizarActividadCurricular($planificacion);
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
        }

        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());
        
        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Cronograma de actividades', 
                $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:7-cronograma:edit.html.twig', array(
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
    private function actualizarActividadCurricular(Planificacion $planificacion) {

        $em = $this->getDoctrine()->getManager();

        ////////////////////////////////////////////////////////////////////////////////
        // ESTO ES NECESARIO PARA QUE ANDE EL DELETE EN LAS COLLECCIONES
        // VER:
        // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
        // obtener los registros de la base de datos:
        $actCurricularOriginal = $em->getRepository('PlanificacionesBundle:ActividadCurricular')
                ->findBy(array('planificacion' => $planificacion));


        foreach ($actCurricularOriginal as $actCurricular) {
            if (false === $planificacion->getActividadCurricular()->contains($actCurricular)) {
                // remove the Task from the Tag
                $planificacion->getActividadCurricular()->removeElement($actCurricular);
                $em->remove($actCurricular);
            }
        }
    }

}
