<?php

namespace PlanificacionesBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocentesType extends AbstractType {

    use DocenteFormTrait;

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

        $this->addDocenteResponsable($builder, $options);

//dump($this->getDocentes());exit;
//        $builder
//                ->add('docentesColaboradores', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
//                    // each entry in the array will be an "email" field
//                    'entry_type' => 'PlanificacionesBundle\Form\DocenteColaboradorPlanificacionType',
//                    'allow_add' => true,
//                    'allow_delete' => true,
//                    'prototype' => true,
//                    // para que se pueda persistir en cascada:
//                    'by_reference' => false,
//                    // ver: https://symfony.com/doc/2.8/form/form_collections.html#allowing-new-tags-with-the-prototype
//                    'attr' => array(
//                        'class' => 'docentes-colaboradores-selector',
//                    ),
//                    'entry_options' => array(
//                        'label' => false,
//                        'attr' => array('class' => 'bg-primary')
//                    ),
//                    'label' => false,
//                    'label_attr' => array(
//                        'class' => 'font-weight-bold',
//                    ),
//        ));
//        $builder
//                ->add('docentesAdscriptos', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
//                    // each entry in the array will be an "email" field
//                    'entry_type' => 'PlanificacionesBundle\Form\DocenteAdscriptoPlanificacionType',
//                    'allow_add' => true,
//                    'allow_delete' => true,
//                    'prototype' => true,
//                    // para que se pueda persistir en cascada:
//                    'by_reference' => false,
//                    // ver: https://symfony.com/doc/2.8/form/form_collections.html#allowing-new-tags-with-the-prototype
//                    'attr' => array(
//                        'class' => 'docentes-adscriptos-selector',
//                    ),
//                    'entry_options' => array(
//                        'label' => false
//                    ),
//                    'label' => false,
//                    'label_attr' => array(
//                        'class' => 'font-weight-bold',
//                    ),
//        ));

        $submit_opt = array(
            'attr' => array(
                'class' => 'btn btn-success text-color-white',
            // 'onclick' => 'onGuardarCambiosDocentesClick(event);'
            ),
            'label' => 'Guardar'
        );

        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', $submit_opt);
    }

    private function addDocenteResponsable(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('docenteResponsable', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                    'label' => 'Responsable',
                    'class' => \DocentesBundle\Entity\DocenteGrado::class,
                    'property' => 'descripcion',
                    //  'property' => 'descripcion',
                    'attr' => array(
                        'class' => 'form-control js-select2',
                        'placeholder' => 'Apellido y Nombre / Nro. Legajo / Numero documento',
//                        'data-toggle' => "tooltip",
//                        'data-placement' => "left",
//                        'title' => "Tooltip on left"
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
            'data_class' => \PlanificacionesBundle\Entity\Planificacion::class,
        ));
    }

}
