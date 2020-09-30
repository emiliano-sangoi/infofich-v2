<?php

namespace PlanificacionesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BibliografiaPlanificacionType extends AbstractType {

    /**
     *
     * @var \Doctrine\ORM\EntityManager 
     */
    private $em;

    /**
     *
     * @var PlanificacionesBundle\Repository\TipoBibliografiaRepository 
     */
    private $repoTipos;

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
        $this->repoTipos = $this->em->getRepository('PlanificacionesBundle:TipoBibliografia');
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        //Armar el constructor con todos los campos

        $builder->add('bibliografia', 'PlanificacionesBundle\Form\BibliografiaType', array(
            'label' => false,
            'required' => true,
        ));
        
        $builder->add('posicion', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
            'attr' => array(
                'class' => 'posicion',
            )
        ));


        $this->addTipo($builder, $options);
    }

    public function addTipo(FormBuilderInterface $builder, array $options) {

        $tipoInicial = $this->repoTipos->findOneBy(array(
            'codigo' => \PlanificacionesBundle\Entity\TipoBibliografia::BASICA
        ));

        $builder->add('tipoBibliografia', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
            'label' => false,
            'class' => 'PlanificacionesBundle:TipoBibliografia',
            'choice_label' => 'nombre',
            'expanded' => true,
            'data' => $tipoInicial,
            'required' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\BibliografiaPlanificacion'
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_bibliografiaplanificacion';
    }

}
