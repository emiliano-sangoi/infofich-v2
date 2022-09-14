<?php

namespace PlanificacionesBundle\EventListener;

use AppBundle\Service\APIInfofichService;
use AppBundle\Service\InfofichViejoService;
use AppBundle\Util\Texto;
use DateTime;
use Doctrine\ORM\Event\LifecycleEventArgs;
use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use PlanificacionesBundle\Entity\Docente;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Util\Util;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of PlanificacionListener
 *
 * @author emi88
 */
class PlanificacionListener {

    public function prePersist(LifecycleEventArgs $args) {
         
        $entity = $args->getObject();

        if ($entity instanceof Docente) {
            $this->prePersistDocente($args);
        } else if ($entity instanceof Planificacion) {
            $this->prePersistPlanificacion($args);
        }
    }

    public function preUpdate(LifecycleEventArgs $args) {

        $entity = $args->getObject();

        if ($entity instanceof Docente) {
            $this->preUpdateDocente($args);
        } else if ($entity instanceof Planificacion) {
            $this->preUpdatePlanificacion($args);
        }
    }

    public function prePersistPlanificacion(LifecycleEventArgs $args) {
        $this->actualizarPlanif($args);
    }
    
    public function preUpdatePlanificacion(LifecycleEventArgs $args) {        
        $this->actualizarPlanif($args);
    }

    public function prePersistDocente(LifecycleEventArgs $args) {
        $this->setPersonaDocente($args);        
    }
    
    public function preUpdateDocente(LifecycleEventArgs $args) {
        $this->setPersonaDocente($args);        
    }
    
    
    
    public function setPersonaDocente(LifecycleEventArgs $args) {
        $entity = $args->getObject();
        $legajo = $entity->getNroLegajo();               

        $q = new QueryDocentes();
        $docentes = $q->setCacheEnabled(true)
                ->setWsEnv(WSHelper::ENV_PROD)
                >setEscalafon(QueryDocentes::ESCALAFON_DOCENTES)
                ->setEstado('activo')
                ->getDocentes();

        $docente = isset($docentes[$legajo]) ? $docentes[$legajo] : null;

        if (!$docente) {
            dump("no deberias estar aqui");
            exit;
        }

        $em = $args->getObjectManager();
        $persona = $em->getRepository('AppBundle:Persona')->findOneBy(array(
            'documento' => $docente->getNumeroDocumento(),
                //'tipoDocumento' => $cod_tipo_doc
        ));

        if ($persona) {
            //la persona ya existe
            // se actualiza mail, cuil y telefono
            //TODO: el cuil no se esta actualizando:
            //$persona->setCuil($docente->getCuil());
            //dump($entity, $docente->getCuil(), $persona);exit;            
            //setear/pisar el email del docente:
            $entity->setEmail($docente->getEmail() ?: null);
            //$entity->setNroLegajo($docente->getNumeroLegajo());
        } else {
            //la persona no esta en la BD, se inserta.

            $persona = Util::extraerPersonaFromDocente($docente);
            //$em->persist($persona);
        }

        //guardo la persona en el docente (PlanifiacionesBundle\Entity\Docente):
        $entity->setPersona($persona);
    }

    /**
     * Setea el campo nombreAsignatura de la planficacion automaticamente
     * 
     * @param Planificacion $planificacion
     */
    private function actualizarPlanif(LifecycleEventArgs $args) {

        $planificacion = $args->getObject();
        
        $planificacion->setUltimaModif(new DateTime);

//        $asignatura = $this->infofichService->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
//        $nombreAsignatura = Texto::ucWordsCustom($asignatura->getNombreMateria());
//        $planificacion->setNombreAsignatura($nombreAsignatura);
    }

}
