<?php

namespace DocentesBundle\Form;

use AppBundle\Form\PersonaTypeTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuscarAdscriptoType extends AbstractType {

    use PersonaTypeTrait;
    use DocenteAdscriptoTrait;
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
                
        $this->addTipoDocumento($builder, $options);
        $this->addDocumento($builder, $options);
        $this->addResolucion($builder, $options, false);
        
    }

    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null,
            'method' => 'GET',
            'csrf_protection' => false
        ));
    }
    
}
