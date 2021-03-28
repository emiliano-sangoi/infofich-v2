<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PlanificacionesBundle\Form;

use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use FICH\APIRectorado\Config\WSHelper;

/**
 *
 * @author emi88
 */
trait DocenteFormTrait {
    
    public function getDocentes() {

        $q = new QueryDocentes();
        $docentes = $q
                ->setWsEnv(WSHelper::ENV_PROD)
                ->setCacheEnabled(true)
                ->setEscalafon(QueryDocentes::ESCALAFON_DOCENTES)
                ->setEstado('activo')
                ->getDocentes();
              //  dump(count($docentes)); exit;
        if(!empty($docentes)){
            uasort($docentes, function($a, $b){
                return strcasecmp($a->getApellido(), $b->getApellido());
            });      
        }             
        return $docentes;
    }
    
    
}
