<?php

namespace DocentesBundle\Form;

use DocentesBundle\Entity\DocenteGrado;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteGradoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {        
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'class' => DocenteGrado::class,
            //'label' => false,
            'attr' => array('class' => 'form-control js-select2'),
            'property' => 'getCodApeNom',
            'label' => false,
//            'choice_label' => function ($choiceValue, $key, $value) {
//                if (true === $choiceValue) {
//                    return 'Definitely!';
//                }
//
//                return '<b>' . strtoupper($key) . '</b>';
//
//                // or if you want to translate some key
//                //return 'form.choice.'.$key;
//            },
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'docentesbundle_docentegrado';
    }

    public function getParent() {
        return EntityType::class;
    }

}
