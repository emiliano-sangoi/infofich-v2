<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Rol;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class CargaRoles extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {        

        $rol = new Rol();
        $rol->setNombre(Rol::ROLE_ADMIN);
        $rol->setTitulo('Administrador del Sistema');
        $rol->setDescripcion('Administrador del Sistema. Posee control sobre todos los aspectos del sistema.');

        $rol2 = new Rol();
        $rol2->setNombre(Rol::ROLE_USUARIO);
        $rol2->setTitulo('Rol asignado a todos los usuarios de la FICH.');
        $rol2->setDescripcion('Rol por defecto que poseen todos los usuarios de la Facultad. Sin este rol es imposible acceder al sistema.');

        $manager->persist($rol);
        $manager->persist($rol2);
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
