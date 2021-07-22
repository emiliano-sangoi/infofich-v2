<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form;

use AppBundle\Entity\Persona;
use FICH\APIRectorado\Config\WSHelper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * PersonaTypeTrait
 * 
 * @author emi88
 */
trait PersonaTypeTrait {

    public function addTipoDocumento(FormBuilderInterface $builder, array $options, $required = true, $disabled = false, $contraints = array()) {

        if ($required) {
            $contraints[] = new NotBlank(array(
                'message' => 'Este campo es obligatorio'
            ));
        }
        
        $conf = array(
            'choices' => WSHelper::getTiposDocumentos(),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'disabled' => $disabled,
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'constraints' => $contraints
        );


        $builder
                ->add('tipoDocumento', ChoiceType::class, $conf);
    }

    public function addDocumento(FormBuilderInterface $builder, array $options, $required = true, $contraints = array()) {        

        if ($required) {
            $contraints[] = new NotBlank(array(
                'message' => 'Este campo es obligatorio'
            ));
        }
        
        $conf = array(
            'attr' => array('class' => 'form-control'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'required' => $required,
            'label' => 'Numero de documento',
            'constraints' => $contraints
        );

        $builder->add('documento', IntegerType::class, $conf);
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
            'Masculino' => Persona::GENERO_MASC,
            'Femenino' => Persona::GENERO_FEM,            
        );

        if ($required) {
            $contraints[] = new NotBlank(array(
                'message' => 'Este campo no puede quedar vacio'
            ));
        }else{
            $choices['Sin información'] = null;
        }

        $contraints[] = new Choice(array(
            'choices' => $choices,
            'message' => 'Genero incorrecto.'
        ));

        $builder->add('genero', ChoiceType::class, array(
            'choices' => $choices,
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'disabled' => $disabled,
            'required' => $required,
            'choices_as_values' => true,
            'attr' => array('class' => 'form-control'),
            'constraints' => $contraints,
        ));
    }

    private function addApellidos(FormBuilderInterface $builder, array $options, $required = true, $disabled = false, $contraints = array()) {

        $conf = array(
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'disabled' => $disabled,
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'constraints' => $contraints,
        );

        if ($required) {
            $conf['constraints'][] = new NotBlank(array(
                'message' => 'Este campo es obligatorio.'
            ));
        }

        $builder->add('apellidos', TextType::class, $conf);
    }

    private function addNombres(FormBuilderInterface $builder, array $options, $required = true, $disabled = false, $contraints = array()) {

        $conf = array(
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'disabled' => $disabled,
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'constraints' => $contraints,
        );

        if ($required) {
            $conf['constraints'][] = new NotBlank(array(
                'message' => 'Este campo es obligatorio.'
            ));
        }

        $builder->add('nombres', TextType::class, $conf);
    }

    private function addEmail(FormBuilderInterface $builder, array $options, $required = false, $disabled = false, $contraints = array()) {

        $conf = array(
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'disabled' => $disabled,
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'constraints' => $contraints,
        );

        $conf['constraints'][] = new Email(array(
            'message' => 'Formato incorrecto'
        ));

        if ($required) {
            $conf['constraints'][] = new NotBlank(array(
                'message' => 'Este campo es obligatorio.'
            ));
        }

        $builder->add('email', EmailType::class, $conf);
    }

    private function addTelefono(FormBuilderInterface $builder, array $options, $required = false, $disabled = false, $contraints = array()) {

        $conf = array(
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'disabled' => $disabled,
            'required' => $required,
            'attr' => array('class' => 'form-control'),
            'constraints' => $contraints,
        );

        $conf['constraints'][] = new Type(array(
            'type' => 'numeric',
            'message' => 'Este campo debe ser numérico'
        ));

        $builder->add('telefono', TextType::class, $conf);
    }

}
