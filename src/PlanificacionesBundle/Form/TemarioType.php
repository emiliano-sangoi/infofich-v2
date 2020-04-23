<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->add('unidad')->add('titulo')->add('contenido')->add('planificacion');


        $builder->add('unidad', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Unidad',
            'attr' => array('class' => 'form-control', 'required' => true)
        ));

        $builder->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Titulo',
            'attr' => array('class' => 'form-control', 'required' => true)
        ));
        
        $builder->add('contenido', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'attr' => array(
                'rows' => 4,
                'class' => 'form-control', 'required' => true)
            )
        );


    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Temario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planificacionesbundle_temario';
    }


}
