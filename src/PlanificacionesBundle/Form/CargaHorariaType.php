<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CargaHorariaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cantHsResolProbIng','Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Resolución de problemas abiertos de ing',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('cantHsEjRutinarios','Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Ejercicios rutinarios',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('cantHsActProyDisenio','Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Act. de proyecto y diseño',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('cantHsPracticaProfSup','Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Práctica final supervisada',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('cantHsTeoria','Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Teoría',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('cantHsConsulta','Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Evaluación',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('cantHsEvaluacion','Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Consultas',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ));
                        /*->add('planificacion');*/
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\CargaHoraria'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planificacionesbundle_cargahoraria';
    }


}
