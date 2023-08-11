<?php

namespace VehiculosBundle\Repository;

/**
 * ReservaRepository
 *
 */
class ReservaRepository extends \Doctrine\ORM\EntityRepository
{

    public function verificarDisponibilidadFechas($historicos, $fechaInicioReserva, $fechaFinReserva)
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.historicos', 'h')
            ->andWhere('h IN (:historicos)')
            ->andWhere(':fechaInicioReserva <= r.fechaFin')
            ->andWhere(':fechaFinReserva >= r.fechainicio')
            ->setParameter('historicos', $historicos)
            ->setParameter('fechaInicioReserva', $fechaInicioReserva)
            ->setParameter('fechaFinReserva', $fechaFinReserva)
            ->getQuery()
            ->getResult();
    }
}
