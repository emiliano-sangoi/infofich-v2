<?php

namespace AppBundle\Controller;

use FICH\APIRectorado\Config\WSHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller {

    public function getAsignaturasAction(Request $request, $carrera) {
        //dump($request, $carrera);
        //exit;               
        if(!ctype_digit($carrera)){
            return new JsonResponse(array('msg' => 'El codigo de carrera debe estar compuesto por digitos.'), 400); 
        }

        if (!in_array($carrera, array(
                    WSHelper::CARRERA_IRH,
                    WSHelper::CARRERA_II,
                    WSHelper::CARRERA_IAMB,
                    WSHelper::CARRERA_IAGR,
                    WSHelper::CARRERA_PTOP,
                    WSHelper::CARRERA_TEC_UNIV_AUT_ROBOTICA
                ))) {
            return new JsonResponse(array('msg' => 'Codigo de carrera incorrecto.'), 400); 
        }
        
        
        $apiInfofichService = $this->get('api_infofich_service');
        $asignaturas = $apiInfofichService->getAsignaturasPorCarrera($carrera);

        if (!is_array($asignaturas)) {
            return new JsonResponse(array('msg' => $apiInfofichService->getUltimoError()), 500);
        }

        return new JsonResponse($asignaturas);
    }
    
    
    public function getAsignaturaAction(Request $request, $carrera, $codigo) {
        //dump($request, $carrera);
        //exit;               
        if(!ctype_alnum($codigo)){
            return new JsonResponse(array('msg' => 'El codigo de la asignatura debe ser alfanumerico.'), 400); 
        }
        
        $apiInfofichService = $this->get('api_infofich_service');
        $asignatura = $apiInfofichService->getAsignatura($codigo);

        if (!$asignatura instanceof \FICH\APIInfofich\Model\Materia) {
            return new JsonResponse(array('msg' => $apiInfofichService->getUltimoError()), 500);
        }

        return new JsonResponse($asignatura);
    }

}
