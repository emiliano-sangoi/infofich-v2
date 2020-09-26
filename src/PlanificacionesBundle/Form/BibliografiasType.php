<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BibliografiasType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('bibliografiasPlanificacion', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
            // each entry in the array will be an "email" field
            'entry_type' => 'PlanificacionesBundle\Form\BibliografiaPlanificacionType',
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            // para que se pueda persistir en cascada:
            'by_reference' => false,
            // ver: https://symfony.com/doc/2.8/form/form_collections.html#allowing-new-tags-with-the-prototype
            'attr' => array(
                'class' => 'bibliografia-selector',
            ),
            'entry_options' => array(
                'label' => false
            ),
            //para que no cree una etiqueta obligatoria
            'label' => false,
            'constraints' => array(
                new \Symfony\Component\Validator\Constraints\Valid()
            )
        ));

        $submit_opt = array(
            'attr' => array(
                'class' => 'btn bg-verde text-color-white'
            ),
            'label' => 'Guardar'
        );

        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', $submit_opt);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Planificacion',
            'compound' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_bibliografiaplanificacion';
    }

}
