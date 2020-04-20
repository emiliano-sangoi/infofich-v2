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
            'mapped' => false,
            'choices' => array(70, 80, 90, 100),
            'attr' => array('class' => 'form-control')
        ));


        $builder->add('fechaPrimerParcial', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Primer Parcial',
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('fechaSegundoParcial', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Segundo Parcial',
            'choices' => array(date('d/m/Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ));


        /* $builder->add('contenidosMinimos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
          'label' => 'Contenidos mínimos',
          'attr' => array(
          'rows' => 8,
          'class' => 'form-control'
          )
          ));

          $builder->add('departamento', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
          'label' => 'Departamento',
          'class' => 'PlanificacionesBundle\Entity\Departamento',
          'attr' => array(
          'class' => 'form-control'
          )
          ));


          $builder
          ->add('asignatura')
          ->add('cargaHoraria')
          ->add('requisitosAprobacion'); */
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

    public function getCarreras() {

        $carreras_fich = $this->apiInfofichService->getCarrerasFICH();

        if (!$carreras_fich) {
            return array();
        }

        $carreras = array();
        foreach ($carreras_fich as $carrera) {
            $carreras[$carrera['codigoCarrera']] = $carrera['nombreCarrera'] . ' - Plan ' . $carrera['planCarrera'];
        }

        return $carreras;
    }

}
