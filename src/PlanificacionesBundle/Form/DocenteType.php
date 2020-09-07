<?php

namespace PlanificacionesBundle\Form;

use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('persona', 'PlanificacionesBundle\Form\PersonaType', array(
            
            
//            'label' => 'Nombre y apellido',
//            'mapped' => false,
//            'required' => false,
//            'choices' => $this->getDocentes(),
//            'attr' => array('class' => 'form-control js-select2')
        ));
        
        
//        $builder->add('nomape', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
//            'label' => 'Nombre y apellido',
//            'mapped' => false,
//            'required' => false,
//            'choices' => $this->getDocentes(),
//            'attr' => array('class' => 'form-control js-select2')
//        ));
//        
//        
//        $builder->add('nroLegajo', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
//            'attr' => array('class' => '')
//        ));
//        
//        $builder->add('telefono', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
//            'label' => 'Teléfono',
//            'mapped' => false,
//            'attr' => array('class' => 'form-control telefono', 'disabled' => 'disabled')
//        ));
//        
//        $builder->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
//            'label' => 'Correo electrónico',
//            'mapped' => false,
//            'attr' => array('class' => 'form-control email', 'disabled' => 'disabled')
//        ));
        
        $f = function(){
            
            // obtener 
            
        };
        
        //TODO: se debe buscar e instanciar una persona
//        $builder->get('nomape')->addEventListener(
//            FormEvents::SUBMIT,
//            function (FormEvent $event) {                
//                $pos = $event->getData();
//                $docentes = $this->getDocentes();
//                //$docente = $docentes[ $pos ];
//                
//                
//                
//                //$dataForm = $event->getForm()->getData();
//                
//                
//                dump($pos, $docentes);exit;
//
////                $formModifier($event->getForm(), $data->getSport());
//            }
//        );
//        
//        $builder->addEventListener(
//            FormEvents::SUBMIT,
//            array($this, 'onSubmitData')            
//        );
        
    }
    
    public function onSubmitData(FormEvent $event){
//        function () {                
                $sport = $event->getForm()->getData();
                $pos = $event->getData();
                $docentes = $this->getDocentes();
                
                
                //Buscar si existe la persona
                
                
                
                
                
                
                
                
                //$docente = $docentes[ $pos ];
                
                
                
                //$dataForm = $event->getForm()->getData();
                
                
                dump($pos, $sport);exit;

//                $formModifier($event->getForm(), $data->getSport());
//            }
        
    }

        public function getDocentes(){
        
        $q = new QueryDocentes();        
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
