<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteAdscriptoPlanificacionType extends DocentePlanificacionType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        //dump($builder->getData());exit;
//          $planificacion = $options['planificacion'];
//        if($planificacion instanceof \PlanificacionesBundle\Entity\Planificacion){
//             $builder->get('nomape')->setData( $planificacion->getDocenteResponsable()->getDocente()->getNroLegajo());
//        }
        
        $builder->add('resolucion', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Resolución de consejo directivo',
            'attr' => array('class' => 'form-control')
        ));
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\DocenteAdscriptoPlanificacion',
            'planificacion' => null
        ));
    }
    
        /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_doc_adscripto_planif';
    }


}
