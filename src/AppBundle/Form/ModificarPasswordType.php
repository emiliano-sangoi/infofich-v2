<?php

namespace AppBundle\Form;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Description of ModificarPasswordType
 *
 * @author emi88
 */
class ModificarPasswordType extends AbstractType
{


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('stringRecupPwd', TextType::class, array(
            'attr' => array(
                'class' => 'form-control',
                'autocomplete' => 'off',
                'placeholder' => 'Código recibido por correo electrónico'),
            'label' => 'Código de verificación: ',
            'label_attr' => array(
                'class' => 'align-middle font-weight-bold'
            )
        ));

        $pwd_constraints = array(
            new NotBlank(array(
                'message' => 'Debe ingresar un valor.'
            )),
            new Length(array(
                'min' => Usuario::PLAIN_PWD_MIN_LENGTH,
                'max' => Usuario::PLAIN_PWD_MAX_LENGTH,
                'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres.',
                'maxMessage' => 'La contraseña puede tener a lo sumo {{ limit }} caracteres.',
            )),
        );

        $builder->add('password', PasswordType::class, array(
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Nueva contraseña',
            'autocomplete' => 'off'),
            'label' => 'Nueva contraseña: ',
            'label_attr' => array(
                'class' => 'align-middle font-weight-bold'
            ),
            'constraints' => $pwd_constraints
        ));

        $builder->add('password2', PasswordType::class, array(
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Repetir nueva contraseña',
                'autocomplete' => 'off'),
            'label' => 'Repetir nueva contraseña: ',
            'label_attr' => array(
                'class' => 'align-middle font-weight-bold'
            ),
            'constraints' => $pwd_constraints
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        ));
    }
}
