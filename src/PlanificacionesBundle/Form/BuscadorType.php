<?php

namespace PlanificacionesBundle\Form;

use AppBundle\Form\DatalistType;
use Doctrine\ORM\EntityManager;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Traits\PlanificacionFormTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuscadorType extends AbstractType {

    use PlanificacionFormTrait;

    /**
     *
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $this->agregarCarrera($builder, $options);
        $this->agregarAsignatura($builder);
        $this->addEstado($builder, [
            'required' => false,
        ]);
        $this->addAniAcad($builder);

    }

    private function agregarCarrera(FormBuilderInterface $builder)
    {

        $data = $builder->getData();

        $field_opt = [
            'mapped' => false,
            'required' => false,
            'disabled' => false,
        ];

        $field_opt['data'] = $data['carrera'] ?? null;

        $this->addCarrera($builder, $field_opt);
    }

    private function agregarAsignatura(FormBuilderInterface $builder)
    {
        $data = $builder->getData();

        $field_opt = [
            'mapped' => false,
            'required' => false,
            'disabled' => false,
        ];

        $field_opt['data'] = $data['asignatura'] ?? null;

        $this->addAsignatura($builder, $field_opt);

    }

    /**
     * Agrega el campo año academico
     *
     * @param FormBuilderInterface $builder
     */
    private function addAniAcad(FormBuilderInterface $builder) {

        $config = array(
            'label' => 'Año académico',
            'required' => false,
            'choices' => range(2020, date('Y') + 2),
            'attr' => array('class' => 'form-control', 'placeholder' => 'Todos los años')
        );

        $builder->add('anioAcad', DatalistType::class, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null,
            'carrera_default' => null,
            'method' => 'GET',
            'csrf_protection' => false
        ));
    }


}
