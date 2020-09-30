<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViajeAcademicoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('descripcion', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Descripcion',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )
                );
        
        $builder
                ->add('objetivos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Objetivos',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )
                );
        
        $builder
                ->add('recorrido', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Recorrido (indicando horarios)',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )
                );
        
        $builder
                ->add('cantEstudiantes', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'label' => 'Estudiantes',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control cant_estudiantes',
                        'min' => 0
                        )
                ));
        
        
        $builder
                ->add('cantDocentes', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'label' => 'Docentes',
                    'required' => true,
                    'attr' => array('class' => 'form-control cant_docentes', 'min' => 0)
                ));
        
        //dump($builder->getData());
        
        $builder
                ->add('totalPasajeros', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'label' => 'Total',
                    'required' => false,
                  //  'mapped' => false,
                   // 'data' => 0,
                    'attr' => array('class' => 'form-control total_pasajeros', 'min' => 0, 'readonly' => true)
                ));
        
        $builder
                ->add('vehiculo', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                    'label' => 'Tipo de movilidad',
                    'class' => 'PlanificacionesBundle\Entity\Vehiculo',
                    'attr' => array(
                        'class' => 'form-control js-select2')
                ));
        
        $builder
                ->add('fechaTentativa', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
                    'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA', 'autocomplete' => 'off'),
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'label' => 'Fecha tentativa',
                    'label_attr' => array('class' => 'font-weight-bold')
                ));        
        
        $builder
                ->add('cantDias', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'label' => 'Cantidad de días',
                    'required' => false,
                    'attr' => array('class' => 'form-control', 'min' => 0)
                ));
        
        $builder
                ->add('asignaturas', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Asignaturas vinculadas',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )                                                
        );
        
        
        $builder->add('posicion', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
            'attr' => array(
                'class' => 'posicion',
            )
        ));
        
        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
            'label' => 'Descartar cambios',
            'attr' => array('class' => 'btn btn-sm btn-outline-secondary')
        ));
        
        /* ->add('planificacion')->add('asignaturas'); */
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\ViajeAcademico'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_viajeacademico';
    }

}
