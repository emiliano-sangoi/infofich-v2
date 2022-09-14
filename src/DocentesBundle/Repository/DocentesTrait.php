<?php

namespace DocentesBundle\Repository;

use AppBundle\Entity\Persona;
use DocentesBundle\Entity\DocenteAdscripto;
use DocentesBundle\Entity\DocenteGrado;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Serializer\Exception\Exception;

/**
 *
 * @author emi88
 */
trait DocentesTrait {
    
    public function findByPersona(Persona $persona){
        if(__CLASS__ == DocenteAdscriptoRepository::class){
            $entity = DocenteAdscripto::class;
        }else{
            $entity = DocenteGrado::class;
        }               
        
        $dql = "SELECT d FROM $entity d JOIN AppBundle:Persona p WHERE p.id = :id";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(':id', $persona->getId());
        
        try{
            $result = $query->getSingleResult();
            return $result;
        } catch (Exception $ex) {
            
        } catch (NonUniqueResultException $ex) {
            
        } catch (NoResultException $ex) {

        }        
        
        return null;        
    }
    
}
