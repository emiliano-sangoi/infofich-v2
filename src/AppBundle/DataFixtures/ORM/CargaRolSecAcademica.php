<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Rol;
use AppBundle\Repository\PermisoRepository;
use AppBundle\Seguridad\Permisos;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Crea el rol de secretaria academica y asigna los permisos correspondientes.
 * 
 */
class CargaRolSecAcademica extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $rol = new Rol();
        $rol->setNombre(Rol::ROLE_SEC_ACADEMICA);
        $rol->setTitulo('Rol secretaría académica.');
        $rol->setDescripcion('Rol asignado a los integrantes de la oficina de Secretaría Académica de la FICH. Posee los permisos para crear,modificar o borrar planificaciones de grado.');

        $manager->persist($rol);
        $manager->flush();


        //Cargar permisos ...

        /* @var $repoPermiso PermisoRepository */
        $repoPermiso = $manager->getRepository('AppBundle:Permiso');


        $permisos = array(
            Permisos::PLANIF_LISTAR,
            Permisos::PLANIF_VER,
            Permisos::PLANIF_CREAR,
            Permisos::PLANIF_EDITAR,
            Permisos::PLANIF_BORRAR,
            Permisos::PLANIF_CORRECCIONES,
            Permisos::PLANIF_ENVIAR_CORRECCION,
            Permisos::PLANIF_ENVIAR_REVISION,
        );

        foreach ($permisos as $codigo) {
            $permiso = $repoPermiso->findOneByCodigo($codigo);
            $rol->addPermiso($permiso);
        }


        $manager->flush();
    }

    public function getOrder() {
        return 2;
    }

}

?>
