<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\TipoDocente;

class CargaTiposDocentes {
//class CargaTiposDocentes extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $tipo1 = new TipoDocente();
        $tipo1->setNombre(TipoDocente::RESPONSABLE);
        $tipo1->setDescripcion('Docente responsable de la asignatura.');
        
        
        $tipo2 = new TipoDocente();
        $tipo2->setNombre(TipoDocente::COLABORADOR);
        $tipo2->setDescripcion('Docente colaborador/a de la asignatura.');
        
        $tipo3 = new TipoDocente();
        $tipo3->setNombre(TipoDocente::ADSCRIPTO);
        $tipo3->setDescripcion('Docente adscripto/a de la asignatura. Pueden ser docentes de otras facultades.');
        
        $manager->persist($tipo1);
        $manager->persist($tipo2);
        $manager->persist($tipo3);
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
