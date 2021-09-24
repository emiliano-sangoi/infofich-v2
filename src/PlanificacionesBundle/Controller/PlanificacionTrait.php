<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PlanificacionesBundle\Controller;

use AppBundle\Entity\Rol;
use AppBundle\Util\Texto;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Form\PlanificacionType;
use Symfony\Component\Form\Form;
use function mb_strtoupper;

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
        if(!$habilitar_dpto){
            $form_opt['deshabilitados'] = array('departamento');
        }

        // El campo "Contenidos mínimos" solo debe habilitarse si el rol del usuario es admin o de secretaria academica.
        $habilitar_contenidos_minimos = $user->tieneRol(Rol::ROLE_ADMIN) || $user->tieneRol(Rol::ROLE_SEC_ACADEMICA);
        if(!$habilitar_contenidos_minimos){
            $form_opt['deshabilitados'] = array('contenidos_minimos');
        }
        
        return $this->createForm(PlanificacionType::class, $planificacion, $form_opt);                
    }
    
    private function getPageTitle(Planificacion $planificacion){
        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());
        
        return mb_strtoupper($page_title);
    }
}
