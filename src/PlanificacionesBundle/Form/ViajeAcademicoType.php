<?php

namespace PlanificacionesBundle\Form;

use PlanificacionesBundle\Entity\ViajeAcademico;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViajeAcademicoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('descripcion', TextareaType::class, array(
                    'label' => 'Descripcion',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )
                );
        
        $builder
                ->add('objetivos', TextareaType::class, array(
                    'label' => 'Objetivos',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )
                );
        
        $builder
                ->add('recorrido', TextareaType::class, array(
                    'label' => 'Recorrido (indicando horarios)',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )
                );
        
        $builder
                ->add('cantEstudiantes', IntegerType::class, array(
                    'label' => 'Estudiantes',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control cant_estudiantes',
                        'min' => 1
                        )
                ));
        
        
        $builder
                ->add('cantDocentes', IntegerType::class, array(
                    'label' => 'Docentes',
                    'required' => true,
                    'attr' => array('class' => 'form-control cant_docentes', 'min' => 1)
                ));
        
        
        $builder
                ->add('totalPasajeros', IntegerType::class, array(
                    'label' => 'Total',
                    'mapped' => false,
                    'required' => false,
                    'attr' => array('class' => 'form-control total_pasajeros', 
                    'min' => 0, 'readonly' => true)
                ));
        
        $builder
                ->add('vehiculo', EntityType::class, array(
                    'label' => 'Tipo de movilidad',
                    'class' => 'PlanificacionesBundle\Entity\Vehiculo',
                    'attr' => array(
                        'class' => 'form-control js-select2')
                ));
        
        $builder
                ->add('fechaTentativa', DateTimeType::class, array(
                    'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA hh:mm', 'autocomplete' => 'off'),
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy H:m',
                    'required' => true,
                    'label' => 'Fecha tentativa de salida',
                    'label_attr' => array('class' => 'font-weight-bold')
                )); 

        $builder
                ->add('fechaTentativaRegreso', DateTimeType::class, array(
                    'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA hh:mm', 'autocomplete' => 'off'),
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy H:m',
                    'required' => true,
                    'label' => 'Fecha tentativa de regreso',
                    'label_attr' => array('class' => 'font-weight-bold')
                ));              
               
        $builder
                ->add('asignaturas', TextareaType::class, array(
                    'label' => 'Asignaturas vinculadas',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )                                                
        );
        
        
        $builder->add('posicion', HiddenType::class, array(
            'attr' => array(
                'class' => 'posicion',
            )
        ));
        
        /*$builder->add('reset', ResetType::class, array(
            'label' => 'Descartar cambios',
            'attr' => array('class' => 'btn btn-sm btn-outline-secondary')
        ));
        */
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => ViajeAcademico::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_viajeacademico';
    }

}
