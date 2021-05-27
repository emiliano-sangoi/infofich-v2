<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Rol;
use AppBundle\Repository\PermisoRepository;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\Planificacion;

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
            Planificacion::PERMISO_LISTAR,
            Planificacion::PERMISO_VER,
            Planificacion::PERMISO_EDITAR,
            Planificacion::PERMISO_BORRAR,
            Planificacion::PERMISO_CREAR
        );
        
        foreach ($permisos as $codigo){
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
