<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DocentesBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 *
 * @author emi88
 */
trait DocenteAdscriptoTrait {

    public function addResolucion(FormBuilderInterface $builder, array $options, $required = true) {
        $builder->add('resolucion', TextType::class, array(
            'label' => 'Resolución',
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
        ));
    }

}
