<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RolType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('nombre', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Nombre',
            'attr' => array('class' => 'form-control',
                'autocomplete' => 'off',
                'placeholder' => 'Ej. ROLE_ADMIN, ROLE_USUARIO'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));


        $builder->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Título',
            'attr' => array('class' => 'form-control',
                'autocomplete' => 'off',
                'placeholder' => "Ej. \"Administrador del sistema\", \"Secretario académico\""),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));


        $builder
                ->add('descripcion', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                    'required' => false,
                    'label' => 'Descripción',
                    'attr' => array('class' => 'form-control',
                        'autocomplete' => 'off',
                        'rows' => 5,
                        'placeholder' => 'Descripción de que funcionalidades pueden ejecutar usuarios con este rol.'),
                    'label_attr' => array(
                        'class' => 'font-weight-bold'
                    )
        ));

        $builder->add('permisos', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
            'attr' => array('class' => '',
                'placeholder' => ''),
            'class' => 'AppBundle:Permiso',
            'multiple' => true,
            'expanded' => true,
            'choice_label' => 'titulo',            
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));

        // $builder->add('permisos');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Rol'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_rol';
    }

}
