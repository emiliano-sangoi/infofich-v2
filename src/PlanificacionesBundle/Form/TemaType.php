<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PlanificacionesBundle\Entity\Temario;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TemaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('unidad', IntegerType::class, array(
            'label' => 'Nro. Unidad',
            //'disabled' => true,
            'required' => false,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control',
                'min' => 1, // https://www.w3schools.com/tags/att_input_min.asp
            )
        ));

        $builder->add('titulo', TextType::class, array(
            'label' => 'Título',
            'required' => true, //esto es solo para probar, este campo es obligatorio
            'attr' => array('class' => 'form-control ')
        ));

        $builder->add('contenido', TextareaType::class, array(
            'label' => 'Contenido',
            'required' => false,
            'attr' => array(
                'rows' => 10,
                'class' => 'form-control ')
                )
        );

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Temario::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_tema';
    }

}
