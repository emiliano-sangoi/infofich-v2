<?php

namespace PlanificacionesBundle\Form;

use AppBundle\Service\APIInfofichService;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

/**
 * Description of DuplicarPlanificacionType
 *
 * @author emi88
 */
class DuplicarPlanificacionType extends AbstractType {
    
    /**
     *
     * @var APIInfofichService 
     */
    private $apiInfofichService;

    /**
     *
     * @var array
     */
    private $options;
    
    /**
     * 
     * @var Planificacion
     */
    private $planificacion;
    
    public function __construct(APIInfofichService $apiInfofichService) {

        $this->apiInfofichService = $apiInfofichService;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $this->options = $options;
        $this->planificacion = $options['planificacion_original'];

        $this->addCarrera($builder);
        $this->addAsignaturas($builder);
        $this->addAniAcad($builder);
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
            'data' => $this->planificacion->getCarrera(),
            'required' => true,
            'attr' => array('class' => 'form-control select-carrera'),
            'label_attr' => array('class' => 'font-weight-bold')
        );

        $builder->add('carrera', ChoiceType::class, $config);
    }
    
    /**
     * 
     * @param FormBuilderInterface $builder
     */
    private function addAsignaturas(FormBuilderInterface $builder, $cod_carrera = null) {

        $asignaturas = $this->getAsignaturas($cod_carrera);
        
        $config = array(
            'label' => 'Asignatura',
            'choices' => $asignaturas,
            'required' => false,
            'attr' => array('class' => 'form-control select-asignatura'),
            'label_attr' => array('class' => 'font-weight-bold')
        );

        $builder->add('codigoAsignatura', ChoiceType::class, $config);
        
        //Esto permite desactivar el error "Este valor no es valido" que surge cuando 
        //se intenta setear la asignatura en un listado que todavia no se actualizo.x
        $builder->get('codigoAsignatura')->resetViewTransformers();
        // https://stackoverflow.com/questions/27706719/disable-backend-validation-for-choice-field-in-symfony-2-type
    }

    /**
     * Agrega el campo año academico
     * 
     * @param FormBuilderInterface $builder
     */
    private function addAniAcad(FormBuilderInterface $builder) {

        $config = array(
            'label' => 'Año académico: ',
            'label_attr' => array('class' => 'font-weight-bold'),
            'attr' => array('class' => 'form-control js-select2'),
        );

        if ($this->planificacion && $this->planificacion->getId() == null) {
            //En modo edicion solo puede elegir entre el año actual y el siguiente
            $y = date('Y');
        } else {
            $y = $this->planificacion->getAnioAcad();
        }

        $choices = array(
            $y + 1 => $y + 1,
            $y + 2 => $y + 2,
            $y + 3 => $y + 3,
        );

        $config['choices'] = $choices;

        $config['constraints'] = array(
            new Choice(array(
                'choices' => $choices,
                'message' => 'Las opciones posibles son ' . implode(' y ', $choices)
                    ))
        );

        $builder->add('anioAcad', ChoiceType::class, $config);
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

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null,
            'planificacion_original' => null,
            'carrera_default' => null,
            'attr' => array('class' => '')
        ));
    }

}
