<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultadosType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->addResultadosGenerales($builder, $options);
        $this->addResultadosEspecificos($builder, $options);

        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
            'attr' => array(
                'class' => 'btn btn-success text-color-white',
                'onclick' => 'onGuardarResultadosClick(event);'
            ),
            'label' => 'Guardar'
        ));


        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
            'label' => 'Limpiar campos',
            'attr' => array('class' => 'btn btn-secondary')
        ));
    }

    /**
     * Agrega el campo resultados generales en el formulario.
     *      
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    private function addResultadosGenerales(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => 'Generales',
            'required' => false,
            'attr' => array(
                'rows' => 6,
                'class' => 'form-control',
            //'required' => true
            ),
            'constraints' => array()
        );
        

        $builder->add('resultadoGral', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', $config);
    }
    
    
    /**
     * Agrega el campo resultados específicos en el formulario.
     *      
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    private function addResultadosEspecificos(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => 'Específicos',
            'required' => false,
            'attr' => array(
                'rows' => 6,
                'class' => 'form-control'
            ),                
            'constraints' => array()
        );

        $builder->add('resultadoEspecificos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Planificacion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_planificaciones';
    }

}
