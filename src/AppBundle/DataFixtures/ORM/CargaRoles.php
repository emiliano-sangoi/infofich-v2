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
        $rol->setNombre('ROL_ADMIN');
        $rol->setCodigo(Rol::ADMIN);
        $rol->setTitulo('Administrador del Sistema');
        $rol->setDescripcion('Administrador del Sistema. Posee control sobre todos los aspectos del sistema.');
        
        $rol2 = new Rol();
        $rol2->setNombre('ROL_SEC_ACAD');
        $rol2->setCodigo(Rol::SEC_ACAD);
        $rol2->setTitulo('Secretaría Académica');
        $rol2->setDescripcion('Los usuarios con este rol pertenecen a la Secretaría Académica de la Facultad.');
       
        $manager->persist($rol);
        $manager->persist($rol2);
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
