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
 * Crea el rol de docente de grado y asigna todos los permisos correspondientes.
 * 
 */
class CargaRolDocenteGrado extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        
        $rol = new Rol();
        $rol->setNombre(Rol::ROLE_DOCENTE_GRADO);
        $rol->setTitulo('Rol docentes grado');
        $rol->setDescripcion('Rol asignado a los docentes de grado de la FICH. No contempla docentes adscriptos.');
        
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
