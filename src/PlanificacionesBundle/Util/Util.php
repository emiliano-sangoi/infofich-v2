<?php

namespace PlanificacionesBundle\Util;

/**
 * Description of Util
 *
 * @author emi88
 */
class Util {
    
    /**
     * Extrae los datos de la persona que viene en la informacion del docente.
     * 
     * @param \FICH\APIInfofich\Model\Docente $docente
     * @return \AppBundle\Entity\Persona
     */
    public static function extraerPersonaFromDocente(\FICH\APIInfofich\Model\Docente $docente){                
        
        $persona = new \AppBundle\Entity\Persona();
        $persona->setApellidos( ucwords( strtolower($docente->getApellido()) ) );
        $persona->setNombres( ucwords( strtolower($docente->getNombre()) ) );
        $persona->setTipoDocumento( $docente->getTipoDocumento() );
        $persona->setDocumento( $docente->getNumeroDocumento() );
        $persona->setEmail( $docente->getEmail() );
        $persona->setCuil( $docente->getCuil() );
        
        
        return $persona;
        
        // TODO: Hablar con rectorado para ver si se puede obtener el telefono:
        //$persona->setTelefono( "Te lo debo" );                
        
    }
    
    
    public static function actualizarDatosPersona(\AppBundle\Entity\Persona $persona, \FICH\APIInfofich\Model\Docente $docente){          
        
        if($docente->getCuil()){
            $persona->setCuil($docente->getCuil());
        }
        
        //if(!$persona->getEmail() || $persona->getEmail() != $docente->getEmail()){
        
        
        
    }
    
    
}
