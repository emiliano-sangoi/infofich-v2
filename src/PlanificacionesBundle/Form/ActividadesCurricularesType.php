<?php

namespace PlanificacionesBundle\Form;

use Exception;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class ActividadesCurricularesType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $planif = $builder->getData();
        
        if(!$planif instanceof Planificacion){
            throw new Exception('Debe especificar una planificacion al utilizar este formulario.');
        }

        $builder->add('actividadCurricular', CollectionType::class, array(
           // 'error_bubbling' => false,   
            'entry_type' => ActividadCurricularType::class,
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
                'label' => false,
                'error_bubbling' => false,
                'planificacion' => $planif,                
            ),            
            'label' => false,   
            'constraints' => array(
                new Valid()
            ),
            'error_bubbling' => false,                     
        ));                
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Planificacion::class,
          //  'error_bubbling' => false,
             'error_bubbling' => false
        ));
    }

}
