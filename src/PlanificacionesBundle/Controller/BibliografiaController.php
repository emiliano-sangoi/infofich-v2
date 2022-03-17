<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Estado;
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

        //Deshabilitar el campo cuando la planificación este en revision o publicada
        $config = array();
        $ea = $planificacion->getEstadoActual();
        if($ea && in_array($ea->getCodigo(), [Estado::REVISION, Estado::PUBLICADA])){
            $config = array('disabled' => true);
        }
        
        $form = $this->createForm(BibliografiasType::class, $planificacion, $config);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarBibliografias($planificacion);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

            return $this->redirectToRoute('planif_bibliografia_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Bibliografía', $this->get("router")->generate('planif_bibliografia_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:6-bibliografia:edit.html.twig', array(
                    'form' => $form->createView(),
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Bibliografía',
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
