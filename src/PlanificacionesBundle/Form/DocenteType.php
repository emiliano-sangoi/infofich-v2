<?php

namespace PlanificacionesBundle\Form;

use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteType extends AbstractType {    


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('persona', 'PlanificacionesBundle\Form\PersonaType', array(
//            'label' => 'Nombre y apellido',
            
            //IMPORTANTE. 
            //Este campo no debe estar mapeado al campo de la base de datos ya que se debe aplicar cierta logica a la persona.
            //Si la persona existe se busca y actualiza
            //caso contrario se inserta.
            'mapped' => false,
//            'required' => false,
//            'choices' => $this->getDocentes(),
//            'attr' => array('class' => 'form-control js-select2')
        ));

        $builder->add('nroLegajo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Nombre y apellido',
            //'mapped' => false,
            'required' => true,
            'choices' => $this->getDocentes(),
            'attr' => array('class' => 'form-control js-select2')
        ));




    }

    public function getDocentes() {

        $q = new QueryDocentes();
        $docentes = $q->setCacheEnabled(true)
                ->getDocentes();

        return $docentes;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Docente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_docente';
    }

}
