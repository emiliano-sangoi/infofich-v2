<?php

namespace PlanificacionesBundle\Form;

use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;


/**
 * Description of DuplicarPlanificacionType
 *
 * @author emi88
 */
class DuplicarPlanificacionType extends AbstractType {
    
    
        /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $this->addAniAcad($builder);
        
    }
    
    /**
     * Agrega el campo año academico
     * 
     * @param FormBuilderInterface $builder
     */
    private function addAniAcad(FormBuilderInterface $builder) {

        $config = array(
            'label' => 'Año académico: ',
            'label_attr' => array('class' => 'font-weight-bold'),
            'attr' => array('class' => 'form-control js-select2'),
        );

        if ($builder->getData() && $builder->getData()->getId() == null) {
            //En modo edicion solo puede elegir entre el año actual y el siguiente
            $y = date('Y');
        } else {            
            $y = $builder->getData()->getAnioAcad();
        }

        $choices = array(
            $y + 1 => $y + 1,
            $y + 2 => $y + 2,
            $y + 3 => $y + 3,
        );

        $config['choices'] = $choices;

        $config['constraints'] = array(
            new Choice(array(
                'choices' => $choices,
                'message' => 'Las opciones posibles son ' . implode(' y ', $choices)
                    ))
        );


        $builder->add('anioAcad', ChoiceType::class, $config);
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Planificacion::class,
            'attr' => array('class' => '')
        ));
    }
    
    
}
