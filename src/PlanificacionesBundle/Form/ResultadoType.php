<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultadoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('resultado', TextareaType::class, array(
            'label' => 'Resultado',
            'required' => false,
            'attr' => array(
                'rows' => 4,
                'class' => 'form-control ')
                )
        );

        $builder->add('posicion', HiddenType::class, array(
            'attr' => array(
                'class' => 'posicion',
            )
        ));

        $builder->add('reset', ResetType::class, array(
            'label' => 'Descartar cambios',
            'attr' => array('class' => 'btn btn-sm btn-outline-secondary')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => \PlanificacionesBundle\Entity\ResultadosAprendizajes::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planif_resultado';
    }

  
}
