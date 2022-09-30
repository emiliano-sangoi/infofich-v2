<?php

namespace PlanificacionesBundle\Form;

use PlanificacionesBundle\Entity\Asignatura;
use PlanificacionesBundle\Entity\Carrera;
use PlanificacionesBundle\Repository\AsignaturaRepository;
use PlanificacionesBundle\Repository\CarreraRepository;
use Exception;
use FICH\APIRectorado\Config\WSHelper;
use PlanificacionesBundle\Entity\Departamento;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;

class PlanificacionType extends AbstractType {

    private $planes;

    /**
     *
     * @var Planificacion
     */
    private $planif;

    /**
     *
     * @var array
     */
    private $options;

    /**
     *
     * @var integer
     */
    private $codEstadoActual;

    public function __construct() {
        $this->planes = array();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->options = $options;
        $this->planif = $builder->getData();

        $ea = $this->planif->getEstadoActual();
        if ($ea instanceof Estado) {
            $this->codEstadoActual = $ea->getCodigo();
        }

        $this->addCarrera($builder, $options);
        $this->addAniAcad($builder, $options);
        $this->addCodigoSIU($builder);

        $builder->add('plan', TextType::class, array(
            'label' => 'Plan de estudio',
            'disabled' => true,
            'attr' => array('class' => 'form-control info-asignatura')
        ));

        $builder->add('caracter', TextType::class, array(
            'label' => 'Caracter',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled info-asignatura', 'disabled' => 'disabled')
        ));

        $builder->add('cargaHoraria', TextType::class, array(
            'label' => 'Carga horaria total',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled info-asignatura', 'disabled' => 'disabled')
        ));

        $builder->add('periodoCursada', TextType::class, array(
            'label' => 'Periodo',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled info-asignatura', 'disabled' => 'disabled')
        ));

        $builder->add('anioCursada', TextType::class, array(
            'label' => 'Año cursada',
            'mapped' => false,
            'required' => false,
            'attr' => array('class' => 'form-control disabled info-asignatura', 'disabled' => 'disabled')
        ));

        $this->addContenidosMinimos($builder);
        $this->addDepartamento($builder);

        $this->addAsignatura($builder, $options['carrera_default']);
        $this->setEventosForm($builder, $options);
    }

    private function addDepartamento(FormBuilderInterface $builder) {

        $config = array(
            'label' => 'Departamento',
            'class' => Departamento::class,
            'required' => false,
            'choice_label' => function ($dpto) {
                return $dpto->getNombre();
            },
            'attr' => array(
                'class' => 'form-control',
            )
        );
        //Deshabilitar el campo cuando la planificación este publicada
        //En revision SA puede editarla
        if (in_array($this->codEstadoActual, [Estado::PUBLICADA])) {
            $config['disabled'] = true;
        }


        $builder->add('departamento', EntityType::class, $config);
    }

    private function addContenidosMinimos(FormBuilderInterface $builder) {

        $config = array(
            'label' => 'Contenidos mínimos',
            'required' => false,
            'attr' => array(
                'rows' => 8,
                'placeholder' => 'Este campo será completado por Secretaría Académica.',
                'class' => 'form-control disabled',
            )
        );

        //Deshabilitar el campo cuando la planificación este publicada
        //En revision SA puede editarla
        if (in_array($this->codEstadoActual, [Estado::PUBLICADA])) {
            $config['disabled'] = true;
        }

        $builder->add('contenidosMinimos', TextareaType::class, $config);
    }

