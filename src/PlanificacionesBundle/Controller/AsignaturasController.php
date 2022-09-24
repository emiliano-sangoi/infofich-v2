<?php

namespace PlanificacionesBundle\Controller;

use PlanificacionesBundle\Entity\Asignatura;
use PlanificacionesBundle\Entity\Carrera;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AsignaturasController extends Controller
{

    public function getInfoAction(Asignatura $asignatura)
    {
        return new JsonResponse($asignatura);
    }

}
