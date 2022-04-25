<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Description of RecuperarPasswordType
 *
 * @author emi88
 */
class RecuperarPasswordType extends AbstractType {
    
    use PersonaTypeTrait;
    
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->addEmail($builder, $options, true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null,     
            'attr' => array(
                'class' => 'form-inline'
            )
        ));
    }
}
