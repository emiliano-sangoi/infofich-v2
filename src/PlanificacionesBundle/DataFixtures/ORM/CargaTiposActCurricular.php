<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\TipoActividadCurricular;

class CargaTiposActCurricular extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        
        foreach (TipoActividadCurricular::getTipos() as $cod => $desc){
            $ac = new TipoActividadCurricular();
            $ac->setCodigo($cod);
            $ac->setDescripcion($desc);
            $manager->persist($ac);
        }
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
