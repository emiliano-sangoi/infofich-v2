<?php

namespace VehiculosBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Entity\ReservaVehiculos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class ReservaVehiculosType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){


        $builder->add('vehiculo', EntityType::class, array(
            'class' => Vehiculo::class,
            'label' => false,
            'required' => false,
            //'property' => 'apeNom',
            'attr' => array(
                'class' => 'form-control js-select2-vehiculos',
               // 'placeholder' => 'Apellido y Nombre',
            ),
            'label_attr' => array(
                'class' => 'font-weight-bold',
            )
        ));

        $builder->add('orden', HiddenType::class, array(
            'attr' => array(
                'class' => 'orden',
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => ReservaVehiculos::class,
            'attr' => array(
                'id' => 'id_reserva_vehiculos_form'
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
//    public function getBlockPrefix() {
//        return 'vehiculosbundle_reservas_vehiculos';
//    }

}
