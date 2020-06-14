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
        //Armar el constructor con todos los campos

        $builder->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Título',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('autores', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Autores',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('editorial', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Editorial',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('anioEdicion', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Año de edición',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('nroEdicion', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'N° de edición',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('issnIsbn', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'ISSN o ISBN',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ))
                ->add('disponibleBiblioteca', 'Symfony\Component\Form\Extension\Core\Type\RadioType', array(
                    'label' => 'Disponible en biblioteca',
                    'required' => false,
                        //'attr' => array('class' => 'form-control')
                ))
                ->add('disponibleOnline', 'Symfony\Component\Form\Extension\Core\Type\RadioType', array(
                    'label' => 'Disponible online',
                    'required' => false,
                        //'attr' => array('class' => 'form-control')
        ));

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

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Bibliografia'
        ));
    }
    
        /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_bibliografia';
    }


}
