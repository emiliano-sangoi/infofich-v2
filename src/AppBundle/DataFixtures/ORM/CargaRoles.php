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
        $rol2->setNombre(Rol::ROLE_SEC_ACADEMICA);
        $rol2->setTitulo('Rol asignado a los integrantes de la oficina de Secretaría Académica de la FICH.');
        $rol2->setDescripcion('Posee los permisos para crear,modificar o borrar planificaciones de grado.');
        
        $rol3 = new Rol();
        $rol3->setNombre(Rol::ROLE_DOCENTE_GRADO);
        $rol3->setTitulo('Rol asignado a docentes de grado de la FICH.');
        $rol3->setDescripcion('Posee los permisos para crear,modificar o borrar planificaciones de grado.');
        
        $rol4 = new Rol();
        $rol4->setNombre(Rol::ROLE_USUARIO);
        $rol4->setTitulo('Rol asignado a todos los usuarios de la FICH.');
        $rol4->setDescripcion('Rol por defecto que poseen todos los usuarios de la Facultad. Sin este rol es imposible acceder al sistema.');
//        
//        $rol2 = new Rol();
//        $rol2->setNombre(Rol::ROLE_DOCENTE_GRADO);
//        $rol2->setTitulo('Docente de Grado');
//        $rol2->setDescripcion('Docente de alguna de.');
       
        $manager->persist($rol);
        $manager->persist($rol2);
        $manager->persist($rol3);
        $manager->persist($rol4);
        
        $manager->flush();
        
    }

    public function getOrder() {
        return 1;
    }

}

?>
