<?php

namespace AppBundle\Form;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

//use Symfony\Component\Form\Extension\Core\Type\TextType

class LoginType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
       

        $user_opt = array(
            'min' => Usuario::USERNAME_MIN_LENGTH,
            'max' => Usuario::USERNAME_MAX_LENGTH,
            'minMessage' => "El nombre de usuario debe tener al menos {{ limit }} caracteres.",
            'maxMessage' => "El nombre de usuario puede tener a lo sumo {{ limit }} caracteres."
        );
        
        $builder->add('username', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
            'label' => 'Usuario',
            'required' => false,
            'attr' => array('class' => 'form-control'),
            'error_bubbling' => true,
            'constraints' => array(
                new NotBlank(array('message' => 'El nombre de usuario no puede quedar vacio.')),
                new Length($user_opt),
            )
        ));


        $pwd_opt = array(
            'min' => Usuario::PLAIN_PWD_MIN_LENGTH,
            'max' => Usuario::PLAIN_PWD_MAX_LENGTH,
            'minMessage' => "La contraseña debe tener al menos {{ limit }} caracteres.",
            'maxMessage' => "La contraseña puede tener a lo sumo {{ limit }} caracteres."
        );
        
        $builder->add('password', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, array(
            'label' => 'Contraseña',
            'required' => false,
            'error_bubbling' => true,
            'attr' => array('class' => 'form-control'),
            'constraints' => array(                
                new NotBlank(array('message' => 'El campo contraseña es obligatorio.')),
                new Length($pwd_opt),
            )
        ));


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }

}
