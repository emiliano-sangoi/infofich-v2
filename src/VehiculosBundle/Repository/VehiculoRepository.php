<?php

namespace VehiculosBundle\Repository;
use Proxies\__CG__\VehiculosBundle\Entity\Vehiculo;
use VehiculosBundle\Entity\ReservaVehiculos;

/**
 * VehiculoRepository
 *
 */
class VehiculoRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Busca todas las reservas en las que figura el vehiculo.
     *
     * @param Vehiculo $vehiculo
     * @return array
     */
    public function getReservasVehiculo(Vehiculo $vehiculo){

        $repo = $this->getEntityManager()->getRepository(ReservaVehiculos::class);

        $qb = $repo->createQueryBuilder('rv');
        $qb->select('rv');
        $qb->join('rv.reserva', 'r');
        $qb->join('rv.vehiculo', 'v');
        $qb->where($qb->expr()->eq('v.id', ':v_id'));
        $qb->setParameter(':v_id', $vehiculo->getId());

        return $qb->getQuery()->getResult();

    }
}

