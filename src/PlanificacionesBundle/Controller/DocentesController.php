<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Util\Texto;
use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DocentesController extends Controller {

    /**
     * Metodo encargado de guardar los cambios en equipo docente.
     * 
     * IMPORTANTE:
     *  Al guardarse un nuevo docente se revisa si la persona asociada ya existe en la base de datos. Si existe, se reutiliza,
     *  sino se crea una nueva.
     *  Esto se maneja en un evento de Doctrine, ver el metodo prePersist, en PlanificacionesBundle/EventListener/DocenteListener
     * 
     * 
     * @param Request $request
     * @param Planificacion $planificacion
     * @return type
     */
    public function editAction(Request $request, Planificacion $planificacion) {

        $form = $this->createForm("PlanificacionesBundle\Form\DocentesType", $planificacion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            ////////////////////////////////////////////////////////////////////////////////
            // PARA QUE ANDE EL DELETE LEER:
            // https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
            $this->borrarDocentes($planificacion);
            ////////////////////////////////////////////////////////////////////////////////

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Cambios guardados correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_equipo_docente_editar', array('id' => $planificacion->getId()));
        }

        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());

        return $this->render('PlanificacionesBundle:2-equipo-docente:edit.html.twig', array(
                    'planificacion' => $planificacion,
                    'page_title' => $page_title,
                    'form' => $form->createView(),
                    'subtitulo' => 'Modificar equipo docente',
        ));
    }

    /**
     * Funcion auxiliar para borrar los docentes en una coleccion.
     * 
     * Esto se debe hacer de esta forma por que asi lo require las collecciones. Ver:
     *      https://symfony.com/doc/2.8/form/form_collections.html#template-modifications
     * 
     * 
     * @param Planificacion $planificacion
     */
    private function borrarDocentes(Planificacion $planificacion) {

        $em = $this->getDoctrine()->getManager();

        //Buscar los temarios de la base de datos
        $docentes_colaboradores = $em->getRepository('PlanificacionesBundle:DocenteColaboradorPlanificacion')
                ->findBy(array('planificacion' => $planificacion));

        foreach ($docentes_colaboradores as $docente) {
            if (false === $planificacion->getDocentesColaboradores()->contains($docente)) {
                // remove the Task from the Tag
                $planificacion->getDocentesColaboradores()->removeElement($docente);
                $em->remove($docente);
            }
        }
        
        // =======================================================================
        
        //Buscar los temarios de la base de datos
        $docentes_adscriptos = $em->getRepository('PlanificacionesBundle:DocenteAdscriptoPlanificacion')
                ->findBy(array('planificacion' => $planificacion));

        foreach ($docentes_adscriptos as $docente) {
            if (false === $planificacion->getDocentesAdscriptos()->contains($docente)) {
                // remove the Task from the Tag
                $planificacion->getDocentesAdscriptos()->removeElement($docente);
                $em->remove($docente);
            }
        }
    }
   
    /**
     * Metodo que permite obtener los datos de un docente via Ajax o algun otro cliente
     * 
     *      
     * @param string $legajo
     * @return JsonResponse
     */
    public function getDocenteAction($legajo) {

        $q = new QueryDocentes();
        $docentes = $q->setCacheEnabled(true)
                ->getDocentes();

        if (!isset($docentes[$legajo])) {
            throw $this->createNotFoundException('No se encontro el docente especificado');
        }

        return new JsonResponse($docentes[$legajo]);
    }

}
