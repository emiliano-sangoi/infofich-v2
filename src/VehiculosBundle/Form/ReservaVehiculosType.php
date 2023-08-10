<?php

namespace VehiculosBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Entity\ReservaVehiculos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use VehiculosBundle\Repository\VehiculoRepository;


class ReservaVehiculosType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options){
        
        //$this->addVehiculo($builder, $options);

        $builder->add('vehiculo', EntityType::class, array(
            'class' => Vehiculo::class,
            'label' => false,
            'required' => true,
            //'property' => 'apeNom',
            'attr' => array(
                'class' => 'form-control js-select2-vehiculos',
               // 'placeholder' => 'Apellido y Nombre',
            ),
            'label_attr' => array(
                'class' => 'font-weight-bold',
            ),
            'query_builder' => function (VehiculoRepository $v) {
                // Aquí puedes construir tu consulta personalizada con el filtro que necesitas
                return $v->createQueryBuilder('v')
                    ->where('v.visible = :valorFiltro')
                    ->setParameter('valorFiltro', true);
            },
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
