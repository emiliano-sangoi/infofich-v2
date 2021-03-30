<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form;

use FICH\APIRectorado\Config\WSHelper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * PersonaTypeTrait
 * 
 * @author emi88
 */
trait PersonaTypeTrait {

    public function addTipoDocumento(FormBuilderInterface $builder, array $options, $required = true, $disabled = false, $contraints = array()) {
        $builder
                ->add('tipoDocumento', ChoiceType::class, array(
                    'choices' => WSHelper::getTiposDocumentos(),
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    ),
                    'disabled' => $disabled,
                    'required' => $required,
                    'attr' => array('class' => 'form-control'),
                    'constraints' => $contraints
        ));
    }

    public function addDocumento(FormBuilderInterface $builder, array $options, $required = true, $contraints = array()) {
        $builder
                ->add('documento', IntegerType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    ),
                    'required' => $required,
                    'label' => 'Numero de documento',
                    'constraints' => $contraints
        ));
    }

    private function addFechaNacimiento(FormBuilderInterface $builder, array $options, $required = false, $disabled = false, $contraints = array()) {
        $builder->add('fechaNacimiento', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA', 'autocomplete' => 'off'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => $required,
            'disabled' => $disabled,
            'label' => 'Fecha nacimiento',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.'),
            'constraints' => $contraints
        ));
    }

    private function addGenero(FormBuilderInterface $builder, array $options, $required = false, $disabled = false, $contraints = array()) {

        $choices = array(
            1 => 'Masculino',
            2 => 'Femenino'
        );

        $builder->add('genero', ChoiceType::class, array(
            'choices' => $choices,
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'disabled' => $disabled,
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'constraints' => $contraints,
        ));
    }

    private function addApellidos(FormBuilderInterface $builder, array $options, $required = true, $disabled = false, $contraints = array()) {
        $builder->add('apellidos', TextType::class, array(
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'disabled' => $disabled,
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'constraints' => $contraints,
        ));
    }

    private function addNombres(FormBuilderInterface $builder, array $options, $required = true, $disabled = false, $contraints = array()) {
        $builder->add('nombres', TextType::class, array(
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'disabled' => $disabled,
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'constraints' => $contraints,
        ));
    }

    private function addEmail(FormBuilderInterface $builder, array $options, $required = false, $disabled = false, $contraints = array()) {
        $builder
                ->add('email', EmailType::class, array(
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    ),
                    'disabled' => $disabled,
                    'required' => $required,
                    'attr' => array('class' => 'form-control'),
                    'constraints' => $contraints,
        ));
    }

    private function addTelefono(FormBuilderInterface $builder, array $options, $required = false, $disabled = false, $contraints = array()) {
        $builder
                ->add('telefono', TextType::class, array(
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    ),
                    'disabled' => $disabled,
                    'required' => $required,
                    'attr' => array('class' => 'form-control'),
                    'constraints' => $contraints,
        ));
    }

}
