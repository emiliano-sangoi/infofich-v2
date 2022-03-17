<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use PlanificacionesBundle\Entity\Estado;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\TemarioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TemarioController extends Controller {

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
        
        $form = $this->createForm(TemarioType::class, $planificacion, $config);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarTemario($planificacion);

            $em = $this->getDoctrine()->getManager();

            try {
                $em->flush();
                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');
                //return $this->redirectToRoute('planif_temario_editar', array('id' => $planificacion->getId()));
            } catch (ForeignKeyConstraintViolationException $ex) {
                $msg = 'Los temas definidos no pueden ser borrados porque estan siendo utilizados en la sección Cronograma de actividades.';
                $this->addFlash('error', $msg);
                //$form->addError(new \Symfony\Component\Form\FormError($msg));
            }

            return $this->redirectToRoute('planif_temario_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Temario', $this->get("router")->generate('planif_temario_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:5-temario:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Temario',
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
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
