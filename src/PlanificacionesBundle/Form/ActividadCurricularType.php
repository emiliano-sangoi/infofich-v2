<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActividadCurricularType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('tipoActividadCurricular', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                    'label' => 'Tipo',
                    'class' => 'PlanificacionesBundle\Entity\TipoActividadCurricular',
                    'attr' => array(
                        'class' => 'form-control js-select2')
            ))                
                
                ->add('fecha', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
                    'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Fecha',
                    'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
                ))
                ->add('otras', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Otras',
                    'required' => false,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control'
                    )
                ))
                ->add('cargaHorariaAula', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Carga horaria en aula',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('cargaHorariaAutonomo', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Horas de estudio autónomo',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('contenido', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Contenidos',
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control'
                    )
                ))                
                ->add('descripcion', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'label' => 'Descripción',
                    'required' => false,
                    'attr' => array(
                        'rows' => 3,
                        'class' => 'form-control'
                    )
                ));
                //->add('planificacion')
        //->add('temario');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\ActividadCurricular'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_actividadcurricular';
    }

}
