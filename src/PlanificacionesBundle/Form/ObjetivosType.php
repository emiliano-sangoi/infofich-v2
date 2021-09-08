<?php

namespace PlanificacionesBundle\Form;

use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ObjetivosType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->addObjetivosGenerales($builder, $options);
        $this->addObjetivosEspecificos($builder, $options);

        $planif = $builder->getData();
        if ($planif && $planif->puedeEditarse()) {
            $builder->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-success text-color-white',
                ),
                'label' => 'Guardar'
            ));
        }
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
        $config['constraints'][] = new NotBlank(array(
            'message' => 'Este campo no puede quedar vacio'
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
        $config['constraints'][] = new NotBlank(array(
            'message' => 'Este campo no puede quedar vacio'
        ));

        $builder->add('objetivosEspecificos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Planificacion::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_planificaciones';
    }

}
