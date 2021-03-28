<?php

namespace PlanificacionesBundle\Form;

use DocentesBundle\Entity\DocenteGrado;
use PlanificacionesBundle\Entity\PlanificacionDocenteColaborador;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanificacionDocenteColaboradorType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('docenteGrado', EntityType::class, array(
            'class' => DocenteGrado::class,
            'label' => false,
            //'property' => 'apeNom',
            'attr' => array(
                'class' => 'form-control js-select2',
                'placeholder' => 'Apellido y Nombre',
            ),
            'label_attr' => array(
                'class' => 'font-weight-bold',
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
            'data_class' => PlanificacionDocenteColaborador::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planif_docentecolaborador';
    }

}
