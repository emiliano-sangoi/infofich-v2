<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\ResultadosAprendizajes;
use PlanificacionesBundle\Form\ResultadosAprendizajeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PlanificacionesBundle\Traits\PlanificacionTrait;

class ResultadosAprendizajeController extends Controller {

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

        //dump($planificacion->getResultados()->toArray());exit;

        $form = $this->createForm(ResultadosAprendizajeType::class, $planificacion, $config);
        //dump($planificacion, $request);exit;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarResultados($planificacion);

            $em = $this->getDoctrine()->getManager();


            try {
                $em->flush();
                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');
                //return $this->redirectToRoute('planif_temario_editar', array('id' => $planificacion->getId()));
            } catch (ForeignKeyConstraintViolationException $ex) {
                $msg = 'Los resultados definidos no pueden ser borrados porque estan siendo utilizados en otra sección.';
                $this->addFlash('error', $msg);
                //$form->addError(new \Symfony\Component\Form\FormError($msg));
            }

            return $this->redirectToRoute('planif_resultados_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Resultados de Aprendizaje', $this->get("router")->generate('planif_resultados_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:4b-resultados-asignatura:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Resultados de aprendizajes',
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'planificacion' => $planificacion
        ));
    }

    /**
     * Funcion auxiliar para remover los items que fueron borrados por el formulario.
     *
     * @param Planificacion $planificacion
     */
    private function actualizarResultados(Planificacion $planificacion) {

        $em = $this->getDoctrine()->getManager();

        ////////////////////////////////////////////////////////////////////////////////
        // ESTO ES NECESARIO PARA QUE ANDE EL DELETE EN LAS COLLECCIONES
        // VER:
        // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
        //Buscar los temarios de la base de datos
        $resultadosOriginal = $em->getRepository(ResultadosAprendizajes::class)
                ->findBy(array('planificacion' => $planificacion));

        foreach ($resultadosOriginal as $resultados) {

            if (false === $planificacion->getResultados()->contains($resultados)) {
                // remove the Task from the Tag
                $planificacion->getResultados()->removeElement($resultados);
                $em->remove($resultados);
            }
        }
    }

}
