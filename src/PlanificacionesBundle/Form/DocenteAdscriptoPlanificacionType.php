<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteAdscriptoPlanificacionType extends DocentePlanificacionType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('resolucion', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Resolución de consejo directivo',
            'attr' => array('class' => 'form-control')
        ));
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\DocenteAdscriptoPlanificacion'
        ));
    }
    
        /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_doc_adscripto_planif';
    }


}
