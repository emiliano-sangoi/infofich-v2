<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DocentesBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

/**
 *
 * @author emi88
 */
trait DocenteAdscriptoTrait {

    public function addResolucion(FormBuilderInterface $builder, array $options, $required = true) {
        
        $conf = array(
            'label' => 'Resolución',
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
        );
        
        $conf['constraints'][] = new Type(array(
            'type' => 'numeric',
            'message' => 'Este campo debe ser numerico'
        ));
        
        if($required){
            $conf['constraints'][] = new NotNull(array(
                'message' => 'Este campo es obligatorio'
            ));
        }
        
        $builder->add('resolucion', TextType::class, $conf);
    }

}
