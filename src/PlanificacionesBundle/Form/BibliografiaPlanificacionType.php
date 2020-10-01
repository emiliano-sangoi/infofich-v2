<?php

namespace PlanificacionesBundle\Form;

use Doctrine\ORM\EntityManager;
use PlanificacionesBundle\Entity\BibliografiaPlanificacion;
use PlanificacionesBundle\Entity\TipoBibliografia;
use PlanificacionesBundle\Repository\TipoBibliografiaRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BibliografiaPlanificacionType extends AbstractType {

    /**
     *
     * @var EntityManager 
     */
    private $em;

    /**
     *
     * @var TipoBibliografiaRepository 
     */
    private $repoTipos;

    public function __construct(EntityManager $em) {
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

        $config = array(
            'label' => false,
            'class' => 'PlanificacionesBundle:TipoBibliografia',
            'choice_label' => 'nombre',
            'expanded' => true,            
            'required' => true,
        );

//        $bp = $builder->getData();
//        dump($bp);exit;
//        if ($bp instanceof BibliografiaPlanificacion && is_null($bp->getTipoBibliografia())) {
//            $default = $this->repoTipos->findOneBy(array(
//                'codigo' => TipoBibliografia::BASICA
//            ));
//            
//            $config['data'] = $default;
//        }

        $builder->add('tipoBibliografia', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', $config);
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
