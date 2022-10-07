<?php

namespace PlanificacionesBundle\Traits;

use PlanificacionesBundle\Entity\Asignatura;
use PlanificacionesBundle\Entity\Carrera;
use PlanificacionesBundle\Repository\AsignaturaRepository;
use PlanificacionesBundle\Repository\CarreraRepository;
use FICH\APIRectorado\Config\WSHelper;
use PlanificacionesBundle\Entity\Estado;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

trait PlanificacionFormTrait
{

    private function addCarrera(FormBuilderInterface $builder, array $options, $field = 'carrera') {

        $config = array(
            'label' => $options['label'] ?? 'Carrera',
            'label_attr' => ['class' => 'font-weight-bold'],
            'class' => Carrera::class,
            'required' => $options['required'] ?? true,
            'mapped' => $options['mapped'] ?? true,
            'data' => $options['data'] ?? null,
            'disabled' => $options['disabled'] ?? false,
            'attr' => $options['attr'] ?? array('class' => 'form-control select-carrera'),
            'choice_label' => 'carreraPlan',
            'query_builder' => function (CarreraRepository $cr) {
                $qb = $cr->createQueryBuilder('c');
                $qb->where($qb->expr()->eq('c.estado', ':estado'))
                    ->andWhere($qb->expr()->in('c.codigoCarrera', ':carrerasPlanificacion'))
                    ->orderBy('c.nombreCarrera', 'ASC');
                $qb->setParameter(':estado', 'V');
                $qb->setParameter(':carrerasPlanificacion', Carrera::$carrerasPlanificacion);
                return $qb;
            }
        );

        if($config['required']){
            $config['constraints'] = array(
                new NotBlank(array('message' => 'Este campo es obligatorio.'))
            );
        }

        $builder->add($field, EntityType::class, $config);
    }


    /**
     *
     * @param FormBuilderInterface $builder
     */
    private function addAsignatura($builder, array $options, $field_name = 'asignatura') {

        $config = array(
            'label' => $options['label'] ?? 'Asignatura',
            'label_attr' => ['class' => 'font-weight-bold'],
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
        );

        if($config['required']){
            $config['constraints'] = array(
                new NotBlank(array('message' => 'Este campo es obligatorio.'))
            );
        }

        $builder->add($field_name, EntityType::class, $config);
    }

    private function addEstado(FormBuilderInterface $builder, array $field_opt, $field_name = 'estadoActual') {

        $config = array(
            'label' => $field_opt['label'] ?? 'Estado actual',
            'label_attr' => ['class' => 'font-weight-bold'],
            'class' => Estado::class,
            'required' => $field_opt['required'] ?? false,
            'disabled' => $field_opt['disabled'] ?? false,
            'data' => $field_opt['data'] ?? null,
            'placeholder' => $field_opt['placeholder'] ?? 'Todos',
            'attr' => array('class' => 'form-control')
        );


        $builder->add($field_name, EntityType::class, $config);

    }

}
