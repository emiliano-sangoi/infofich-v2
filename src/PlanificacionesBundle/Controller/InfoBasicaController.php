<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Entity\Rol;
use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\PlanificacionType;
use PlanificacionesBundle\Entity\Estado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InfoBasicaController extends Controller {

    use PlanificacionTrait;

    public function editAction(Request $request, Planificacion $planificacion) {
        //dump($planificacion->getEstadoActual());exit;
        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));
        
        $form = $this->crearForm($planificacion, $planificacion->isPublicada());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //nombre de la asignatura:      
            $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
            $nombreAsignatura = Texto::ucWordsCustom($asignatura->getNombreMateria());
            $planificacion->setNombreAsignatura($nombreAsignatura);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', 'Cambios guardados correctamente.');

            //Redireccionar para evitar posibles "re-submits" del form:
            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $planificacion->getId()));
        }        

        // Breadcrumbs
        $this->setBreadcrumb($planificacion, 'Información básica', $this->get("router")->generate('planif_info_basica_editar', array('id' => $planificacion->getId())));        

        return $this->render('PlanificacionesBundle:1-info-basica:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion). ' - Información básica',
                    'planificacion' => $planificacion,
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'info_basica_route' => $this->generateUrl('planif_info_basica_editar', array('id' => $planificacion->getId())),
                    'usuario' => $this->getUser(),
        ));
    }

}
