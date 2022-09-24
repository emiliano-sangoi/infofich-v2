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
        $asignaturas = $em->getRepository(Asignatura::class)->findBy([
            'carrera' => $carrera
        ]);

        return new JsonResponse($asignaturas);
    }

}
