<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActividadesCurricularesType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('actividadesCurriculares', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
            // each entry in the array will be an "email" field
            'entry_type' => 'PlanificacionesBundle\Form\ActividadCurricularType',
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            
            // para que se pueda persistir en cascada:
            'by_reference' => false, 
            // ver: https://symfony.com/doc/2.8/form/form_collections.html#allowing-new-tags-with-the-prototype
            
            
            'attr' => array(
                'class' => 'cronograma-selector',
            ),
            'entry_options' => array(
                'label' => false
            ),            
            'label' => false,
        ));                
        
        $submit_opt = array(
            'attr' => array(
                'class' => 'btn btn-secondary',
                'onclick' => 'onGuardarCronogramaClick(event);'
             ),
            'label' => 'Guardar cambios'
        );                
        
        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', $submit_opt);
        
        
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
        return 'planificacionesbundle_cronograma';
    }

}
