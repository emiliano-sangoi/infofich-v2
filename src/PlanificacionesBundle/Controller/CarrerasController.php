<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Asignatura;
use PlanificacionesBundle\Entity\Carrera;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class CarrerasController extends Controller
{
    public function getAsignaturasAction(Carrera $carrera)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Asignatura::class)->createQueryBuilder('a');
        $qb->where($qb->expr()->eq('a.carrera', ':carrera'));
        $qb->setParameter(':carrera', $carrera);
        $qb->orderBy('a.nombreAsignatura', 'ASC');

        $asignaturas = [];
        $it = $qb->getQuery()->iterate();
        foreach ($it as $row){
            $a = $row[0];
            $asignaturas[] = [
                'id' => $a->getId(),
                'text' => $a->getNombreAsignatura(),
            ];
        }

        return new JsonResponse($asignaturas);
    }

}
