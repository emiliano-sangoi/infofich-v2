<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FICH\APIRectorado\Config\WSHelper;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        return $this->render('index.html.twig');
    }

    public function pruebaAction(Request $request) {

        $query = new \FICH\APIInfofich\Query\Carreras\QueryCarreras();

        $data = $query
                ->setUnidadAcademica(WSHelper::UA_FICH)
                ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO)
                ->setCacheEnabled(false)
                ->getResultado();

        dump($data, $query->getError());
        exit;


        return $this->render('index.html.twig');
    }

}
