<?php

namespace PlanificacionesBundle\Form;

use DocentesBundle\Entity\DocenteGrado;
use Doctrine\Common\Collections\ArrayCollection;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanificacionDocentesType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->addDocenteResponsable($builder, $options);

        $builder
                ->add('docentesColaboradores', CollectionType::class, array(
                    // each entry in the array will be an "email" field
                    'entry_type' => PlanificacionDocenteColaboradorType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    // para que se pueda persistir en cascada:
                    'by_reference' => false,
                    // ver: https://symfony.com/doc/2.8/form/form_collections.html#allowing-new-tags-with-the-prototype
                    'attr' => array(
                        'class' => 'docentes-colaboradores-selector',
                    ),
                    'entry_options' => array(
                        'label' => false,
                        'label_format' => 'form.persona.%id%',
//                        'attr' => array('class' => 'bg-primary')
                    ),
                    'label' => false,
                    'label_attr' => array(
                        'class' => 'font-weight-bold',
                    ),
        ));

        $builder
                ->add('docentesAdscriptos', CollectionType::class, array(
                    // each entry in the array will be an "email" field
                    'entry_type' => PlanificacionDocenteAdscriptoType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    // para que se pueda persistir en cascada:
                    'by_reference' => false,
                    // ver: https://symfony.com/doc/2.8/form/form_collections.html#allowing-new-tags-with-the-prototype
                    'attr' => array(
                        'class' => 'docentes-adscriptos-selector',
                    ),
                    'entry_options' => array(
                        'label' => false,
                        'label_format' => 'form.persona.%id%',
//                        'attr' => array('class' => 'bg-primary')
                    ),
                    'label' => false,
                    'label_attr' => array(
                        'class' => 'font-weight-bold',
                    ),
        ));

    }

    private function addDocenteResponsable(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('docenteResponsable', EntityType::class, array(
                    'label' => 'Responsable',
                    'class' => DocenteGrado::class,
                    'required' => false,
                    //'property' => 'descripcion',
                    'attr' => array(
                        'class' => 'form-control js-select2-docentes',                    
                    ),
                    'label_attr' => array(
                        'class' => 'font-weight-bold',
                    )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Planificacion::class,
        ));
    }

}
