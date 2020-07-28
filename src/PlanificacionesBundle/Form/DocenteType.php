<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomape', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Nombre y apellido',
            'mapped' => false,
            'required' => false,
            'choices' => $this->getDocentes(),
            'attr' => array('class' => 'form-control js-select2')
        ));
        
        
        $builder->add('nroDni', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'DNI',
            'mapped' => false,
            'attr' => array('class' => 'form-control nro-dni', 'disabled' => 'disabled')
        ));
        
        $builder->add('telefono', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
            'label' => 'Teléfono',
            'mapped' => false,
            'attr' => array('class' => 'form-control telefono', 'disabled' => 'disabled')
        ));
        
        $builder->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
            'label' => 'Correo electrónico',
            'mapped' => false,
            'attr' => array('class' => 'form-control email', 'disabled' => 'disabled')
        ));
    }
    
    public function getDocentes(){
        
        $q = new \FICH\APIInfofich\Query\Docentes\QueryDocentes();        
        $docentes = $q->setCacheEnabled(true)
                ->getDocentes();

        return $docentes;                        
    }




    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Docente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planificacionesbundle_docente';
    }


}
