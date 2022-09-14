<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType {

    use PersonaTypeTrait;
    
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('id', \Symfony\Component\Form\Extension\Core\Type\HiddenType::class, array(
            //'mapped' => false
        ));

        $this->addTipoDocumento($builder, $options);
        $this->addDocumento($builder, $options);
        $this->addApellidos($builder, $options);
        $this->addNombres($builder, $options);
        $this->addFechaNacimiento($builder, $options);
        $this->addGenero($builder, $options, true);
        $this->addTelefono($builder, $options);
        $this->addEmail($builder, $options, true);
      
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => \AppBundle\Entity\Persona::class
        ));
    }

}
