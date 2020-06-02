<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\TipoActividadCurricular;

class CargaTiposActCurricular extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD1);
        $manager->persist($actividadCurricular);
        
        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD2);
        $manager->persist($actividadCurricular);
        
        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD3);
        $manager->persist($actividadCurricular);
        
        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD4);
        $manager->persist($actividadCurricular);
        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD5);
        $manager->persist($actividadCurricular);

        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD6);
        $manager->persist($actividadCurricular);

        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD7);
        $manager->persist($actividadCurricular);

        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD8);
        $manager->persist($actividadCurricular);

        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD9);
        $manager->persist($actividadCurricular);

        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD10);
        $manager->persist($actividadCurricular);

        $actividadCurricular = new TipoActividadCurricular();
        $actividadCurricular->setNombre(TipoActividadCurricular::ACTIVIDAD11);
        $manager->persist($actividadCurricular);

        
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
