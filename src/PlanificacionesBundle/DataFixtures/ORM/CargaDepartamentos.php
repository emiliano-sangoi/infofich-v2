<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\Docente;

class CargaDepartamentos extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    private $departamentos = array(
        'Agrimensura y cartografia',
        'Estructuras',
        'Formación Básica',
        'Formación Complementaria',
        'Hidráulica',
        'Hidrología',
        'Informática',
        'Medio Ambiente',
    );

    public function load(ObjectManager $manager) {

        foreach ($this->departamentos as $dpto) {
            $d = new PlanificacionesBundle\Entity\Departamento();
            $d->setNombre($dpto);
            
            $manager->persist($d);
        }

        $manager->flush();
    }

    public function getOrder() {
        return 1;
    }

}

?>
