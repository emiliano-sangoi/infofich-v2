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
use Symfony\Component\Validator\Constraints\Expression;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class RequisitosAprobacionType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /* @var $entity RequisitosAprobacion */
        $entity = $builder->getData();

        $utiliza_ec = $entity->getUtilizaEvalContinua();

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

        //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // Fecha 2DO. PARCIAL
        $opt = array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => !$utiliza_ec,
            'label' => '2do. parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        );

        if (!$utiliza_ec) {
            $opt['constraints'][] = new NotBlank(array('message' => 'Este campo no puede quedar vacio.'));
            $opt['constraints'][] = new GreaterThanOrEqual(array(
                'value' => 'today',
                'message' => 'La fecha debe ser mayor o igual al día de hoy.'
            ));
        }
        $builder->add('fechaSegundoParcial', DateType::class, $opt);
        //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

        $builder->add('fechaRecupPrimerParcial', DateType::class, array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => '1er. parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));

        //>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
        // Fecha recuperatorio 2DO. PARCIAL
        $opt = array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => !$utiliza_ec,
            'label' => '2do. parcial',
            'label_attr' => array('class' => 'font-weight-bold', 'title' => 'Este campo es obligatorio.'),
        );

        if (!$utiliza_ec) {
            $opt['constraints'][] = new NotBlank(array('message' => 'Este campo no puede quedar vacio.'));
        }

        $builder->add('fechaRecupSegundoParcial', DateType::class, $opt);
        //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

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
            'label' => false,
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
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'rows' => 6,
            )
        ));

        $builder->add('examenFinalModalidadRegulares', TextareaType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'rows' => 8,
            )
        ));
        $builder->add('examenFinalModalidadLibres', TextareaType::class, array(
            'label' => false,
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'rows' => 8,
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
            'data_class' => RequisitosAprobacion::class,
            'attr' => array(
                'id' => 'form-req-aprobacion'
            )
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
