<?php

namespace PlanificacionesBundle\Form;

use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\RequisitosAprobacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilizaEvalContinuaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('utilizaEvalContinua', ChoiceType::class, array(
            'label' => '¿Utiliza evaluación continua?',
            'required' => true,
            'choices' => array('Sí' => true, 'No' => false),
            'choices_as_values' => true,
            'expanded' => true,
            'multiple' => false,
            'attr' => array('class' => 'fix-estilo-radio')
        ));


        $builder->add('descEvalContinua', TextareaType::class, array(
            'label' => 'Metodología de enseñanza',
            'required' => false,
            'attr' => array(
                'placeholder' => 'Descripción de la metodología de enseñanza utilizada',
                'class' => 'form-control',
                'rows' => 8,
            ),
        ));


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RequisitosAprobacion::class,
            'validation_groups' => array('eval_continua'),
            'attr' => array(
                'class' => '',
                'id' => 'form-eval-continua'
            ),
        ));
    }

}

