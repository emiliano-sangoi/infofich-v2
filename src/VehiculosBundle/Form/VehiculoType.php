<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
                    'class' => 'VehiculosBundle\Entity\TipoVehiculo',
                    'attr' => array(
                        'class' => 'form-control js-select2')
                ));


        
        $builder->add('marca', TextType::class, array(
            'label' => 'Marca',
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'                
            )
        ));

        $builder->add('modelo', TextType::class, array(
            'label' => 'Modelo',
            'required' => true, //esto es solo para probar, este campo es obligatorio
            'attr' => array('class' => 'form-control ')
        ));    

        $builder->add('patente', TextType::class, array(
            'label' => 'Patente',
            'required' => true, //esto es solo para probar, este campo es obligatorio
            'attr' => array('class' => 'form-control ')
        ));  
        
        $builder->add('descripcion', TextType::class, array(
            'label' => 'Descripción',
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'                
            )
        ));

        $builder->add('color', TextType::class, array(
            'label' => 'Color',
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'                
            )
        ));

        $builder->add('capacidad', TextType::class, array(
            'label' => 'Capacidad',
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'                
            )
        ));

        $builder->add('combustible', TextType::class, array(
            'label' => 'Combustible',
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'                
            )
        ));

        $builder->add('chasisCasco', TextType::class, array(
            'label' => 'Chasis/Casco',
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
            'class' => 'VehiculosBundle\Entity\Vehiculo',
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
