<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultadoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('resultado', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'label' => 'Resultado',
            'required' => false,
            'attr' => array(
                'rows' => 4,
                'class' => 'form-control ')
                )
        );

        $builder->add('posicion', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
            'attr' => array(
                'class' => 'posicion',
            )
        ));

        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
            'label' => 'Descartar cambios',
            'attr' => array('class' => 'btn btn-sm btn-outline-secondary')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\ResultadosAprendizajes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planif_resultado';
    }

  
}
