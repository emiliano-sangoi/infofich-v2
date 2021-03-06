<?php

namespace PlanificacionesBundle\Form;

use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemarioType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('temario', CollectionType::class, array(
            // each entry in the array will be an "email" field
            'entry_type' => TemaType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            // para que se pueda persistir en cascada:
            'by_reference' => false,
            // ver: https://symfony.com/doc/2.8/form/form_collections.html#allowing-new-tags-with-the-prototype
            'attr' => array(
                'class' => 'temario-selector',
            ),
            'entry_options' => array(
                'label' => false
            ),
            'label' => false,
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Planificacion::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_temario';
    }

}
