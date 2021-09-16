<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\ActividadesCurricularesType;
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

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $form = $this->createForm(ActividadesCurricularesType::class, $planificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->actualizarActividadCurricular($planificacion);

            $em = $this->getDoctrine()->getManager();
            /*
              $em->flush();

              $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');

              return $this->redirectToRoute('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
             */

            try {
                $em->flush();
                $this->addFlash('success', 'Los datos de esta sección fueron guardados correctamente.');
                //return $this->redirectToRoute('planif_temario_editar', array('id' => $planificacion->getId()));
            } catch (ForeignKeyConstraintViolationException $ex) {
                $msg = 'Las actividades curriculares definidos no pueden ser borrados porque estan siendo utilizados en otra sección.';
                $this->addFlash('error', $msg);
                //$form->addError(new \Symfony\Component\Form\FormError($msg));
            }
            return $this->redirectToRoute('planif_act_curriculares_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Cronograma de actividades', $this->get("router")->generate('planif_act_curriculares_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:7-cronograma:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion) . ' - Cronograma de actividades',
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
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
        //dump($$planificacion);exit;


        foreach ($actCurricularOriginal as $actCurricular) {
            if (false === $planificacion->getActividadCurricular()->contains($actCurricular)) {
                // remove the Task from the Tag
                $planificacion->getActividadCurricular()->removeElement($actCurricular);
                $em->remove($actCurricular);
            }
        }
    }

}
