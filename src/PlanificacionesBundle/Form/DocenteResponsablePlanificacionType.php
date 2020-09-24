<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteResponsablePlanificacionType extends DocentePlanificacionType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //dump($builder->getData(), $options['planificacion']);exit;
        parent::buildForm($builder, $options);   
        
        //$builder->get()
        
//        $planificacion = $options['planificacion'];
//        if($planificacion instanceof \PlanificacionesBundle\Entity\Planificacion){
//             $builder->get('nomape')->setData( $planificacion->getDocenteResponsable()->getDocente()->getNroLegajo());
//        }
//       
        
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\DocenteResponsablePlanificacion',
            'planificacion' => null,
            //'inherit_data' => true,
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planificacionesbundle_doc_resp_planif';
    }

}
