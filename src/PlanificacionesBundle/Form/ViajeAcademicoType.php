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
                )
                ->add('objetivos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Objetivos',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )
                )
                ->add('recorrido', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Recorrido (indicando horarios)',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )
                )
                ->add('cantEstudiantes', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Estudiantes',
                    'mapped' => false,
                    'required' => true,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('cantDocentes', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Docentes',
                    'mapped' => true,
                    'required' => true,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('vehiculos', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                    'label' => 'Tipo de movilidad',
                    'class' => 'PlanificacionesBundle\Entity\Vehiculo',
                    'attr' => array(
                        'class' => 'form-control js-select2')
                ))
                ->add('fechaTentativa', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
                    'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'label' => 'Fecha tentativa',
                    'label_attr' => array('class' => 'font-weight-bold')
                ))
                ->add('cantDias', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Cantidad de días',
                    'mapped' => false,
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('asignaturas', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Asignaturas vinculadas',
                    'required' => true,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control')
                        )
        );
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
