<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Entity\Rol;
use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\QueryBuilder;
use Exception;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\HistoricoEstados;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\BuscadorType;
use PlanificacionesBundle\Form\DuplicarPlanificacionType;
use PlanificacionesBundle\Repository\HistoricoEstadosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanificacionController extends Controller {

    use PlanificacionTrait;

    public function indexAction(Request $request) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_LISTAR, array('data' => null));

        $form_filtros = $this->createForm(BuscadorType::class, null);
        $form_filtros->handleRequest($request);

        $paginator = $this->get('knp_paginator');
        $paginado = $paginator->paginate(
                $this->getPlanificacionesUsuario($form_filtros), /* query NOT result */ 
                $request->query->getInt('page', 1), /* page number */ 
                10 /* limit per page */
        );

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("PLANIFICACIONES");


        return $this->render('PlanificacionesBundle:planificacion:inicio.html.twig', array(
                    'page_title' => 'Planificaciones de grado',
                    'form' => $form_filtros->createView(),
                    'paginado' => $paginado,
                    'puede_crear' => $this->isGranted(Permisos::PLANIF_CREAR, array('data' => null))
        ));
    }

    /**
     *
     * @param Form $form_filtros
     * @return Query|array
     */
    private function getPlanificacionesUsuario(Form $form_filtros) {       

        $usuario = $this->getUser();
        $carrera = $form_filtros->get('carrera')->getData();
        $codigoAsignatura = $form_filtros->get('codigoAsignatura')->getData();
        $anioAcad = $form_filtros->get('anioAcad')->getData();

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Planificacion::class);
        return $repo->getPlanificacionesUsuario($usuario, $carrera, $codigoAsignatura, $anioAcad);
    }

    /**
     *
     *
     * @param Request $request
     * @return type
     */
    public function newAction(Request $request) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_CREAR, array('data' => null));

        $planificacion = new Planificacion();
        $form = $this->crearForm($planificacion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //nombre de la asignatura:
            $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
            $nombreAsignatura = Texto::ucWordsCustom($asignatura->getNombreMateria());
            $planificacion->setNombreAsignatura($nombreAsignatura);


            $em = $this->getDoctrine()->getManager();
            $em->persist($planificacion);
            $em->flush();

            //asignar estado: creada + en preparacion
            //---------------------------------------------------------------------------
            /* @var $repoHistorico HistoricoEstadosRepository */
            $repoHistorico = $em->getRepository(HistoricoEstados::class);

            $usuario = $this->getUser();
            $repoHistorico->setEstadoCreada($planificacion, $usuario);
            $repoHistorico->asignarEstado($planificacion, Estado::PREPARACION, null);
            //---------------------------------------------------------------------------

            $this->addFlash('success', 'La planificacion fué creada correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem("NUEVA");


        return $this->render('PlanificacionesBundle:1-info-basica:edit.html.twig', array(
                    'form' => $form->createView(),
                    'info_basica_route' => $this->generateUrl('planificaciones_nueva'),
                    'planificacion' => $planificacion,            
                    'page_title' => 'Nueva planificación'
        ));
    }

    public function borrarAction(Planificacion $planificacion, Request $request) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_BORRAR, array('data' => $planificacion));

        $form = $this->crearFormBorrarPlanif($planificacion);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            try {

                //Borrar todos los estados
                $estados = $em->getRepository(HistoricoEstados::class)->findBy(array('planificacion' => $planificacion));
                foreach ($estados as $estado) {
                    $em->remove($estado);
                }

                //Borrar la planificacion:
                $em->remove($planificacion);

                //Impactar cambios:
                $em->flush();

                $this->addFlash('success', 'La planificacion fué borrada correctamente.');

                //Causar redireccion para evitar "re-submits" del form:
                return $this->redirectToRoute('planificaciones_homepage');
            } catch (ForeignKeyConstraintViolationException $ex) {
                
            } catch (Exception $ex) {
                
            }

            $this->addFlash('warning', 'Ocurrió un error al intentar borrar la planificación.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planificaciones_borrar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem("BORRAR");

        return $this->render('PlanificacionesBundle:planificacion:borrar.html.twig', array(
                    'page_title' => 'Borrar planificación',
                    'planificacion' => $planificacion,
                    'form' => $form->createView(),
                    // 'paginado' => $paginado,
                    'puede_borrar' => $this->isGranted(Permisos::PLANIF_BORRAR, array('data' => $planificacion))
        ));
    }

    /**
     * Crear un formulario para borrar la planificacion
     *
     * @param Planificacion $planificacion Planificacion a borrar
     *
     * @return Form The form
     */
    private function crearFormBorrarPlanif(Planificacion $planificacion) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('planificaciones_borrar', array('id' => $planificacion->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Crea una copia de una planificacion
     *
     * @param Request $request
     * @return Response
     */
    public function duplicarAction(Request $request, Planificacion $planificacion) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_DUPLICAR, array('data' => $planificacion));

        //dump($planificacion);exit;
        $form = $this->createForm(DuplicarPlanificacionType::class, $planificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            dump($planificacion);
            exit;
        }


        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem("DUPLICAR");


        return $this->render('PlanificacionesBundle:planificacion:duplicar.html.twig', array(
                    'page_title' => 'Duplicar planificación',
                    'planificacion' => $planificacion,
                    'form' => $form->createView(),
                    // 'paginado' => $paginado,
                    'puede_borrar' => $this->isGranted(Permisos::PLANIF_DUPLICAR, array('data' => $planificacion))
        ));
    }

        /**
     * imprime una planificacion
     *
     * @param Request $request
     * @return Response
     */
    public function imprimirAction(Request $request, Planificacion $planificacion) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_DUPLICAR, array('data' => $planificacion));

        //dump($planificacion);exit;
        $form = $this->createForm(DuplicarPlanificacionType::class, $planificacion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            dump($planificacion);
            exit;
        }


        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem("DUPLICAR");


        return $this->render('PlanificacionesBundle:planificacion:duplicar.html.twig', array(
                    'page_title' => 'Duplicar planificación',
                    'planificacion' => $planificacion,
                    'form' => $form->createView(),
                    // 'paginado' => $paginado,
                    'puede_borrar' => $this->isGranted(Permisos::PLANIF_DUPLICAR, array('data' => $planificacion))
        ));
    }

}
