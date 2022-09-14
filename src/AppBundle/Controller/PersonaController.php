<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Persona;
use FICH\APIRectorado\Config\WSHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PersonaController
 *
 * @author emi88
 */
class PersonaController extends Controller{
    
    
    public function getPorDocumentoAction($documento, $tipo_doc = WSHelper::TIPO_DOC_DNI){
        
        $documento = filter_var($documento, FILTER_SANITIZE_NUMBER_INT);
        
        if(!in_array($tipo_doc, WSHelper::getTiposDoc())){
            return new JsonResponse(array(
                'error' => 'Tipo de documento incorrecto',
                'tipo_doc' => $tipo_doc,
                'documento' => $documento
            ), Response::HTTP_BAD_REQUEST);
        }
        
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Persona::class);
        $persona = $repo->findOneBy(array(
            'tipoDocumento' => $tipo_doc,
            'documento' => $documento,
        ));
        
        if(!$persona){
            throw $this->createNotFoundException('No se encontro ninguna persona con tipo de documento: ' . $tipo_doc . ' - Nro. documento: ' . $documento);
        }
        
        return new JsonResponse($persona);
        
    }
    
    
}
