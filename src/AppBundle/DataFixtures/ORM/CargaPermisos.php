<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Permiso;
use AppBundle\Entity\Rol;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\Planificacion;
use AppBundle\Repository\RolRepository;


class CargaPermisos extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
        

        $this->cargarPermisosPlanificacion($manager);
        
    }
    
    private function cargarPermisosPlanificacion(ObjectManager $manager){       
        
        $permiso = new Permiso();
        $permiso->setTitulo('Permite listar las planificaciones.');
        $permiso->setDescripcion('Dependeniendo del ROL, se listaran todas las planificaciones o solo algunas.');
        $permiso->setCodigo(Planificacion::PERMISO_LISTAR);                
        
        $permiso2 = new Permiso();
        $permiso2->setTitulo('Permite crear una planificacion.');
        $permiso2->setCodigo(Planificacion::PERMISO_CREAR);
        
        $permiso3 = new Permiso();
        $permiso3->setTitulo('Permite modficar una planificacion.');
        $permiso3->setCodigo(Planificacion::PERMISO_EDITAR);
        
        $permiso4 = new Permiso();
        $permiso4->setTitulo('Permite borrar una planificacion.');
        $permiso4->setCodigo(Planificacion::PERMISO_BORRAR);
        
        $permiso5 = new Permiso();
        $permiso5->setTitulo('Permite ver una planificacion.');
        $permiso5->setCodigo(Planificacion::PERMISO_VER);
        
        
        /* @var $repoRol RolRepository */
        $repoRol = $manager->getRepository('AppBundle:Rol');
        /* @var $rol Rol */
        $rolSA = $repoRol->findOneByNombre(Rol::ROLE_SEC_ACADEMICA);
        
       // dump($rol);exit;
        
        $rolSA->addPermiso($permiso);
        $rolSA->addPermiso($permiso2);
        $rolSA->addPermiso($permiso3);
        $rolSA->addPermiso($permiso4);
        $rolSA->addPermiso($permiso5);   
        
        
        //Rol docente:
        /* @var $rolDocente Rol */
        $rolDocente = $repoRol->findOneByNombre(Rol::ROLE_DOCENTE_GRADO);
        $rolDocente->addPermiso($permiso);
        $rolDocente->addPermiso($permiso5);
        
        $manager->flush();        
    }

    
    public function getOrder() {
        return 2;
    }

}

?>
