<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetivosType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('objetivosGral', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'label' => 'General',
            'attr' => array(
                'rows' => 4,
                'class' => 'form-control',
                'required' => true)
                )
        );

        $builder->add('objetivosEspecificos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'label' => 'Específicos',
            'attr' => array(
                'rows' => 4,
                'class' => 'form-control',
                'required' => true)
                )
        );


        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
            'attr' => array(
                'class' => 'btn btn-secondary',
                'onclick' => 'onGuardarObjetivosClick(event);'
            ),
            'label' => 'Guardar'
        ));
    }

/**
     * {@inheritdoc}
     */

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Planificacion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_planificaciones';
    }

}
