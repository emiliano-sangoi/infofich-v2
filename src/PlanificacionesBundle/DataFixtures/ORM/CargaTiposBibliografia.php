<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\TipoBibliografia;

class CargaTiposBibliografia extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $tipo1 = new TipoBibliografia();
        $tipo1->setNombre(TipoBibliografia::BASICA);
        $tipo1->setDescripcion('Bibliografia principal de la asignatura.');
        
        
        $tipo2 = new TipoBibliografia();
        $tipo2->setNombre(TipoBibliografia::COMPLEMENTARIA);
        $tipo2->setDescripcion('Bibliografia complementaria a la bibliografía básica.');                
        
        $manager->persist($tipo1);
        $manager->persist($tipo2);
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
