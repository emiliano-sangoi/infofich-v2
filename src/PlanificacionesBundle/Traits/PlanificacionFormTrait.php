<?php

namespace PlanificacionesBundle\Traits;

use PlanificacionesBundle\Entity\Asignatura;
use PlanificacionesBundle\Entity\Carrera;
use PlanificacionesBundle\Repository\AsignaturaRepository;
use PlanificacionesBundle\Repository\CarreraRepository;
use FICH\APIRectorado\Config\WSHelper;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

trait PlanificacionFormTrait
{

    private function addCarrera(FormBuilderInterface $builder, array $options, $field = 'carrera') {

        $config = array(
            'label' => 'Carrera',
            'class' => Carrera::class,
            'required' => $options['required'] ?? true,
            'mapped' => $options['mapped'] ?? true,
            'data' => $options['data'] ?? null,
            'disabled' => $options['disabled'] ?? false,
            'attr' => $options['attr'] ?? array('class' => 'form-control select-carrera js-select2'),
            'query_builder' => function (CarreraRepository $cr) {
                $qb = $cr->createQueryBuilder('c');
                $qb->where($qb->expr()->eq('c.estado', ':estado'))
                    ->andWhere($qb->expr()->in('c.codigoCarrera', ':carrerasPlanificacion'))
                    ->orderBy('c.nombreCarrera', 'ASC');
                $qb->setParameter(':estado', 'V');
                $qb->setParameter(':carrerasPlanificacion', Carrera::$carrerasPlanificacion);
                return $qb;
            },
            'constraints' => array(
                new NotBlank(array('message' => "El campo Carrera es obligatorio."))
            )
        );

        $builder->add($field, EntityType::class, $config);
    }


    /**
     *
     * @param FormBuilderInterface $builder
     */
    private function addAsignatura($builder, array $options, $field_name = 'asignatura') {

        $config = array(
            'label' => 'Asignatura',
            'class' => Asignatura::class,
            'required' => $options['required'] ?? true,
            'mapped' => $options['mapped'] ?? true,
            'data' => $options['data'] ?? null,
            'disabled' => $options['disabled'] ?? false,
            'attr' => $options['attr'] ?? array('class' => 'form-control'),
//            'query_builder' => function (AsignaturaRepository $ar) use ($carrera) {
//                $qb = $ar->createQueryBuilder('a')
//                    ->orderBy('a.periodoCursada', 'ASC');
//
//                if($carrera){
//                    $qb->where($qb->expr()->eq('a.carrera', ':carrera'));
//                    $qb->setParameter(':carrera', $carrera);
//                }
//
//                return $qb;
//            },
            /*'group_by' => function($choiceValue, $key, $value) {
                switch ($choiceValue->getAnioCursada()){
                    case 1:
                        return '1er año';
                    case 2:
                        return '2do año';
                    case 3:
                        return '3er año';
                    case 4:
                        return '4to año';
                    case 5:
                        return '5to año';
                    default:
                        return 'Optativas y Electivas';
                }
            },*/
            'constraints' => array(
                new NotBlank(array('message' => 'El campo Asignatura es obligatorio.'))
            )
        );

        $builder->add($field_name, EntityType::class, $config);
    }

}
