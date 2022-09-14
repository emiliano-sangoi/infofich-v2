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
 * Description of CambiarEstadoPlanificacionType
 *
 * @author romi88
 */
class CambiarEstadoPlanificacionType extends AbstractType {
    

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
    

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $this->options = $options;
        $this->planificacion = $options['planificacion_original'];

      //  $this->addEstados($builder);
        
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
