<?php

namespace PlanificacionesBundle\Repository;

use AppBundle\Entity\Usuario;
use DateTime;
use Doctrine\ORM\EntityRepository;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\HistoricoEstados;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Component\Serializer\Exception\Exception;

/**
 * HistoricoEstadosRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HistoricoEstadosRepository extends EntityRepository {

    public function setEstadoNueva(Planificacion $planificacion, Usuario $usuario) {

        $em = $this->getEntityManager();
        $estado = $em->getRepository(Estado::class)->findOneBy(array(
            'codigo' => Estado::CREADA
        ));

        if (!$estado instanceof Estado) {
            return false;
        }

        $h = new HistoricoEstados();
        $h->setEstado($estado);

        $fecha = new \DateTime;
        $h->setFechaDesde($fecha);
        $h->setFechaHasta($fecha);

        $h->setPlanificacion($planificacion);
        $h->setUsuario($usuario);

        $em->persist($h);
        $em->flush();

        return true;
    }

    /**
     * Se encarga de especificar un estado a una planificacion existente.
     * 
     * @param Planificacion $planificacion
     * @param integer $cod_estado
     * @param Usuario $usuario
     * @param string|null $comentario
     * @return boolean
     * @throws Exception
     */
    public function asignarEstado(Planificacion $planificacion, $cod_estado, Usuario $usuario, $comentario = null) {

        $em = $this->getEntityManager();

        $repoEstados = $em->getRepository(Estado::class);
        $estado = $repoEstados->findOneBy(array(
            'codigo' => $cod_estado
        ));

        if (!$estado instanceof Estado) {
            return false;
        }

        $res = false;

        $em->beginTransaction();
        try {

            //buscar estado actual:
            $hea = $planificacion->getHistoricoEstadoActual();

            //si es distinto de creado se setea la fecha hasta y se guarda el cambio
            if ($hea && $hea->getEstado() && $hea->getEstado()->getCodigo() !== Estado::CREADA) {
                $hea->setFechaHasta(new DateTime());
                $em->flush();
            }

            //nuevo estado:
            $hn = new HistoricoEstados();
            $hn->setPlanificacion($planificacion);
            $hn->setEstado($estado);
            $hn->setUsuario($usuario);
            $hn->setComentario($comentario);
            
            //modificar fecha de actualizacion:
            $planificacion->setUltimaModif(new \DateTime());

            //guardar nuevo registro
            $em->persist($hn);
            $em->flush();

            $em->commit();

            $res = true;
        } catch (Exception $ex) {
            $em->rollback();
            throw $ex;
        }

        return $res;
    }

}
