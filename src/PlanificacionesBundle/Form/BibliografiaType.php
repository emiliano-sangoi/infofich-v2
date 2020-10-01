<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BibliografiaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->addTitulo($builder, $options);
        $this->addAutores($builder, $options);

        $builder
                ->add('editorial', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Editorial',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )
        ));


        $builder
                ->add('anioEdicion', 'Symfony\Component\Form\Extension\Core\Type\NumberType', array(
                    'label' => 'Año de edición',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )
        ));


        $builder
                ->add('nroEdicion', 'Symfony\Component\Form\Extension\Core\Type\NumberType', array(
                    'label' => 'N° de edición',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )
        ));


        $builder
                ->add('issnIsbn', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'ISSN o ISBN',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control'
                    )
        ));


        $this->addDisponibleBiblioteca($builder, $options);
        $this->addDisponibleOnline($builder, $options);

        $builder
                ->add('fechaConsultaOnline', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
                    'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'label' => 'Fecha consulta online',
                    'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')));


        $builder
                ->add('enlaceOnline', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Enlace',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control'
                    )
        ));
    }

    public function addTitulo(FormBuilderInterface $builder, array $options) {

        $builder->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Título',
            'required' => true,
            'attr' => array(
                'class' => 'form-control'
            )
        ));
    }

    public function addAutores(FormBuilderInterface $builder, array $options) {
        $builder->add('autores', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Autores',
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Apellido, NOMBRE'
            )
        ));
    }
    
    
    public function addDisponibleBiblioteca(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => '¿Disponible en biblioteca?',
            'choices' => array(
                'Si' => true,
                'No' => false,
            ),
            'choices_as_values' => true,
            'required' => true,
            'expanded' => true
        );

        $builder->add('disponibleBiblioteca', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', $config);
    }

    public function addDisponibleOnline(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => '¿Disponible online?',
            'choices' => array(
                'Si' => true,
                'No' => false,
            ),
            'choices_as_values' => true,
            'required' => true,
            'expanded' => true
        );

        $builder->add('disponibleOnline', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Bibliografia'
        ));
    }
   

}
