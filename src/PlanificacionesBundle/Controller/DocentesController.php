<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto;
use PlanificacionesBundle\Entity\PlanificacionDocenteColaborador;
use PlanificacionesBundle\Form\PlanificacionDocentesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use PlanificacionesBundle\Entity\Estado;
use Symfony\Component\HttpFoundation\Request;
use PlanificacionesBundle\Traits\PlanificacionTrait;

class DocentesController extends Controller {

    use PlanificacionTrait;

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

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        //Deshabilitar el campo cuando la planificación este en revision o publicada
        $config = array();
        $ea = $planificacion->getEstadoActual();
        if($ea && in_array($ea->getCodigo(), [Estado::REVISION, Estado::PUBLICADA])){
            $config = array('disabled' => true);
        }

        $form = $this->createForm(PlanificacionDocentesType::class, $planificacion, $config);

        $form->handleRequest($request);
        // dump($form->get('docenteResponsable')->getData());exit;
        if ($form->isSubmitted() && $form->isValid()) {
            //  dump($form->getData());exit;
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

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Equipo docente', $this->get("router")->generate('planif_equipo_docente_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:2-equipo-docente:edit.html.twig', array(
                    'planificacion' => $planificacion,
                    'page_title' => $this->getPageTitle($planificacion) . ' - Equipo docente',
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
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
        $docentes_colaboradores = $em->getRepository(PlanificacionDocenteColaborador::class)
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
        $docentes_adscriptos = $em->getRepository(PlanificacionDocenteAdscripto::class)
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

        $service = $this->get('api_infofich_service');
        $docentes = $service->getDocentesActivos();

        if (!isset($docentes[$legajo])) {
            throw $this->createNotFoundException('No se encontro el docente especificado');
        }

        return new JsonResponse($docentes[$legajo]);
    }

}
