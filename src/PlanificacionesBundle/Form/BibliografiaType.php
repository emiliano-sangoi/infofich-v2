<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BibliografiaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //Armar el constructor con todos los campos

        $builder->add('titulo', 'Symfony\Componednt\Form\Extension\Core\Type\TextType', array(
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
            'required' => true,
            'attr' => array(
                'class' => 'form-control'
            )
        ))
        ->add('disponibleBiblioteca', 'Symfony\Component\Form\Extension\Core\Type\RadioType', array(
            'label' => 'Disponible en biblioteca',
                //'attr' => array('class' => 'form-control')
        ))
        ->add('disponibleOnline', 'Symfony\Component\Form\Extension\Core\Type\RadioType', array(
            'label' => 'Disponible online',
                //'attr' => array('class' => 'form-control')
        ))
        ->add('fechaConsultaOnline', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Fecha consulta online',
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ))
        ->add('enlaceOnline', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Enlace',
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
            'data_class' => 'PlanificacionesBundle\Entity\Planificacion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_bibliografia';
    }


}
