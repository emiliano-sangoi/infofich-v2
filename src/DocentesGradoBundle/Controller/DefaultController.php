<?php

namespace DocentesGradoBundle\Controller;

use AppBundle\Service\APIInfofichService;
use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use FICH\APIRectorado\Config\WSHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes", $this->get("router")->generate("docentes_index"));


        return $this->render('DocentesGradoBundle:Default:index.html.twig', array(
                    'page_title' => 'InfoFICH - Docentes',
                    //s'docentes_paginado' => $docentes_paginado
        ));
    }

    public function docentesGradoAction(Request $request) {

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes grado", $this->get("router")->generate("docentes_grado"));

        $queryDocentes = new QueryDocentes();
        $docentes = $queryDocentes
                ->setWsEnv(WSHelper::ENV_PROD)
                ->setCacheEnabled(true)
                ->setEscalafon(QueryDocentes::ESCALAFON_DOCENTES)
                ->setEstado('activo')
                ->getDocentes();


        $paginator = $this->get('knp_paginator');
        $docentes_paginado = $paginator->paginate(
                $docentes, /* query NOT result */ $request->query->getInt('page', 1), /* page number */ $this->getParameter('knp_items_por_pagina')/* limit per page */
        );


        //   dump($docentes);exit;
        //$data = $q->setCacheEnabled(true)->setWsgetDocentes();



        return $this->render('DocentesGradoBundle:Default:docentes-grado.html.twig', array(
                    'page_title' => 'InfoFICH - Docentes grado',
                    'docentes_paginado' => $docentes_paginado
        ));
    }    

}
