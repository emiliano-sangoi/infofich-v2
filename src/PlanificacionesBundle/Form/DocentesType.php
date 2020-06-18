<?php

namespace PlanificacionesBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocentesType extends AbstractType {

    /**
     *
     * @var ArrayCollection 
     */
    private $docentesColaboradores;

    /**
     *
     * @var ArrayCollection 
     */
    private $docentesAdscriptos;

    public function __construct() {
        $this->docentesColaboradores = new ArrayCollection;
        $this->docentesAdscriptos = new ArrayCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('docenteResponsable', 'PlanificacionesBundle\Form\DocenteResponsablePlanificacionType', array(
                    'label' => 'Responsable',
                    'label_attr' => array(
                        'class' => 'font-weight-bold',
                    ),
        ));


        $builder
                ->add('docentesColaboradores', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
                    // each entry in the array will be an "email" field
                    'entry_type' => 'PlanificacionesBundle\Form\DocenteColaboradorPlanificacionType',
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
                        'label' => false
                    ),
                    'label' => 'Colaborador/a',
                    'label_attr' => array(
                        'class' => 'font-weight-bold',
                    ),
        ));


        $builder
                ->add('docentesAdscriptos', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
                    // each entry in the array will be an "email" field
                    'entry_type' => 'PlanificacionesBundle\Form\DocenteAdscriptoPlanificacionType',
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
                        'label' => false
                    ),
                    'label' => 'Adscripto/a',
                    'label_attr' => array(
                        'class' => 'font-weight-bold',
                    ),
        ));

        $submit_opt = array(
            'attr' => array(
                'class' => 'btn bg-verde text-color-white',
                'onclick' => 'onGuardarCambiosDocentesClick(event);'
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
            'data_class' => 'PlanificacionesBundle\Entity\Planificacion'
        ));
    }

}
