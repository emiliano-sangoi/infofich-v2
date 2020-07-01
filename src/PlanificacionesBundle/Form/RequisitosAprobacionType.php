<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequisitosAprobacionType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('porcentajeAsistencia', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Asistencia',
            'required' => true,
            'choices' => array('70' => 70, '80' => 80, '90' => 90, '100' => 100),
            'attr' => array('class' => 'form-control')
        ));


        $builder->add('fechaPrimerParcial', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'Primer Parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));


        $builder->add('fechaSegundoParcial', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'Segundo Parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));


        $builder->add('fechaRecupPrimerParcial', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'Primer Parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));

        $builder->add('fechaRecupSegundoParcial', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'Segundo Parcial',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));

        /*
         * Este campo no esta mapeado
         */
        $builder->add('preveProm', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'mapped' => false,
            'required' => true,
            'empty_data' => 'No', //En teoria este es para el valor por defecto
            'label' => 'Prevé promoción',
            'choices' => array('Si'=>'Sí','No'=>'No'),
            'expanded' => true, //Es para que se vea como radiobuttons
            'attr' => array('class' => '',
                'onchange' => "onChangePreve(event);")
        ));

        $builder->add('prevePromParcialTeoria', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array(
            'label' => 'Teoría',
            'required' => false,
                //'attr' => array('class' => 'form-control')
        ));

        $builder->add('prevePromParcialPractica', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array(
            'label' => 'Práctica',
            'required' => false,
                // 'attr' => array('class' => 'form-control')
        ));

        $builder->add('preveCfi', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Prevé coloquio final integrador ',
            'required' => true,
            'choices' => array('Si'=>'Sí','No'=>'No'),
            'expanded' => true,
            'attr' => array('class' => '', 
                'onchange'=>"onChangePreveIntegrador(event);")
        ));

        $builder->add('fechaParcailCfi', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'label' => 'Fecha integrador',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));

        $builder->add('fechaRecupCfi', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'label' => 'Recuperatorio',
            'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')
        ));

        $builder->add('modalidadCfi', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Modalidad CFI',
            'required' => false,
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('examenFinalModalidadRegulares', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Modalidad estudiantes regulares',
            'required' => false,
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        $builder->add('examenFinalModalidadLibres', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Modalidad estudiantes libres',
            'required' => false,
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
            'attr' => array(
                'class' => 'btn bg-verde text-color-white',
                'onclick' => 'onGuardarReqAprobacionClick(event);'
            ),
            'label' => 'Guardar'
        ));

        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
            'label' => 'Limpiar campos',
            'attr' => array('class' => 'btn btn-secondary')
        ));
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
