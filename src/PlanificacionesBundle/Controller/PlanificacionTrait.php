<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PlanificacionesBundle\Controller;

use AppBundle\Entity\Rol;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\PlanificacionType;
use Symfony\Component\Form\Form;

/**
 *
 * @author emi88
 */
trait PlanificacionTrait {
    
    
    function setBreadcrumb($planificacion, $label_current, $route){
        
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem($label_current, $route);
        $breadcrumbs->addItem("EDITAR");
        
        
    }
    
    /**
     * 
     * @param Planificacion $planificacion
     * @return Form
     */
    private function crearForm(Planificacion $planificacion){
        
        $api_infofich_service = $this->get('api_infofich_service');
        
        $form_opt = array(
            'api_infofich_service' => $api_infofich_service,
        );
        
        // El campo "Departamento" solo debe habilitarse si el rol del usuario es admin o de secretaria academica.
        $user = $this->getUser();        
        $habilitar_dpto = $user->tieneRol(Rol::ROLE_ADMIN) || $user->tieneRol(Rol::ROLE_SEC_ACADEMICA);
        //dump($habilitar_dpto);exit;
        if(!$habilitar_dpto){
            $form_opt['deshabilitados'] = array('departamento');
        }
        
        return $this->createForm(PlanificacionType::class, $planificacion, $form_opt);                
    }
}
