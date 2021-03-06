<?php

namespace PlanificacionesBundle\Form;

use AppBundle\Form\DatalistType;
use PlanificacionesBundle\Entity\RequisitosAprobacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequisitosAprobacionType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('porcentajeAsistencia', DatalistType::class, array(
            'label' => 'Asistencia %',
            'required' => true,
            'choices' => array(70, 75, 80, 85, 90, 95, 100),
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('fechaPrimerParcial', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA', 'autocomplete' => 'off'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'Primer Parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));


        $builder->add('fechaSegundoParcial', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'Segundo Parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));


        $builder->add('fechaRecupPrimerParcial', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'Primer Parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));

        $builder->add('fechaRecupSegundoParcial', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'label' => 'Segundo Parcial',
            'label_attr' => array('class' => 'font-weight-bold', 'title' => 'Este campo es obligatorio.')
        ));

        $builder->add('prevePromParcialTeoria', CheckboxType::class, array(
            'label' => 'Teor??a',
            'required' => false,
                //  'attr' => array('class' => 'form-control')
        ));

        $builder->add('prevePromParcialPractica', CheckboxType::class, array(
            'label' => 'Pr??ctica',
            'required' => false,
                //    'attr' => array('class' => 'form-control')
        ));

        $builder->add('preveCfi', ChoiceType::class, array(
            'label' => '??Prev?? coloquio final integrador?',
            'required' => true,
            'choices' => array('S??' => true, 'No' => false),
            'choices_as_values' => true,
            'expanded' => true,
            'multiple' => false,
            'attr' => array('class' => '',
                'onchange' => "onChangePreveIntegrador(event);"
            )
        ));

        $builder->add('fechaParcailCfi', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'label' => 'Fecha integrador',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));

        $builder->add('fechaRecupCfi', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'label' => 'Fecha recuperatorio',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));

        $builder->add('modalidadCfi', TextType::class, array(
            'label' => 'Modalidad CFI',
            'required' => false,
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('examenFinalModalidadRegulares', TextareaType::class, array(
            'label' => 'Modalidad estudiantes regulares',
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'rows' => 4,
            )
        ));
        $builder->add('examenFinalModalidadLibres', TextareaType::class, array(
            'label' => 'Modalidad estudiantes libres',
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'rows' => 4,
            )
        ));


        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event) {
            $requisitosAprobacion = $event->getForm()->getData();
            if ($requisitosAprobacion instanceof RequisitosAprobacion && false === $requisitosAprobacion->preveCfi()) {
                //en caso de que la asignatura no prevea un CFI se debe poner en null los campos:
                //  - fechaParcailCfi
                //  - fechaRecupCfi
                //  - modalidadCfi
                $requisitosAprobacion->setFechaParcailCfi(null);
                $requisitosAprobacion->setFechaRecupCfi(null);
                $requisitosAprobacion->setModalidadCfi(null);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\RequisitosAprobacion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_planificacion';
    }

}
