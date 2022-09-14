<?php

namespace PlanificacionesBundle\Form;

use DocentesBundle\Entity\DocenteAdscripto;
use PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanificacionDocenteAdscriptoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('docenteAdscripto', EntityType::class, array(
            'class' => DocenteAdscripto::class,
            'label' => false,
            'required' => false,
            //'property' => 'apeNom',
            'attr' => array(
                'class' => 'form-control js-select2-docentes',
                'placeholder' => 'Seleccione un docente',
            ),
            'label_attr' => array(
                'class' => 'font-weight-bold',
            ),
            'constraints' => array(
                new \Symfony\Component\Validator\Constraints\NotBlank(array('message' => 'Este campo no puede quedar vacio.'))
            )
        ));

        $builder->add('orden', HiddenType::class, array(
            'attr' => array(
                'class' => 'orden',
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => PlanificacionDocenteAdscripto::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planif_docenteadscripto';
    }

}
