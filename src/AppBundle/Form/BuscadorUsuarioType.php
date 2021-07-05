<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuscadorUsuarioType extends AbstractType {

    
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('username', TextType::class, array(
            'attr' => array('class' => 'form-control', 'autocomplete' => 'off'),
            'label' => 'Nombre de usuario',
            'required' => false,
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));
        
        $builder->add('apellidos', TextType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Apellido(s)',
            'required' => false,
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));
        
        $builder->add('nombres', TextType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Nombre(s)',
            'required' => false,
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null,
            'method' => 'GET',
            'csrf_protection' => false,
        ));
    }

}
