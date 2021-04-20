<?php

namespace DocentesBundle\Controller;

use AppBundle\Service\APIInfofichService;
use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use FICH\APIRectorado\Config\WSHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AdscriptosController
 *
 * @author emi88
 */
class AdscriptosController extends Controller {
    
    
    
    
    public function indexAction(Request $request) {
        
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes adscriptos", $this->get("router")->generate("docentes_adscriptos"));
        
        
        return $this->render('DocentesBundle:Adscripto:index.html.twig', array(
                    'page_title' => 'InfoFICH - Docentes adscriptos',
                    //'docentes_paginado' => $docentes_paginado
        ));
        
    }
    
    public function newAction(Request $request){
        
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes adscriptos", $this->get("router")->generate("docentes_adscriptos"));
        $breadcrumbs->addItem("Nuevo");
        
        
        return $this->render('DocentesBundle:Adscripto:new.html.twig', array(
                    'page_title' => 'InfoFICH - Nuevo docentes adscripto',
                    //'docentes_paginado' => $docentes_paginado
        ));
        
    }
    
}
