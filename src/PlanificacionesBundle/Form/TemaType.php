<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('unidad', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
            'label' => 'Nro. Unidad',
            'invalid_message' => 'Ingrese el número de Unidad correspondiente al tema.',
            'attr' => array('class' => 'form-control required')
        ));

        $builder->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Titulo',
            'required' => false, //esto es solo para probar, este campo es obligatorio
            'attr' => array('class' => 'form-control')
        ));
        
        $builder->add('contenido', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'attr' => array(
                'rows' => 4,
                'class' => 'form-control')
            )
        );


    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Temario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planificacionesbundle_tema';
    }


}
