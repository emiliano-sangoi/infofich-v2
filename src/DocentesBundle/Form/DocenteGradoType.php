<?php

namespace DocentesBundle\Form;

use DocentesBundle\Entity\DocenteGrado;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\PersonaType;
use Symfony\Component\Validator\Constraints\Valid;

class DocenteGradoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('persona', PersonaType::class, array(
            'label' => false,
            'constraints' => array(
                new Valid()
            )
        ));

        $data = is_null($builder->getData()->getFechaInactivo());
        $builder->add('estado', ChoiceType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Estado',
            'mapped' => false,
            'choices' => array(
                'Activo' => true,
                'Inactivo' => false,
            ),
            'data' => $data,
            // *this line is important*
            'choices_as_values' => true,
            'required' => false,
            'label_attr' => array('class' => 'font-weight-bold')
        ));

        $builder
            ->add('fechaInactivo', DateTimeType::class, array(
                'attr' => array('class' => 'form-control', 'autocomplete' => 'off'),
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:m',
                'required' => false,
                'label' => 'Fecha inactivo',
            ));

        $builder
            ->add('fechaUltimaActualizacion', DateTimeType::class, array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA hh:mm', 'autocomplete' => 'off'),
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy H:m',
                'required' => false,
                'label' => 'Fecha ult. actualización'
            ));

        $builder->add('poseeUsuario', ChoiceType::class, array(
            'attr' => array('class' => 'form-control'),
            'label' => '¿Posee usuario Infofich?',
            'mapped' => false,
            'choices' => array(
                'Si' => true,
                'No' => false,
            ),
            'data' => isset($options['usuario']),
            // *this line is important*
            'choices_as_values' => true,
            'required' => false,
            'label_attr' => array('class' => 'font-weight-bold')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'class' => DocenteGrado::class,
            'usuario' => null
        ));
    }
}
