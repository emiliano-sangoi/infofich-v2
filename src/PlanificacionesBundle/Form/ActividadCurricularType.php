<?php

namespace PlanificacionesBundle\Form;

use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Repository\TemarioRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ActividadCurricularType extends AbstractType {

    /**
     *
     * @var Planificacion 
     */
    private $planificacion;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        // dump($builder->getForm()->getParent()->getData());exit;
        $this->planificacion = $options['planificacion'];
        
        //dump($options);exit;

        $this->addTemario($builder, $options);
        $this->addTipoActividadCurricular($builder, $options);
        $this->addFecha($builder, $options);
        //$this->addOtras($builder, $options);
        $this->addCargaHorariaAula($builder, $options);
        $this->addCargaHorariaAutonomo($builder, $options);
        $this->addDescripcion($builder, $options);
        //$this->addContenido($builder, $options);
        
        $builder->add('posicion', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
            'attr' => array(
                'class' => 'posicion',
            )
        ));
        
    }

    private function addTipoActividadCurricular(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => 'Tipo de Clase',
            'class' => 'PlanificacionesBundle\Entity\TipoActividadCurricular',
            'attr' => array(
                'class' => 'form-control js-select2'
            )
        );

        $builder->add('tipoActividadCurricular', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', $config);
    }

    private function addTemario(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => 'Seleccione la unidad',
            'attr' => array('class' => 'form-control js-select2'),
            'class' => 'PlanificacionesBundle:Temario',
            'query_builder' => function(TemarioRepository $tr) {
                //dump($tr);exit;
                $qb = $tr->createQueryBuilder('t');
                $condicion = $qb->expr()->eq('t.planificacion', $this->planificacion->getId());
                $qb->where($condicion);
                return $qb;
            },
            //'expanded' => true,
            'required' => true,
        );

        //'Symfony\Component\Form\Extension\Core\Type\ChoiceType'
        $builder->add('temario', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', $config);
    }

    private function addFecha(FormBuilderInterface $builder, array $options) {
        $config = array(
            'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA', 'autocomplete' => 'off'),
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'error_bubbling' => false,
            'label' => 'Fecha',
            'label_attr' => array(
                'class' => 'font-weight-bold requerido',
                'title' => 'Este campo es obligatorio.')
        );

        $builder->add('fecha', "Symfony\Component\Form\Extension\Core\Type\DateType", $config);
    }

    private function addOtras(FormBuilderInterface $builder, array $options) {
        $config = array(
            'label' => 'Otras',
            'required' => false,
            'attr' => array(
                'rows' => 3,
                'class' => 'form-control',
                'autocomplete' => 'off'
            )
        );

        $builder->add('otras', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', $config);
    }

    private function addCargaHorariaAula(FormBuilderInterface $builder, array $options) {
        $config = array(
            'label' => 'Carga horaria en aula',
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'autocomplete' => 'off'
            )
        );

        $builder->add('cargaHorariaAula', 'Symfony\Component\Form\Extension\Core\Type\NumberType', $config);
    }

    private function addCargaHorariaAutonomo(FormBuilderInterface $builder, array $options) {
        $config = array(
            'label' => 'Horas de estudio autónomo',
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'autocomplete' => 'off'
            )
        );

        $builder->add('cargaHorariaAutonomo', 'Symfony\Component\Form\Extension\Core\Type\NumberType', $config);
    }

    private function addContenido(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => 'Contenidos',
            'attr' => array(
                'rows' => 3,
                'class' => 'form-control',
                'autocomplete' => 'off'
            ),            
            'required' => false,
        );


        $builder->add('contenido', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', $config);
    }

    private function addDescripcion(FormBuilderInterface $builder, array $options) {
        $config = array(
            'label' => 'Descripción',
            'required' => true,
            'attr' => array(
                'rows' => 5,
                'class' => 'form-control',
                'autocomplete' => 'off',
                'placeholder' => 'Describa brevemente la mediación pedagógica que utilizará en la clase.  Por ejemplo: seminario, taller, resolución de problemas, aprendizaje basado en problemas, aprendizaje basado en proyectos, cuestionario, foro, aula invertida, juego de roles, experimentos, ejercicios, salida de campo, manejo de instrumental, etc.'
            )
        );


        $builder->add('descripcion', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\ActividadCurricular',
            'planificacion' => null,
            'error_bubbling' => null
//            'format_label' => function($a){
//                //dump($a);exit;
//                return 'lala';
//            }
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_actividadcurricular';
    }

}
