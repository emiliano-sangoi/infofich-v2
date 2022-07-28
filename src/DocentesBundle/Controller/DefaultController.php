<?php

namespace DocentesBundle\Controller;

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


        return $this->render('DocentesBundle:Default:index.html.twig', array(
            'page_title' => 'InfoFICH - Docentes',
            //s'docentes_paginado' => $docentes_paginado
        ));
    }

}
