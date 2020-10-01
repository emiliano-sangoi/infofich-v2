<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CargaHorariaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
//        getTotalCargaHorariaActividades
        $p = $options['planificacion'];
        
        $builder
                ->add('totalCargaHorariaAula', 'Symfony\Component\Form\Extension\Core\Type\NumberType', array(
                    'label' => 'Total',
                    'required' => false,
                    'mapped' => false,
                    'data' => $p->getTotalCargaHorariaAula(),
                    'attr' => array('class' => 'form-control w-50', 'min' => 0, 'readonly' => true)
                ));
        
        
        $builder
                ->add('totalCargaHorariaAutonomo', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'label' => 'Estudio autónomo',
                    'required' => false,
                    'mapped' => false,
                    'data' => $p->getTotalCargaHorariaAutonomo(),
                    'attr' => array('class' => 'form-control w-50', 'min' => 0, 'readonly' => true)
        ));
        
        $builder
                ->add('totalFormacionPractica', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'label' => 'Formación práctica',
                    'required' => false,
                    'mapped' => false,
                    'data' => $p->getTotalFormacionPractica(),
                    'attr' => array('class' => 'form-control w-50', 'min' => 0, 'readonly' => true)
        ));
        
        $builder
                ->add('totalFormacionExperimental', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'label' => 'Formación experimental',
                    'required' => false,
                    'mapped' => false,
                    'data' => $p->getTotalFormacionExperimental(),
                    'attr' => array('class' => 'form-control w-50', 'min' => 0, 'readonly' => true)
        ));
        
        
        
        
        
        $builder->add('cantHsResolProbIng', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Resolución de problemas abiertos de ing',
                    'attr' => array(
                        'class' => 'form-control w-25',
                        'required' => true
                    )
                ))
                ->add('cantHsEjRutinarios', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Ejercicios rutinarios',
                    'attr' => array(
                        'class' => 'form-control w-50',
                        'required' => true
                    )
                ))
                ->add('cantHsActProyDisenio', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Act. de proyecto y diseño',
                    'attr' => array(
                        'class' => 'form-control w-50',
                        'required' => true
                    )
                ))
                ->add('cantHsPracticaProfSup', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Práctica final supervisada',
                    'attr' => array(
                        'class' => 'form-control w-50',
                        'required' => true
                    )
                ))
                ->add('cantHsTeoria', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Teoría',
                    'attr' => array(
                        'class' => 'form-control w-50',
                        'required' => true
                    )
                ))
                ->add('cantHsConsulta', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Evaluación',
                    'attr' => array(
                        'class' => 'form-control w-50',
                        'required' => true
                    )
                ))
                ->add('cantHsEvaluacion', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Consultas',
                    'attr' => array(
                        'class' => 'form-control w-50',
                        'required' => true
                    )
        ));
        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
            'attr' => array(
                'class' => 'btn bg-verde text-color-white',
                'onclick' => 'onGuardarDistribucionClick(event);'
            ),
            'label' => 'Guardar'
        ));

        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
            'label' => 'Limpiar campos',
            'attr' => array('class' => 'btn btn-secondary')
        ));
        /* ->add('planificacion'); */
    }

/**
     * {@inheritdoc}
     */

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\CargaHoraria',
            'planificacion' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_cargahoraria';
    }

}
