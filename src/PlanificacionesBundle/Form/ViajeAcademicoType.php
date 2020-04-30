<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViajeAcademicoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('descripcion', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'label' => 'Descripcion',
            'attr' => array(
                'rows' => 3,
                'class' => 'form-control', 'required' => true)
            )
        )
        ->add('objetivos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'label' => 'Objetivos',
            'attr' => array(
                'rows' => 3,
                'class' => 'form-control', 'required' => true)
            )
        )
        ->add('recorrido', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'label' => 'Recorrido (indicando horarios)',
            'attr' => array(
                'rows' => 3,
                'class' => 'form-control')
            )
        )
        ->add('cantEstudiantes', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Estudiantes',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control')
        ))
        ->add('cantDocentes', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Docentes',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control')
        ))
        ->add('vehiculos')//Tipo de movilidad
                
        ->add('fechaTentativa', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Fecha Tentativa',
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ))
         ->add('cantDias','Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Cantidad de días',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control')
        ));
                /*->add('planificacion')->add('asignaturas');*/
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\ViajeAcademico'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planificacionesbundle_viajeacademico';
    }


}
