<?php

namespace VehiculosBundle\Form;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                    'class' => 'form-control js-select2',
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
            'label' => 'Fecha Devolución',
            'label_attr' => array('class' => 'font-weight-bold'),
        ));

        $builder
            ->add('fechaAlta', DateTimeType::class, array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA hh:mm', 'autocomplete' => 'off'),
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:m',
                'required' => false,
                'disabled' => true,
                'label' => 'Fecha de Alta',
                'label_attr' => array('class' => 'font-weight-bold'),
            ));

        $builder
            ->add('usuarioAlta', EntityType::class, array(
                'label' => 'Usuario alta',
                'class' => Usuario::class,
                'choice_label' => 'usernameApeNom',
                'required' => false,
                'disabled' => true,
                'attr' => array(
                    'class' => 'form-control js-select2',
                ),
                'label_attr' => array(
                    'class' => 'font-weight-bold',
                )
            ));


        /*$builder->add('estado', TextType::class, array(
            'label' => 'Estado',
            'label_attr' => array('class' => 'font-weight-bold'),
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'
            )
        ));*/

        $builder->add('cantidadPersonas', TextType::class, array(
            'label' => 'Cant. de personas',
            'label_attr' => array('class' => 'font-weight-bold'),
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('elementosExtras', TextareaType::class, array(
            'label' => 'Elementos extras',
            'label_attr' => array('class' => 'font-weight-bold'),
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control',
                'rows' => 4
            )
        ));

        $builder->add('motivo', TextareaType::class, array(
            'label' => 'Motivo',
            'label_attr' => array('class' => 'font-weight-bold'),
            //'disabled' => true,
            'required' => true,
            //'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array(
                'class' => 'form-control',
                'rows' => 2
            )
        ));

        $builder->add('tipoProyecto', ChoiceType::class, [
            'choices'  => [
                'SAT' => 'SAT',
                'PI' => 'PI',
                'I' => 'I',
                'Sec. Academica' => 'SA',
                'Sec. Extensión' => 'SE',
                'Sec. Ciencia y Técnica' => 'CyT',
                'Otros' => 'otros',
            ],  
            'attr' => array(
                'class' => 'form-control js-select2',
            ),
            'label_attr' => array(
                'class' => 'font-weight-bold',
            ),
            'label' => 'Tipo de Proyecto'
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Reserva::class,
            'attr' => array(
                'id' => 'id_reserva_form'
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'vehiculosbundle_reservas';
    }

}
