<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Entity\TipoVehiculo;
use VehiculosBundle\Entity\Vehiculo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use VehiculosBundle\Repository\TipoVehiculoRepository;
use Doctrine\ORM\QueryBuilder;


class VehiculoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {


        $this->addTipoVehiculo($builder, $options);

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
                'class' => 'form-control js-select2'),
            'placeholder' => 'Seleccionar Asociado',
            'empty_data'  => null,
            'required' => false
        ));

        $vehiculo = $builder->getData();
        if($vehiculo instanceof Vehiculo and $vehiculo->getFechaBaja() != null) {
            $builder->add('fechaBaja', DateTimeType::class, array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA hh:mm', 'autocomplete' => 'off'),
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:m',
                'required' => true,
                'label' => 'Fecha baja',
                'label_attr' => array('class' => 'font-weight-bold')
            ));
        }

        $builder->add('habilitado', ChoiceType::class, array(
            'choices' => array(
                'Si' => true,
                'No' => false
            ),
            'label_attr' => array('class' => 'font-weight-bold'),
            'required' => true,
            'choices_as_values' => true,
            'attr' => array('class' => 'form-control'),
        ));

        $builder->add('visible', ChoiceType::class, array(
            'choices' => array(
                'Si' => true,
                'No' => false
            ),
            'label_attr' => array('class' => 'font-weight-bold'),
            'required' => true,
            'choices_as_values' => true,
            'attr' => array('class' => 'form-control'),
        ));


    }

    private function addTipoVehiculo(FormBuilderInterface $builder, array $options){

        $config = array(
            'label' => 'Tipo vehículo',
            'label_attr' => array('class' => 'font-weight-bold'),
            'class' => TipoVehiculo::class,
            'attr' => array(
                'class' => 'form-control js-select2')
        );

        $vehiculo = $builder->getData();
        if($vehiculo instanceof Vehiculo and $vehiculo->getId() == null){
            //creando nuevo registro:

            // En este caso solo debe traer los tipos habilitados y que no fueron dados de baja:
            $config['query_builder'] = function (TipoVehiculoRepository $tvr) {
                /* @var $qb QueryBuilder */
                $qb = $tvr->createQueryBuilder('tv');
                $qb
                    ->where($qb->expr()->eq('tv.habilitado', true))
                    ->andWhere($qb->expr()->isNull('tv.fechaBaja'))
                    ->orderBy('tv.nombre', 'ASC');

                return $qb;
            };

        }

        $builder->add('tipo', EntityType::class, $config);


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Vehiculo::class,
            'attr' => array(
                'id' => 'id_vehiculo_form'
            )
        ));
    }

        /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'vehiculos_vehiculo';
    }


}
