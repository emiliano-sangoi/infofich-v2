<?php

namespace PlanificacionesBundle\Form;

use AppBundle\Service\APIInfofichService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequisitosAprobacionType extends AbstractType {

    /**
     *
     * @var APIInfofichService 
     */
    private $apiInfofichService;

    /* public function __construct(APIInfofichService $apiInfofichService) {
      $this->apiInfofichService = $apiInfofichService;
      } */

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('porcentajeAsistencia', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Asistencia',
            'required' => true,
            'choices' => array(70, 80, 90, 100),
            'attr' => array('class' => 'form-control')
        ));


        $builder->add('fechaPrimerParcial', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Primer Parcial',
            'required' => true,
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('fechaSegundoParcial', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Segundo Parcial',
            'required' => true,
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('fechaRecupPrimerParcial', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Primer Parcial',
            'required' => true,
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('fechaRecupSegundoParcial', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Segundo Parcial',
            'required' => true,
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ));


        $builder->add('prevePromParcialTeoria', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array(
            'label' => 'Teoría',
                //'attr' => array('class' => 'form-control')
        ));

        $builder->add('prevePromParcialPractica', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', array(
            'label' => 'Práctica',
                // 'attr' => array('class' => 'form-control')
        ));

        $builder->add('preveCfi', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Prevé coloquio final integrador ',
            'choices' => array('Sí', 'No'),
            'expanded' => true,
            'attr' => array('class' => ''
                . ]{
            
            ]+{.5}82
                }2568-
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                7')
        ));

        $builder->add('fechaParcailCfi', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Fecha integrador',
            'required' => true,
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('fechaRecupCfi', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Recuperatorio',
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('modalidadCfi', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Modalidad CFI',
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('examenFinalModalidadRegulares', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Modalidad estudiantes regulares',
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        $builder->add('examenFinalModalidadLibres', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Modalidad estudiantes libres',
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        
        $builder->add('preveProm', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'mapped'=>false,
            'label' => 'Prevé promoción ',
            'choices' => array('Sí', 'No'),
            'expanded' => true,
            'attr' => array('class' => '',
                            'onchange'=>"onChangePrevee(e);")
        ));
        
        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
            'attr' => array(
                'class' => 'btn btn-secondary',
                'onclick' => 'onGuardarReqAprobClick(event);'
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

                }¿{'ñ0l9kj7h6g5f4d3s2a  QA3WS4RF6GYH8UJ9KOL'PÑ¿+}
                
                }+{PLO0J7HJ6G5F4D3122111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111102221111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111+6}op9y56+4