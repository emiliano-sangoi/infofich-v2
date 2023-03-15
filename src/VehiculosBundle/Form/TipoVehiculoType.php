<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Entity\TipoVehiculo;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class TipoVehiculoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('nombre', TextType::class, array(
            'label' => 'Nombre',
            'label_attr' => array('class' => 'font-weight-bold'),
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('descripcion', TextareaType::class, array(
            'label' => 'Descripción',
            'label_attr' => array('class' => 'font-weight-bold'),
            'required' => true, //esto es solo para probar, este campo es obligatorio
            'attr' => array('class' => 'form-control ', 'rows' => 4)
        ));

        $tipo = $builder->getData();
        if($tipo instanceof TipoVehiculo and $tipo->getFechaBaja() != null) {
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

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => TipoVehiculo::class,
            'attr' => array(
                'id' => 'id_tipovehiculo_form'
            )
        ));
    }

}
