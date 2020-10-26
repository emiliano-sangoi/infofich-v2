<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PlanificacionesBundle\Controller;

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
}
