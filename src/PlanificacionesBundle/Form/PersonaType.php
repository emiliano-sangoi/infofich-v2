<?php

namespace PlanificacionesBundle\Form;

use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('documento', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'DNI',
            //  'mapped' => false,
            'attr' => array('class' => 'form-control nro-dni', 'disabled' => 'disabled')
        ));

        $builder->add('telefono', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Teléfono',
            //      'mapped' => false,
            'attr' => array('class' => 'form-control telefono', 'disabled' => 'disabled')
        ));

        $builder->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
            'label' => 'Correo electrónico',
            //       'mapped' => false,
            'attr' => array('class' => 'form-control email', 'disabled' => 'disabled')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Persona'
        ));
    }

}
