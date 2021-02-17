<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViajesAcademicosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('viajesAcademicos', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
            // each entry in the array will be an "email" field
            'entry_type' => 'PlanificacionesBundle\Form\ViajeAcademicoType',
            // Estos campo
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            
            // para que se pueda persistir en cascada:
            'by_reference' => false, 
            // ver: https://symfony.com/doc/2.8/form/form_collections.html#allowing-new-tags-with-the-prototype
            
            
            'attr' => array(
                'class' => 'viajeAcademico-selector',
            ),
            'entry_options' => array(
                'label' => false
            ),            
            'label' => false,
        ));                
        
        
       
        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
            'attr' => array(
                'class' => 'btn btn-success',
                'onclick' => 'onGuardarViajesAcademicosClick(event);'
            ),
            'label' => 'Guardar'
        ));

       
           
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Planificacion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planificacionesbundle_viajesacademicos';
    }


}
