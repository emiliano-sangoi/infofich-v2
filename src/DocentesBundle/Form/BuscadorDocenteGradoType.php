<?php

namespace DocentesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuscadorDocenteGradoType extends AbstractType {

    
    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('nroLegajo', IntegerType::class, array(
            'attr' => array('class' => 'form-control'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'required' => false,
            'label' => 'Nro. legajo',
            'constraints' => array(

            )
        ));

        $builder->add('documento', IntegerType::class, array(
            'attr' => array('class' => 'form-control'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'required' => false,
            'label' => 'Nro documento',
            'constraints' => array(

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

        $builder->add('estado', ChoiceType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Estado',
            'choices' => array(
                'Todos' => null,
                'Activos' => true,
                'Inactivos' => false,
            ),
            'data' => null,
            // *this line is important*
            'choices_as_values' => true,
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
