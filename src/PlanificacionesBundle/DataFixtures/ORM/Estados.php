<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\Estado;

class Estados extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        // cargar estados de la planificacion ...
        
        $e = new Estado();
        $e->setCodigo(Estado::PREPARACION);
        $e->setNombre(Estado::getNombrePorCod(Estado::PREPARACION));
        $e->setDescripcion(null);
        $manager->persist($e);
        
        $e = new Estado();
        $e->setCodigo(Estado::REVISION);
        $e->setNombre(Estado::getNombrePorCod(Estado::REVISION));
        $e->setDescripcion(null);
        $manager->persist($e);
        
        $e = new Estado();
        $e->setCodigo(Estado::CORRECCION);
        $e->setNombre(Estado::getNombrePorCod(Estado::CORRECCION));
        $e->setDescripcion(null);
        $manager->persist($e);
        
        $e = new Estado();
        $e->setCodigo(Estado::PUBLICADA);
        $e->setNombre(Estado::getNombrePorCod(Estado::PUBLICADA));
        $e->setDescripcion(null);
        $manager->persist($e);
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
