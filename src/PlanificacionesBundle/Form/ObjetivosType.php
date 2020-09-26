<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetivosType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->addObjetivosGenerales($builder, $options);
        $this->addObjetivosEspecificos($builder, $options);

        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
            'attr' => array(
                'class' => 'btn bg-verde text-color-white',
                'onclick' => 'onGuardarObjetivosClick(event);'
            ),
            'label' => 'Guardar'
        ));

        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
            'label' => 'Limpiar campos',
            'attr' => array('class' => 'btn btn-secondary')
        ));
    }

    /**
     * Agrega el campo objetivos generales en el formulario.
     *      
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    private function addObjetivosGenerales(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => 'Generales',
            'required' => true,
            'attr' => array(
                'rows' => 6,
                'class' => 'form-control',
            //'required' => true
            ),
            'constraints' => array()
        );
        
        //el campo es requerido:
        $config['constraints'][] = new \Symfony\Component\Validator\Constraints\NotBlank(array(
           'message'  => 'Este campo no puede quedar vacio'
        ));

        $builder->add('objetivosGral', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', $config);
    }
    
    
    /**
     * Agrega el campo objetivos generales en el formulario.
     *      
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    private function addObjetivosEspecificos(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => 'Específicos',
            'required' => true,
            'attr' => array(
                'rows' => 6,
                'class' => 'form-control'
            ),                
            'constraints' => array()
        );
        
        //el campo es requerido:
        $config['constraints'][] = new \Symfony\Component\Validator\Constraints\NotBlank(array(
           'message'  => 'Este campo no puede quedar vacio'
        ));

        $builder->add('objetivosEspecificos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', $config);
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
