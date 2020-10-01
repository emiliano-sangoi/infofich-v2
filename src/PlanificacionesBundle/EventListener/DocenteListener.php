<?php

namespace PlanificacionesBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Exception;
use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use FICH\APIRectorado\Config\WSHelper;
use PlanificacionesBundle\Entity\Docente;
use PlanificacionesBundle\Util\Util;

/**
 * Description of PersonaListener
 *
 * @author emi88
 */
class DocenteListener {

    public function prePersist(LifecycleEventArgs $args) {

        $entity = $args->getObject();

        if (!$entity instanceof Docente) {
            return;
        }

        $legajo = $entity->getNroLegajo();

        $q = new QueryDocentes();
        $docentes = $q->setCacheEnabled(true)
                ->getDocentes();

        $docente = isset($docentes[$legajo]) ? $docentes[$legajo] : null;

        if (!$docente) {
            dump("no deberias estar aqui");
            exit;
        }



        //dump($entity, $docente, $legajo, $docentes);exit;

        

        $em = $args->getObjectManager();
        $persona = $em->getRepository('AppBundle:Persona')->findOneBy(array(
            'documento' => $docente->getNumeroDocumento(),
            //'tipoDocumento' => $cod_tipo_doc
        ));
        
        if($persona){
            //la persona ya existe
            
            // se actualiza mail, cuil y telefono
            
            //TODO: el cuil no se esta actualizando:
            //$persona->setCuil($docente->getCuil());
            
            //dump($entity, $docente->getCuil(), $persona);exit;            
            
            //setear/pisar el email del docente:
            $entity->setEmail($docente->getEmail() ?: null);
                        
        }else{
            //la persona no esta en la BD, se inserta.
            
            $persona = Util::extraerPersonaFromDocente($docente); 
            //$em->persist($persona);
        }
        
        //guardo la persona en el docente (PlanifiacionesBundle\Entity\Docente):
        $entity->setPersona( $persona );                        
        
    }

    /**
     * Busca una persona en la base de datos.
     * 
     * @param EntityManager $em
     * @param string $tipo_doc Tipo de documento como string: DNI, LC, LE, etc.
     * @param string $nro_doc  Numero de documento.
     * @return null|AppBundle\Entity\Persona
     * @throws Exception
     * 
     * @deprecated Se deshabilito la busqueda utilizando tipo de doc. Hay diferencias entre el dato devuelto en el WS y el existente en la base de datos.
     */
    private function buscarPersona(EntityManager $em, $tipo_doc, $nro_doc) {

        // dump($em,$nro_doc,$tipo_doc);exit;
        //el tipo de doc viene como DNI, LE, etc. se obtienen el codigo necesario con:
        $cod_tipo_doc = WSHelper::getCodigoTipoDocPorDesc($tipo_doc);

        if (is_null($cod_tipo_doc)) {
            throw new Exception("No se encontro el código correcto para el tipo de documento: $nro_doc");
        }
        
        //dump($nro_doc, $cod_tipo_doc);exit;

        $persona = $em->getRepository('AppBundle:Persona')->findOneBy(array(
            'documento' => $nro_doc,
            //'tipoDocumento' => $cod_tipo_doc
        ));


        return $persona;
    }

}
