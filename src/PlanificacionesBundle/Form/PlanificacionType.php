<?php

namespace PlanificacionesBundle\Form;

use AppBundle\Service\APIInfofichService;
use Exception;
use FICH\APIRectorado\Config\WSHelper;
use PlanificacionesBundle\Entity\Departamento;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class PlanificacionType extends AbstractType {

    /**
     *
     * @var APIInfofichService 
     */
    private $apiInfofichService;
    private $planes;

    /**
     *
     * @var array 
     */
    private $options;

    public function __construct() {
        $this->planes = array();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->options = $options;

        $this->apiInfofichService = $options['api_infofich_service'];
        if (!$this->apiInfofichService instanceof APIInfofichService) {
            throw new Exception('El parametro: api_infofich_service debe ser instancia de AppBundle\Service\APIInfofichService');
        }

        //Bandera que indica si se esta creando(id es null) o editando la planificacion:
        //$this->creandoPlanificacion = $this->planificacion->getId() === null;

        $this->addCarrera($builder, $options);
        $this->addAniAcad($builder, $options);
        $this->addCodigoSIU($builder);

        $builder->add('plan', TextType::class, array(
            'label' => 'Plan de estudio',
            'disabled' => true,
            'attr' => array('class' => 'form-control')
        ));

        $builder->add('caracter', TextType::class, array(
            'label' => 'Caracter',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        ));

        $builder->add('cargaHoraria', TextType::class, array(
            'label' => 'Carga horaria total',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        ));

        $builder->add('periodoCursada', TextType::class, array(
            'label' => 'Periodo',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        ));

        $builder->add('anioCursada', TextType::class, array(
            'label' => 'Año cursada',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        ));

        $contenidos_min_config = array(
            'label' => 'Contenidos mínimos',
            'required' => false,
            'attr' => array(
                'rows' => 8,
                'placeholder' => 'Este campo será completado por Secretaría Académica.',
                'class' => 'form-control disabled',
                'disabled' => 'disabled'
            )
        );

        $builder->add('contenidosMinimos', TextareaType::class, $contenidos_min_config);

        $builder->add('departamento', EntityType::class, array(
            'label' => 'Departamento',
            'class' => Departamento::class,
            'required' => false,
            'disabled' => in_array('departamento', $options['deshabilitados']),
            'choice_label' => function ($dpto) {
                return $dpto->getNombre();
            },
            'attr' => array(
                'class' => 'form-control',
            )
        ));

        $submit_opt = array(
            'attr' => array('class' => 'btn btn-success text-color-white')
        );

        $planif = $builder->getData();
        if ($planif && $planif->puedeEditarse()) {
            if ($builder->getData()->getId()) {
                $submit_opt['label'] = 'Guardar';
            } else {
                $submit_opt['label'] = 'Crear';
            }

            $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', $submit_opt);
        }

        $this->setEventosForm($builder);
    }

    /**
     * En esta funcion se setean todos los eventos del formulario
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    function setEventosForm(FormBuilderInterface $builder) {


        $listenerPreSetDataEvent = function (FormEvent $event) {
            $this->addAsignaturas($event->getForm(), null);

//            // setear el codigo de la carrera si este se encuentra definido
//            $p = $event->getData();
//            //dump($p != null && $p->getAsignatura());exit;
//            if($p != null && $p->getAsignatura()){
//                $event->getForm()->get('codigoSiu')->setData($p->getAsignatura());
//            }
        };

        $listenerPostSubmitEvent = function (FormEvent $event) {

            $cod_carrera = $event->getForm()->getData();

            $planif = $event->getForm()->getParent()->getData();
            //Setear los campos plan y versionPlan en funcion de la carrera elegida.
            if ($cod_carrera) {
                $carrera = $this->apiInfofichService->getCarrera($cod_carrera);

                $planif->setPlan($carrera->getPlanCarrera())
                        ->setVersionPlan($carrera->getVersionPlan());

                //Agregar la asignautura:
                $this->addAsignaturas($event->getForm()->getParent(), $cod_carrera);
            }
        };


        //$builder->addEventListener(FormEvents::PRE_SUBMIT, $listenerPreSubmitEvent);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, $listenerPreSetDataEvent);
        $builder->get('carrera')->addEventListener(FormEvents::POST_SUBMIT, $listenerPostSubmitEvent);
    }

    private function addCodigoSIU(FormBuilderInterface $builder) {


        $p = $builder->getData();
        $codigoSiu = $p instanceof Planificacion ? $p->getCodigoAsignatura() : null;
        //dump($p->getCodigoAsignatura());exit;
        $builder->add('codigoSiu', TextType::class, array(
            'label' => 'Código SIU',
            'mapped' => false,
            'required' => false,
            'data' => $codigoSiu,
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        ));
    }

    /**
     * Agrega los campos relacionados a la carrera
     * 
     * Carrera, plan y version del plan son necesarios para obtener las asignaturas de la carrera.
     * 
     * @param FormBuilderInterface $builder
     */
    private function addCarrera(FormBuilderInterface $builder) {
        $config = array(
            'label' => 'Carrera',
            'choices' => $this->getCarreras(),
            //'required' => false,
            'attr' => array('class' => 'form-control select-carrera js-select2',
                'data-planes-carrera' => json_encode($this->planes)), //esto es para obtener la informacion del plan para el campo "Plan Estudio"
            'constraints' => array(
                new NotBlank(array('message' => "El campo Carrera es obligatorio."))
            )
        );

        if (!$builder->getData()->getCarrera()) {
            $config['data'] = $this->options['carrera_default'];
        }


        $builder->add('carrera', ChoiceType::class, $config);
    }

    /**
     * 
     * @param FormBuilderInterface $builder
     */
    private function addAsignaturas(FormInterface $builder, $cod_carrera = null) {

        $asignaturas = $this->getAsignaturas($cod_carrera);

        $config = array(
            'label' => 'Asignatura',
            'choices' => $asignaturas,
            'attr' => array('class' => 'form-control select-asignatura js-select2'),
            'constraints' => array(
                new NotBlank(array('message' => 'El campo Asignatura es obligatorio.'))
            )
        );

        $builder->add('codigoAsignatura', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', $config);
    }

    /**
     * Agrega el campo año academico
     * 
     * @param FormBuilderInterface $builder
     */
    private function addAniAcad(FormBuilderInterface $builder) {

        $config = array(
            'label' => 'Año académico',
            'attr' => array('class' => 'form-control js-select2'),
        );

        if ($builder->getData()->getId() == null) {
            //En modo edicion solo puede elegir entre el año actual y el siguiente
            $y = date('Y');
        } else {
            $y = $builder->getData()->getAnioAcad();
        }

        $choices = array(
            $y => $y,
            $y + 1 => $y + 1
        );

        $config['choices'] = $choices;

        $config['constraints'] = array(
            new Choice(array(
                'choices' => $choices,
                'message' => 'Las opciones posibles son ' . implode(' y ', $choices)
                    ))
        );


        $builder->add('anioAcad', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Planificacion',
            'carrera_default' => WSHelper::CARRERA_II,
            'deshabilitados' => array(),
            'api_infofich_service' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_planificacion';
    }

    private function getCarreras() {

        //obtiene las carreras de grado de la fich:
        $carreras_fich = $this->apiInfofichService->getCarreras();

        //dump($carreras_fich);exit;

        if (!$carreras_fich) {
            return array();
        }

        $aux = $this->planes = array();
        foreach ($carreras_fich as $carrera) {
            $aux[$carrera->getCodigoCarrera()] = $carrera;
            $this->planes[$carrera->getCodigoCarrera()] = $carrera->getPlanCarrera();
        }

        return $aux;
    }

    /**
     * Obtiene las asignaturas de cierta carrera
     * 
     * @param type $cod_carrera
     * @return type
     */
    private function getAsignaturas($cod_carrera) {

        $asignaturas = $this->apiInfofichService
                ->getAsignaturasPorCarrera($cod_carrera ?: $this->options['carrera_default']);

        if (!is_array($asignaturas)) {
            return array();
        }

        $aux = array();
        foreach ($asignaturas as $a) {
            $aux[$a->getCodigoMateria()] = $a;
        }

        return $aux;
    }

}
