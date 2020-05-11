<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetivosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('objetivosGral', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'attr' => array(
                'rows' => 4,
                'class' => 'form-control', 
                'required' => true)
            )
        );
        
        $builder->add('objetivosEspecificos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'attr' => array(
                'rows' => 4,
                'class' => 'form-control', 
                'required' => true)
            )
        );


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Planificaciones'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planificacionesbundle_planificaciones';
    }


}
