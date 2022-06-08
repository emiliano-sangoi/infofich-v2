<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('unidad', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
            'label' => 'Nro. Unidad',
            'disabled' => true,
            'required' => false,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control',
                'min' => 1, // https://www.w3schools.com/tags/att_input_min.asp
            )
        ));

        $builder->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Título',
            'required' => true, //esto es solo para probar, este campo es obligatorio
            'attr' => array('class' => 'form-control ')
        ));

        $builder->add('contenido', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'label' => 'Contenido',
            'required' => false,
            'attr' => array(
                'rows' => 10,
                'class' => 'form-control ')
                )
        );

        $builder->add('posicion', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
            'attr' => array(
                'class' => 'posicion',
            )
        ));

//        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
//            'label' => 'Descartar cambios',
//            'attr' => array('class' => 'btn btn-sm btn-outline-secondary')
//        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Temario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_tema';
    }

}
