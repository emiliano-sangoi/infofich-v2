<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


/**
 * Description of RecuperarPasswordType
 *
 * @author emi88
 */
class RecuperarPasswordType extends AbstractType {

    
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('username', TextType::class, array(
            'attr' => array('class' => 'form-control', 'autocomplete' => 'off'),
            'label' => 'Nombre de usuario: ',
            'label_attr' => array(
                'class' => 'align-middle font-weight-bold'
            )
        ));


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null,     
            'attr' => array(
                'class' => ''
            )
        ));
    }
}
