<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        // dump("lsdslds");exit;
        $builder->add('apellidos', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'attr' => array('class' => 'form-control'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));

        $builder
                ->add('nombres', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    )
        ));

        $builder->add('fechaNacimiento', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA', 'autocomplete' => 'off'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'Fecha nacimiento',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));


        //$tipos_desc = \FICH\APIRectorado\Config\WSHelper::getDescTipoDoc($tipo_doc)
        // dump($tipos);exit;
        $builder
                ->add('tipoDocumento', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                    'choices' => \FICH\APIRectorado\Config\WSHelper::getTiposDocumentos(),
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    ),
                    'attr' => array('class' => 'form-control')
        ));

        $builder
                ->add('documento', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    ),
                    'label' => 'Numero de documento'
        ));

        $builder
                ->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    )
        ));

        $builder
                ->add('telefono', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'attr' => array('class' => 'form-control'),
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    )
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
