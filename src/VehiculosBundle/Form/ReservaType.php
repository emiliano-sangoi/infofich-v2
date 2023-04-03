<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Entity\Reserva;
use DocentesBundle\Entity\DocenteGrado;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;




class ReservaType extends AbstractType {
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        

        $builder
            ->add('docente', EntityType::class, array(
                'label' => 'Docente',
                'class' => DocenteGrado::class,
                'required' => true,
                //'property' => 'descripcion',
                'attr' => array(
                    'class' => 'form-control js-select2-docentes',                    
                ),
                'label_attr' => array(
                    'class' => 'font-weight-bold',
                )
        ));

        $builder->add('vehiculo', EntityType::class, array(
            'label' => 'Vehiculo',
            'class' => Vehiculo::class,
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control js-select2',                    
            ),
            'label_attr' => array(
                'class' => 'font-weight-bold',
            )
        ));


        $builder
        ->add('fechaInicio', DateTimeType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA hh:mm', 'autocomplete' => 'off'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy H:m',
            'required' => true,
            'label' => 'Fecha Inicio',
            'label_attr' => array('class' => 'font-weight-bold'),
        ));

      
        $builder
        ->add('fechaFin', DateTimeType::class, array(
            'attr' => array('class' => 'form-control',  'placeholder' => 'dd/mm/AAAA hh:mm', 'autocomplete' => 'off'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy H:m',
            'required' => true,
            'label' => 'Fecha Fin',
        ));



        $builder->add('estado', TextType::class, array(
            'label' => 'Estado',
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'                
            )
        ));

        $builder->add('cantidadPersonas', TextType::class, array(
            'label' => 'Cantidad de Personas',
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'                
            )
        ));

        $builder->add('elementosExtras', TextType::class, array(
            'label' => 'Elementos Extras',
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'                
            )
        ));
  

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Reserva::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'vehiculosbundle_reservas';
    }

}
