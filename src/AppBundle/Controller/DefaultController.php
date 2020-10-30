<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FICH\APIRectorado\Config\WSHelper;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        
        
        return $this->render('index.html.twig', array(
            'page_title' => 'InfoFICH - Inicio'
        ));
    }

    public function pruebaAction(Request $request) {

        $filtro = array(
            WSHelper::CARRERA_IRH,
            WSHelper::CARRERA_IAMB,
            WSHelper::CARRERA_IAGR,
            WSHelper::CARRERA_II,
            WSHelper::CARRERA_LCARTOG,
        );

        $query = new \FICH\APIInfofich\Query\Carreras\QueryCarreras();

        $query
                ->setUnidadAcademica(WSHelper::UA_FICH)
                ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO)
                ->setCacheEnabled(false)
                ->getResultado();
        
        $carreras = $query->filtrar($filtro);
        
        dump($carreras, $query->getError());
        exit;


        return $this->render('index.html.twig');
    }

}
