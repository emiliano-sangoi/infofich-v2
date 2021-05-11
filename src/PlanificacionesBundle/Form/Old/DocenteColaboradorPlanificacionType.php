<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteColaboradorPlanificacionType extends DocentePlanificacionType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        
        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
            'label' => 'Descartar cambios',
            'attr' => array('class' => 'btn btn-sm btn-outline-secondary')
        ));
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(
                array(
                    'data_class' => 'PlanificacionesBundle\Entity\DocenteColaboradorPlanificacion'
                )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_doc_colabor_planif';
    }

}