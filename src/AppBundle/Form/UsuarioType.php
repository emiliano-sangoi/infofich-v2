<?php

namespace AppBundle\Form;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Rol;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsuarioType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('username', TextType::class, array(
            'attr' => array('class' => 'form-control', 'autocomplete' => 'off'),
            'label' => 'Nombre de usuario',
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));

        $builder->add('bloqueado', ChoiceType::class, array(
            'choices' => array(
                'Si' => true,
                'No' => false
            ),
            'choices_as_values' => true,
            'expanded' => true,
            'label_attr' => array(
                'class' => 'font-weight-bold',
                //'required' => false
            ),
            'label' => '¿Bloqueado?'
        ));


        $args = array(
            'attr' => array('class' => 'form-control', 'autocomplete' => false),
            'label' => 'Contraseña',
            'mapped' => false,
            'required' => false,
            'label_attr' => array(
                'class' => 'font-weight-bold'
            ),
            'constraints' => array(                
                new Length(array(
                    'min' => Usuario::PLAIN_PWD_MIN_LENGTH,
                    'max' => Usuario::PLAIN_PWD_MAX_LENGTH,
                    'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres.',
                    'maxMessage' => 'La contraseña puede tener a lo sumo {{ limit }} caracteres.',
                )),
            )
        );
        
        if(!$builder->getData()->getId()){
            // si no hay id seteado signifa que se esta dando de alta un usuario, 
            // en este caso se debe validar que la contraseña no este vacia
            $args['constraints'][] = new NotBlank(array('message' => 'El campo contraseña es obligatorio.'));            
        }
        
        $builder->add('plainPassword', PasswordType::class, $args);


        $builder->add('roles', EntityType::class, array(
            'class' => Rol::class,
            'multiple' => true,
            'expanded' => true,
            'choice_label' => 'titulo',
            'attr' => array('class' => 'form-control select2-js'),
            'label_attr' => array(
                'class' => 'font-weight-bold'
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Usuario::class,
        ));
    }

}
