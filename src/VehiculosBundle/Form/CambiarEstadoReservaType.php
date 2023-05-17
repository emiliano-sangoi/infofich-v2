<?php

namespace VehiculosBundle\Form;


use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Entity\Reserva;
use VehiculosBundle\Entity\EstadoReserva;
use VehiculosBundle\Entity\HistoricoEstadosReserva;
use DocentesBundle\Entity\DocenteGrado;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

/**
 * Description of CambiarEstadoReservaType
 *
 * @author romi88
 */
class CambiarEstadoReservaType extends AbstractType {
    

    /**
     *
     * @var array
     */
    private $options;
    
    /**
     * 
     * @var Reserva
     */
    private $reserva;
    

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $this->options = $options;
        $this->reserva = $options['reserva_original'];

      //  $this->addEstados($builder);
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null,
            'reserva_original' => null,
            //'carrera_default' => null,
            'attr' => array('class' => '')
        ));
    }
    
   
}
