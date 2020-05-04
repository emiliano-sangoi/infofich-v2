<?php

namespace PlanificacionesBundle\Form;

use AppBundle\Service\APIInfofichService;
use FICH\APIInfofich\Model\Materia;
use FICH\APIRectorado\Config\WSHelper;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class PlanificacionType extends AbstractType {

    /**
     *
     * @var APIInfofichService 
     */
    private $apiInfofichService;
    private $planes;

    /**
     *
     * @var Planificacion 
     */
    private $planificacion;

    /**
     *
     * @var bool
     */
    private $creandoPlanificacion;

    /**
     *
     * @var array 
     */
    private $carreras;

    /**
     *
     * @var array
     */
    private $asignaturas;

    /**
     *
     * @var array 
     */
    private $options;

    public function __construct(APIInfofichService $apiInfofichService) {
        $this->apiInfofichService = $apiInfofichService;

        $this->planes = array();
        $this->carreras = array();
        $this->asignaturas = array();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->options = $options;
        $this->planificacion = $builder->getData();

        //Bandera que indica si se esta creando(id es null) o editando la planificacion:
        $this->creandoPlanificacion = $this->planificacion->getId() === null;

        $this->addCarrera($builder, $options);
        $this->addAsignatura($builder, $options);
        $this->addAniAcad($builder, $options);

        $builder->add('codigoSiu', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Código SIU',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        ));

        $builder->add('plan', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Plan de estudio',
            'disabled' => true,
            'attr' => array('class' => 'form-control'),
                //'data' => 2006
        ));

        $builder->add('caracter', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Caracter',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        ));

        $builder->add('cargaHoraria', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Carga horaria total',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        ));

        $contenidos_min_config = array(
            'label' => 'Contenidos mínimos',
            'required' => false,
            'attr' => array(
                'rows' => 8,
                'placeholder' => 'Si esta creando una nueva planificación debe completar este campo',
                'class' => 'form-control'
            )
        );

        $builder->add('contenidosMinimos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', $contenidos_min_config);

        $builder->add('departamento', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
            'label' => 'Departamento',
            'class' => 'PlanificacionesBundle\Entity\Departamento',
            'attr' => array(
                'class' => 'form-control js-select2'
            )
        ));

        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
            'label' => 'Limpiar campos',
            'attr' => array('class' => 'btn btn-secondary')
        ));


        $this->setEventosForm($builder);
    }

    /**
     * En esta funcion se setean todos los eventos del formulario
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    function setEventosForm(FormBuilderInterface $builder) {
        
        
        $listenerPreSubmitEvent = function (FormEvent $event) {
            $form_data = $event->getData();
            //dump($form_data, $event->getForm()->getData());exit;            

            $this->setAsignaturas($form_data['carrera']);

            if (isset($this->asignaturas[$form_data['asignatura']])) {
                $asignatura = $this->asignaturas[$form_data['asignatura']];
                $this->planificacion->setAsignatura($asignatura->getCodigoMateria());
            }
        };

        $listenerSubmitEvent = function (FormEvent $event) {

            //Setear los campos plan y versionPlan en funcion de la carrera elegida.
            $cod_carrera = $this->planificacion->getCarrera();
            $carrera = $this->apiInfofichService->getCarrera($cod_carrera);
            $this->planificacion->setPlan($carrera->getPlanCarrera());
            $this->planificacion->setVersionPlan($carrera->getVersionPlan());

//            $formData = $event->getData();
//            dump($formData, $this->planificacion);
//            exit;
            //$this->setAsignaturas($cod_carrera);
        };


        $builder->addEventListener(FormEvents::PRE_SUBMIT, $listenerPreSubmitEvent);
        //$builder->addEventListener(FormEvents::PRE_SET_DATA, $listenerPreSetDataEvent);
        $builder->addEventListener(FormEvents::SUBMIT, $listenerSubmitEvent);
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
                'onchange' => 'actualizarAsignaturas(this);', //este evento se dispara cuando el usuario selecciona una carrera
                'data-planes-carrera' => json_encode($this->planes)), //esto es para obtener la informacion del plan para el campo "Plan Estudio"
        );

        if (!$this->planificacion->getCarrera()) {
            $config['data'] = $this->options['carrera_default'];
        }


        $builder->add('carrera', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', $config);
    }

    /**
     * 
     * @param FormBuilderInterface $builder
     */
    private function addAsignatura(FormBuilderInterface $builder) {


        $this->setAsignaturas($this->planificacion->getCarrera());
        //dump($this->asignaturas);exit;

        $config = array(
            'label' => 'Asignatura',
            //'mapped' => false,
            'choices' => $this->asignaturas, // esto se carga por JS
            'attr' => array('class' => 'form-control select-asignatura selectpicker js-select2')
        );

        $builder->add('asignatura', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', $config);


        $transform = function($v) {
            //dump($v);exit;
        };
        $reverseTransform = function($v) {
            return isset($this->asignaturas[$v]) ? $this->asignaturas[$v] : $v;
        };
       // $builder->get('asignatura')->addViewTransformer(new CallbackTransformer($transform, $reverseTransform));
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

        if ($this->creandoPlanificacion) {
            //En modo edicion solo puede elegir entre el año actual y el siguiente

            $y = date('Y');
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
        }

        $builder->add('anioAcad', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Planificacion',
            'carrera_default' => WSHelper::CARRERA_II
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_planificacion';
    }

    public function getCarreras() {

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

    public function setAsignaturas($cod_carrera) {

        $asignaturas = $this->apiInfofichService
                ->getAsignaturasPorCarrera($cod_carrera ?: $this->options['carrera_default']);

        $this->asignaturas = array();
        
        if (!is_array($asignaturas)) {            
            return;
        }
        
        foreach ($asignaturas as $a) {
            $this->asignaturas[$a->getCodigoMateria()] = $a;
        }
        
    }

}
