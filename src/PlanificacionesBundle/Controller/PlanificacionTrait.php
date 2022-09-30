<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PlanificacionesBundle\Controller;

use AppBundle\Entity\Rol;
use AppBundle\Util\Texto;
use FICH\APIInfofich\Model\Materia;
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
    private function crearForm(Planificacion $planificacion, $disabled = false, $carrera_default = null){

        $form_opt = array(
            'disabled' => $disabled,
            'carrera_default' => $carrera_default
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

        if($planificacion->getAsignatura()){
            return $planificacion->getTitulo();
        }

        //titulo principal:
        $api_infofich_service = $this->get('api_infofich_service');
        $asignatura = $api_infofich_service->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        if($asignatura instanceof Materia){
            $page_title = mb_strtoupper( Texto::ucWordsCustom($asignatura->getNombreMateria()) );
        }else{
            $page_title = 'Sin titulo';
        }

        return $page_title;
    }

    /**
     * Crea el formulario para enviar a corrección una planificación
     *
     * @param Planificacion $planificacion
     * @return Form
     */
    private function crearFormEnviarACorreccion(Planificacion $planificacion) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('planificaciones_enviar_a_correccion', array('id' => $planificacion->getId())))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }

    /**
     * Crea el formulario para enviar a corrección una planificación
     *
     * @param Planificacion $planificacion
     * @return Form
     */
    private function crearFormPublicarPlanif(Planificacion $planificacion) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('planificaciones_publicar', array('id' => $planificacion->getId())))
                        ->setMethod('POST')
                        ->getForm();
    }

    /**
     * Crear un formulario para borrar la planificacion
     *
     * @param Planificacion $planificacion Planificacion a borrar
     *
     * @return Form The form
     */
    private function crearFormBorrarPlanif(Planificacion $planificacion) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('planificaciones_borrar', array('id' => $planificacion->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     *
     * @param Planificacion $planificacion
     * @return type
     */
    private function crearFormEnviarPlanif(Planificacion $planificacion) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('planificaciones_revisar', array('id' => $planificacion->getId())))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }
}