    /**
     * En esta funcion se setean todos los eventos del formulario
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    function setEventosForm(FormBuilderInterface $builder) {


        $listenerPreSetDataEvent = function (FormEvent $event) {
            //dump($event->getData());exit;
       //     $p = $event->getData();
            //dump($p, $event->getForm());exit;
       //     $this->addAsignaturas2($event->getForm(), $p->getCarrera());

//            // setear el codigo de la carrera si este se encuentra definido
//            $p = $event->getData();
//            //dump($p != null && $p->getAsignatura());exit;
//            if($p != null && $p->getAsignatura()){
//                $event->getForm()->get('codigoSiu')->setData($p->getAsignatura());
//            }
        };

        $listenerPostSubmitEvent = function (FormEvent $event) {

            $carrera = $event->getForm()->getData();

            //$planif = $event->getForm()->getParent()->getData();
            //Setear los campos plan y versionPlan en funcion de la carrera elegida.
            if ($carrera) {
                //Agregar la asignautura:
                $this->addAsignatura($event->getForm()->getParent(), $carrera);
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
            'attr' => array('class' => 'form-control disabled info-asignatura', 'disabled' => 'disabled')
        ));
    }

    private function addCarrera(FormBuilderInterface $builder) {

        $config = array(
            'label' => 'Carrera',
            'class' => Carrera::class,
            'required' => true,
            'mapped' => false,
            'attr' => array('class' => 'form-control select-carrera js-select2'),
            'query_builder' => function (CarreraRepository $cr) {
                $qb = $cr->createQueryBuilder('c');
                $qb->where($qb->expr()->eq('c.estado', ':estado'))
                    ->andWhere($qb->expr()->in('c.codigoCarrera', ':carrerasPlanificacion'))
                    ->orderBy('c.nombreCarrera', 'ASC');
                $qb->setParameter(':estado', 'V');
                $qb->setParameter(':carrerasPlanificacion', Carrera::$carrerasPlanificacion);
                return $qb;
            },
            'constraints' => array(
                new NotBlank(array('message' => "El campo Carrera es obligatorio."))
            )
        );

        $p = $builder->getData();
        if ($p instanceof Planificacion && $p->getAsignatura() && $p->getAsignatura()->getCarrera()) {
            $config['data'] = $p->getAsignatura()->getCarrera();
        }else{
            $config['data'] = $this->options['carrera_default'];
        }

        //Deshabilitar el campo cuando la planificación este en r
        if (in_array($this->codEstadoActual, [Estado::REVISION, Estado::PUBLICADA])) {
            $config['disabled'] = true;
        }

        $builder->add('carrera', EntityType::class, $config);
    }



    /**
     *
     * @param FormBuilderInterface $builder
     */
    private function addAsignatura($builder, $carrera = null) {

        $config = array(
            'label' => 'Asignatura',
            'class' => Asignatura::class,
            'attr' => array('class' => 'form-control'),
            'query_builder' => function (AsignaturaRepository $ar) use ($carrera) {
                $qb = $ar->createQueryBuilder('a')
                    ->orderBy('a.periodoCursada', 'ASC');

                if($carrera){
                    $qb->where($qb->expr()->eq('a.carrera', ':carrera'));
                    $qb->setParameter(':carrera', $carrera);
                }

                return $qb;
            },
            /*'group_by' => function($choiceValue, $key, $value) {
                switch ($choiceValue->getAnioCursada()){
                    case 1:
                        return '1er año';
                    case 2:
                        return '2do año';
                    case 3:
                        return '3er año';
                    case 4:
                        return '4to año';
                    case 5:
                        return '5to año';
                    default:
                        return 'Optativas y Electivas';
                }
            },*/
            'constraints' => array(
                new NotBlank(array('message' => 'El campo Asignatura es obligatorio.'))
            )
        );

        //Deshabilitar el campo cuando la planificación este en r
        if (in_array($this->codEstadoActual, [Estado::REVISION, Estado::PUBLICADA])) {
            $config['disabled'] = true;
        }

        $p = $builder->getData();
        //dump($p->getAsignatura());exit;
        if($p->getAsignatura()){
            $config['data'] = $p->getAsignatura();
        }

        $builder->add('asignatura', EntityType::class, $config);
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

        //El año actual y el siguiente siempre deben aparecer como opciones en la lista

        $y = date('Y');
        $choices = array(
            $y => $y,
            $y + 1 => $y + 1
        );

        //si ademas la planif ya tiene un año seteado lo agrego al listado
        if ($this->planif && $this->planif->getAnioAcad()) {
            //En modo edicion solo puede elegir entre el año actual y el siguiente
            $choices[$this->planif->getAnioAcad()] = $this->planif->getAnioAcad();
        }

        $config['choices'] = $choices;

        $config['constraints'] = array(
            new Choice(array(
                'choices' => $choices,
                'message' => 'Las opciones posibles son ' . implode(' y ', $choices)
                    ))
        );

        //Deshabilitar el campo cuando la planificación este en r
        if (in_array($this->codEstadoActual, [Estado::REVISION, Estado::PUBLICADA])) {
            $config['disabled'] = true;
        }


        $builder->add('anioAcad', ChoiceType::class, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Planificacion::class,
            'carrera_default' => null,
            'deshabilitados' => array()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_planificacion';
    }

}
