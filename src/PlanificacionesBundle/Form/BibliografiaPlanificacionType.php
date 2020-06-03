<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BibliografiaPlanificacionType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        //Armar el constructor con todos los campos

        $builder->add('bibliografia', 'PlanificacionesBundle\Form\BibliografiaType', array(
            'label' => false,
            'required' => true,
        ));


        $builder
                ->add('tipoBibliografia', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                    'class' => 'PlanificacionesBundle\Entity\TipoBibliografia',
                    'required' => true,
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
            'data_class' => 'PlanificacionesBundle\Entity\BibliografiaPlanificacion'
        ));
    }


}
