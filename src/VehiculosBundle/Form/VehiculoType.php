<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Entity\TipoVehiculo;
use VehiculosBundle\Entity\Vehiculo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class VehiculoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder
                ->add('tipo', EntityType::class, array(
                    'label' => 'Tipo vehículo',
                    'label_attr' => array('class' => 'font-weight-bold'),
                    'class' => TipoVehiculo::class,
                    'attr' => array(
                        'class' => 'form-control js-select2')
                ));

        $builder->add('marca', TextType::class, array(
            'label' => 'Marca',
            'label_attr' => array('class' => 'font-weight-bold'),
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('modelo', TextType::class, array(
            'label' => 'Modelo',
            'label_attr' => array('class' => 'font-weight-bold'),
            'required' => true, //esto es solo para probar, este campo es obligatorio
            'attr' => array('class' => 'form-control ')
        ));

        $builder->add('patente', TextType::class, array(
            'label' => 'Patente',
            'label_attr' => array('class' => 'font-weight-bold'),
            'required' => true, //esto es solo para probar, este campo es obligatorio
            'attr' => array('class' => 'form-control ')
        ));

        $builder->add('descripcion', TextType::class, array(
            'label' => 'Descripción',
            'label_attr' => array('class' => 'font-weight-bold'),
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('color', TextType::class, array(
            'label' => 'Color',
            'label_attr' => array('class' => 'font-weight-bold'),
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('capacidad', TextType::class, array(
            'label' => 'Capacidad',
            'label_attr' => array('class' => 'font-weight-bold'),
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('combustible', TextType::class, array(
            'label' => 'Combustible',
            'label_attr' => array('class' => 'font-weight-bold'),
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('chasisCasco', TextType::class, array(
            'label' => 'Chasis/Casco',
            'label_attr' => array('class' => 'font-weight-bold'),
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder
        ->add('asociado', EntityType::class, array(
            'label' => 'Asociado',
            'label_attr' => array('class' => 'font-weight-bold'),
            'class' => Vehiculo::class,
            'attr' => array(
                'class' => 'form-control js-select2')
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Vehiculo::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'vehiculosbundle_vehiculo';
    }

}
