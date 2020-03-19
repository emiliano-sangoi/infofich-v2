<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\TipoMovilidad;

class TiposMovilidad extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $tipo = new TipoMovilidad();
        $tipo->setNombre(TipoMovilidad::AUTO);
        $manager->persist($tipo);
        
        $tipo = new TipoMovilidad();
        $tipo->setNombre(TipoMovilidad::COLECTIVO);
        $manager->persist($tipo);
        
        $tipo = new TipoMovilidad();
        $tipo->setNombre(TipoMovilidad::AVION);
        $manager->persist($tipo);
        
        $tipo = new TipoMovilidad();
        $tipo->setNombre(TipoMovilidad::BARCO);
        $manager->persist($tipo);
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
