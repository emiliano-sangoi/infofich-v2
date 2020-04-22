<?php

namespace PlanificacionesBundle\Form;

use AppBundle\Service\APIInfofichService;
use FICH\APIRectorado\Config\WSHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanificacionType extends AbstractType {

    /**
     *
     * @var APIInfofichService 
     */
    private $apiInfofichService;
    
    private $planes;

    public function __construct(APIInfofichService $apiInfofichService) {
        $this->apiInfofichService = $apiInfofichService;
        
        $this->planes = array();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        //$carreraDefault = $this->apiInfofichService->getCarrera($options['carrera_default']);
        
        $carreras =  $this->getCarreras();
        $builder->add('carrera', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Carrera',
            'mapped' => false,
            'choices' => $carreras,
            'attr' => array('class' => 'form-control select-carrera', 
                'onchange' => 'actualizarAsignaturas(this);', //este evento se dispara cuando el usuario selecciona una carrera
                'data-planes-carrera' => json_encode($this->planes)), //esto es para obtener la informacion del plan para el campo "Plan Estudio"
            'data' => $options['carrera_default']
        ));
        
        
        
        $builder->add('asignatura', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Asignatura',
            'mapped' => false,
            'choices' => array(), // esto se carga por JS
            'label_attr' => array('class' => 'control-label') ,
            'attr' => array('class' => 'form-control select-asignatura selectpicker js-select2')
        ));                         
        
        $builder->add('anioAcad', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Año académico',
            'choices' => array(date('Y'), date('Y') + 1),
            'attr' => array('class' => 'form-control')
        ));
        
        $builder->add('codigoSiu', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Código SIU',
            'mapped' => false,            
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        )); 
        
        $builder->add('planEstudio', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Plan de Estudio',
            'mapped' => false,            
            'attr' => array('class' => 'form-control disabled', 'disabled' => 'disabled')
        )); 

        $builder->add('contenidosMinimos', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
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
                ->add('cargaHoraria')
                ->add('requisitosAprobacion');
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
    
    public function getCarreras(){
        
        //obtiene las carreras de grado de la fich:
        $carreras_fich = $this->apiInfofichService->getCarreras();
        
        //dump($carreras_fich);exit;
        
        if(!$carreras_fich){
            return array();
        }
        
        $aux = $this->planes = array();
        foreach ( $carreras_fich as $carrera){
            $aux[ $carrera->getCodigoCarrera() ] = $carrera;
            $this->planes[ $carrera->getCodigoCarrera() ] = $carrera->getPlanCarrera();
            
        }
        
        return $aux;        
    }
    
     public function getPlanes($carreras){
         
         
     }
    
    
    public function getAsignaturas($carrera){
        
        $asignaturas = $this->apiInfofichService->getAsignaturasPorCarrera($carrera);
        
        if(!is_array($asignaturas)){
            return array();
        }
                
        return $asignaturas;
    }

}
