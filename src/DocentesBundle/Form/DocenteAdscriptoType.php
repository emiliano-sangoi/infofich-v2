<?php

namespace DocentesBundle\Form;

use DocentesBundle\Entity\DocenteAdscripto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteAdscriptoType extends AbstractType {

    use DocenteAdscriptoTrait;
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
       
        $this->addResolucion($builder, $options);

        $builder->add('persona', \AppBundle\Form\PersonaType::class, array(
            'label' => false,
       //     'mapped' => false,
            'constraints' => array(
                new \Symfony\Component\Validator\Constraints\Valid()
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => DocenteAdscripto::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'docentesbundle_docenteadscripto';
    }

}
