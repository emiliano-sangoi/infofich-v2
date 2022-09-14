<?php

namespace PlanificacionesBundle\Repository;

use AppBundle\Entity\Rol;
use AppBundle\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use PlanificacionesBundle\Entity\Planificacion;

/**
 * PlanificacionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlanificacionRepository extends EntityRepository {


    /**
     * Funcion que devuelve las planificaciones que un usuario puede ver/editar o modificar (siempre y cuando tenga permiso)
     *
     * Los usuarios que no son admin o no tienen el rol de SA solo pueden trabajar sobre un conjunto
     * de planificaciones.
     * Ese conjunto se determina en funcion de si la persona asociada al docente figura como responsable,
     * colaborador o adscripto.
     *
     *
     *
     * @param Usuario $usuario
     * @param type $carrera
     * @param type $codigoAsignatura
     * @param type $anioAcad
     * @return Query|array
     */
    public function getPlanificacionesUsuario(Usuario $usuario, $carrera = null, $codigoAsignatura = null, $anioAcad = null, $estadoActual = null, $nroModulo = null, $recursantes = null) {

        $em = $this->getEntityManager();

        /* @var $qb QueryBuilder */
        $qb = $em->getRepository(Planificacion::class)->createQueryBuilder('p');

        if ($anioAcad) {
            $qb->andWhere($qb->expr()->eq('p.anioAcad', ':anioAcad'));
            $qb->setParameter(':anioAcad', $anioAcad);
        }

        if ($carrera) {
            $qb->andWhere($qb->expr()->eq('p.carrera', ':carrera'));
            $qb->setParameter(':carrera', $carrera);
        }

        if ($codigoAsignatura) {
            $qb->andWhere($qb->expr()->eq('p.codigoAsignatura', ':codigoAsignatura'));
            $qb->setParameter(':codigoAsignatura', $codigoAsignatura);

            if($nroModulo) {
                $qb->andWhere($qb->expr()->eq('p.nroModulo', ':nroModulo'));
                $qb->setParameter(':nroModulo', $nroModulo);
            }else{
                $qb->andWhere($qb->expr()->isNull('p.nroModulo'));
            }
            
            if($recursantes){
                $qb->andWhere($qb->expr()->eq('p.recursantes', ':recursantes'));
                $qb->setParameter(':recursantes', recursantes);
            }else{
                $qb->andWhere($qb->expr()->isNull('p.recursantes'));
            }
        }

        if ($estadoActual) {
            $qb->join('p.historicosEstado', 'h');
            $qb->join('h.estado', 'e');
            $qb->andWhere($qb->expr()->eq('e.id', ':idEstadoActual'));
            $qb->andWhere($qb->expr()->isNull('h.fechaHasta'));
            $qb->setParameter(':idEstadoActual', $estadoActual);
        }

        $qb->orderBy('p.fechaCreacion', 'DESC');
        $qb->orderBy('p.ultimaModif', 'DESC');

        if (!$usuario->tieneRol(Rol::ROLE_ADMIN) && !$usuario->tieneRol(Rol::ROLE_SEC_ACADEMICA)) {
            $result = array();
            //============================================================================
            //FILTRAR PLANIFICACIONES PROPIAS
            //si no es el admin se deben filtrar las planifificaciones a mostrar.
            //como criterio, a un usuario se les van a mostrar aquellas planif. que
            //lo tengan como owner u aquellas en las que figure como docente responsable.

            $it = $qb->getQuery()->iterate();

            foreach ($it as $row) {

                $planif = $row[0];
                if ($planif->inEquipoDocente($usuario->getPersona()) || $planif->getOwner() == $usuario) {
                    $result[] = $planif;
                }
            }
        } else {
            $result = $qb->getQuery();
        }

        //dump($result->getResult());exit;

        return $result;
    }

}
