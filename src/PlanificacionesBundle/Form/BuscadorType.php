<?php

namespace PlanificacionesBundle\Form;

use AppBundle\Service\APIInfofichService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuscadorType extends AbstractType {

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
    
    public function __construct(APIInfofichService $apiInfofichService) {

        $this->apiInfofichService = $apiInfofichService;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->options = $options;

        $this->addCarrera($builder);
        $this->addAsignaturas($builder);
        $this->addAniAcad($builder);

        $builder->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', array(
            'label' => 'Buscar',
            'attr' => array('class' => 'btn btn-success text-color-white')
        ));

//        $builder->add('reset', 'Symfony\Component\Form\Extension\Core\Type\ResetType', array(
//            'label' => 'Limpiar filtros',
//            'attr' => array('class' => 'btn btn-secondary')
//        ));
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
            'required' => false,
            'data' => $this->options['carrera_default'],
            'attr' => array('class' => 'form-control select-carrera js-select2')
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
            'attr' => array('class' => 'form-control select-asignatura')
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
            'label' => 'Año académico',
            'required' => false,
            'choices' => range(2020, date('Y') + 2),
            'attr' => array('class' => 'form-control')
        );

        $builder->add('anioAcad', 'AppBundle\Form\DatalistType', $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null,
            'carrera_default' => null,
            'method' => 'GET',
            'csrf_protection' => false
        ));
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
