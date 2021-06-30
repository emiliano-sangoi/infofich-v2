<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\BibliografiasType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BibliografiaController extends Controller {
    
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
        
        $form = $this->createForm(BibliografiasType::class, $planificacion);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarBibliografias($planificacion);
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_bibliografia_editar', array('id' => $planificacion->getId()));
        }

        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());
        
        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Bibliografía', 
                $this->get("router")->generate('planif_bibliografia_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:6-bibliografia:edit.html.twig', array(
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
    private function actualizarBibliografias(Planificacion $planificacion) {

        $em = $this->getDoctrine()->getManager();

        ////////////////////////////////////////////////////////////////////////////////
        // ESTO ES NECESARIO PARA QUE ANDE EL DELETE EN LAS COLLECCIONES
        // VER:
        // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
        //Buscar los temarios de la base de datos

        $bibliografiasPlanificacion = $em->getRepository('PlanificacionesBundle:BibliografiaPlanificacion')
                ->findBy(array('planificacion' => $planificacion));


        foreach ($bibliografiasPlanificacion as $bp) {
            if (false === $planificacion->getBibliografiasPlanificacion()->contains($bp)) {
                // remove the Task from the Tag
                $planificacion->getBibliografiasPlanificacion()->removeElement($bp);
                $em->remove($bp);
            }
        }
        
        
    }

}
