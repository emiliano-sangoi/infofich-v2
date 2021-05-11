<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Util\Texto;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\ResultadosAprendizajes;
use PlanificacionesBundle\Form\ResultadosAprendizajeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $form = $this->createForm(ResultadosAprendizajeType::class, $planificacion);
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

        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());
        
        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Resultados de Aprendizaje', 
                $this->get("router")->generate('planif_resultados_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:4b-resultados-asignatura:edit.html.twig', array(
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
