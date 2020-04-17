<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\Vehiculo;

class CargaVehiculos extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $vehiculo = new Vehiculo();
        $vehiculo->setNombre(Vehiculo::AUTO);
        $manager->persist($vehiculo);
        
        $vehiculo = new Vehiculo();
        $vehiculo->setNombre(Vehiculo::COLECTIVO);
        $manager->persist($vehiculo);
        
        $vehiculo = new Vehiculo();
        $vehiculo->setNombre(Vehiculo::AVION);
        $manager->persist($vehiculo);
        
        $vehiculo = new Vehiculo();
        $vehiculo->setNombre(Vehiculo::BARCO);
        $manager->persist($vehiculo);
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
