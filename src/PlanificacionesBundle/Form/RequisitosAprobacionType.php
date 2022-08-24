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
use Symfony\Component\Validator\Constraints\NotBlank;

class RequisitosAprobacionType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /* @var $entity RequisitosAprobacion */
        $entity = $builder->getData();

        $builder->add('porcentajeAsistencia', DatalistType::class, array(
            'label' => false,
            'required' => true,
            'choices' => array(70, 75, 80, 85, 90, 95, 100),
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('fechaPrimerParcial', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA', 'autocomplete' => 'off'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => '1er. parcial',
            'label_attr' => array('class' => 'requerido', 'title' => 'Este campo es obligatorio.')
        ));

        if (!$entity->getUtilizaEvalContinua()) {
            $builder->add('fechaSegundoParcial', DateType::class, array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => true,
                'label' => '2do. parcial',
                'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.'),
                'constraints' => array(
                    new NotBlank(array('message' => 'Este campo no puede quedar vacio.'))
                )
            ));
        }

        $builder->add('fechaRecupPrimerParcial', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => '1er. parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));

        if (!$entity->getUtilizaEvalContinua()) {
            $builder->add('fechaRecupSegundoParcial', DateType::class, array(
                'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
                'label' => '2do. parcial',
                'label_attr' => array('class' => 'font-weight-bold', 'title' => 'Este campo es obligatorio.'),
                'constraints' => array(
                    new NotBlank(array('message' => 'Este campo no puede quedar vacio.'))
                )
            ));
        }

        $builder->add('prevePromParcialTeoria', CheckboxType::class, array(
            'label' => 'Teoría',
            'required' => false,
            //  'attr' => array('class' => 'form-control')
        ));

        $builder->add('prevePromParcialPractica', CheckboxType::class, array(
            'label' => 'Práctica',
            'required' => false,
            //    'attr' => array('class' => 'form-control')
        ));

        $builder->add('preveCfi', ChoiceType::class, array(
            'label' => '¿Prevé coloquio final integrador?',
            'required' => true,
            'choices' => array('Sí' => true, 'No' => false),
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

        $builder->add('requisitosRegul', TextareaType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'rows' => 6,
            )
        ));

        $builder->add('requisitosPromo', TextareaType::class, array(
            'label' => 'Requisitos promoción:',
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'rows' => 6,
            )
        ));

        if ($entity->getUtilizaEvalContinua()) {
            $builder->add('descEvalContinua', TextareaType::class, array(
                'label' => 'Metodología de enseñanza:',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Descripción de la metodología de enseñanza utilizada',
                    'class' => 'form-control',
                    'rows' => 6,
                )
            ));
        }

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


        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RequisitosAprobacion::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planificacionesbundle_planificacion';
    }

}
