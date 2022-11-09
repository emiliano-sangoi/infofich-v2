<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Entity\Rol;
use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Carrera;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\PlanificacionType;
use PlanificacionesBundle\Entity\Estado;
use FICH\APIRectorado\Config\WSHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PlanificacionesBundle\Traits\PlanificacionTrait;

class InfoBasicaController extends Controller {

    use PlanificacionTrait;

    public function editAction(Request $request, Planificacion $planificacion) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_EDITAR, array('data' => $planificacion));

        $em = $this->getDoctrine()->getManager();

        $carrera_id = $planificacion->getAsignatura()->getCarrera();
        
        $carrera_default = $em->getRepository(Carrera::class)
            ->findOneBy(['id' => $carrera_id  ]);

        //dump($carrera_default);exit;
        $form = $this->crearForm($planificacion, $planificacion->isPublicada(), $carrera_default);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            $this->addFlash('success', 'Cambios guardados correctamente.');

            //Redireccionar para evitar posibles "re-submits" del form:
            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        //dump($planificacion);exit;
        $this->setBreadcrumb($planificacion, 'Información básica', $this->get("router")->generate('planif_info_basica_editar', array('id' => $planificacion->getId())));

        return $this->render('PlanificacionesBundle:1-info-basica:edit.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => $this->getPageTitle($planificacion). ' - Información básica',
                    'planificacion' => $planificacion,
                    'errores' => $this->get('planificaciones_service')->getErrores($planificacion),
                    'info_basica_route' => $this->generateUrl('planif_info_basica_editar', array('id' => $planificacion->getId())),
        ));
    }

}
