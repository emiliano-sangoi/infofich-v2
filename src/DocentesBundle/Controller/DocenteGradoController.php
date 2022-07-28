<?php

namespace DocentesBundle\Controller;

use AppBundle\Entity\Persona;
use DocentesBundle\Entity\DocenteGrado;
use DocentesBundle\Entity\LogActualizacionDocentesGrado;
use DocentesBundle\Form\DocenteGradoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class DocenteGradoController extends Controller{

    public function indexAction(Request $request)
    {

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes grado", $this->get("router")->generate("docentes_grado_index"));

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(DocenteGrado::class);
        $qb = $repo->getQueryBuilder();


        $paginator = $this->get('knp_paginator');


        $docentes_paginado = $paginator->paginate(
            $qb->getQuery(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            15 /* $this->getParameter('knp_items_por_pagina')/* limit per page */
        );

        return $this->render('DocentesBundle:docentes-grado:index.html.twig', array(
            'page_title' => 'InfoFICH - Docentes grado',
            'ultLogAct' => $this->getLogActualizacionMasReciente(),
            'docentes_paginado' => $docentes_paginado
        ));

    }

    private function getLogActualizacionMasReciente(){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(LogActualizacionDocentesGrado::class);
        return $repo->getLogMasReciente();
    }

    /**
     * Ver información del docente
     *
     */
    public function showAction(DocenteGrado $docenteGrado) {

        $deleteForm = $this->createDeleteForm($docenteGrado);
        $form = $this->createForm(DocenteGradoType::class, $docenteGrado, array(
            'disabled' => true
        ));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes grado", $this->get("router")->generate("docentes_docentes_grado_index"));
        $breadcrumbs->addItem($docenteGrado->__toString());

        $em = $this->getDoctrine()->getManager();
        //$planificaciones = $em->getRepository(DocenteGrado::class)->getPlanificacionesDocente($docenteGrado);

        return $this->render('DocentesBundle:docentes-grado:show.html.twig', array(
            'docenteGrado' => $docenteGrado,
            'delete_form' => $deleteForm->createView(),
            'form' => $form->createView(),
            //'planificaciones' => $planificaciones,
            'page_title' => 'Docentes adscriptos - Ver docente',
        ));
    }

}