<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermisoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $permiso = $builder->getData();
        if ($permiso instanceof \AppBundle\Entity\Permiso && $permiso->getId()) {
            $builder->add('codigo', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                'label' => 'Código',
                'attr' => array('class' => 'form-control',
                    'autocomplete' => 'off',
                    'readonly' => true),
                'label_attr' => array(
                    'class' => 'font-weight-bold'
                )
            ));
        }



        $builder->add('titulo', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Nombre',
            'attr' => array('class' => 'form-control',
                'autocomplete' => 'off',
                'placeholder' => 'Nombre o título del permiso'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));


        $builder->add('descripcion', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
            'label' => 'Descripción',
            'attr' => array('class' => 'form-control',
                'autocomplete' => 'off',
                'rows' => 4,
                'placeholder' => 'Descripción de que permite realizar este permiso'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));


//        $builder->add('roles', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
//            'attr' => array('class' => '',
//                'placeholder' => ''),
//            'class' => 'AppBundle:Rol',
//            'multiple' => true,
//            'expanded' => true,
//            'choice_label' => 'titulo',
//            'by_reference' => false,
//            'label_attr' => array(
//                'class' => 'font-weight-bold'
//            )
//        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Permiso'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_permiso';
    }

}
