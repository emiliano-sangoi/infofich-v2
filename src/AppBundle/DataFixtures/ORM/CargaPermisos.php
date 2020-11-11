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
        
        //$manager->persist($permiso);
        
        $permiso2 = new Permiso();
        $permiso2->setTitulo('Permite crear una planificacion.');
        $permiso2->setCodigo(Planificacion::PERMISO_CREAR);
        
       // $manager->persist($permiso2);
        
        $permiso3 = new Permiso();
        $permiso3->setTitulo('Permite modficar una planificacion.');
        $permiso3->setCodigo(Planificacion::PERMISO_EDITAR);
        
      //  $manager->persist($permiso3);
        
        $permiso4 = new Permiso();
        $permiso4->setTitulo('Permite borrar una planificacion.');
        $permiso4->setCodigo(Planificacion::PERMISO_BORRAR);
        
     //   $manager->persist($permiso4);
        
        $permiso5 = new Permiso();
        $permiso5->setTitulo('Permite ver una planificacion.');
        $permiso5->setCodigo(Planificacion::PERMISO_VER);
        
      //  $manager->persist($permiso5);
        
      //  $manager->flush(); 
        
        /* @var $repoRol RolRepository */
        $repoRol = $manager->getRepository('AppBundle:Rol');
        /* @var $rol Rol */
        $rol = $repoRol->findOneByNombre(Rol::ROLE_ADMIN_PLANIF_GRADO);
        
       // dump($rol);exit;
        
        $rol->addPermiso($permiso);
        $rol->addPermiso($permiso2);
        $rol->addPermiso($permiso3);
        $rol->addPermiso($permiso4);
        $rol->addPermiso($permiso5);   
        
        //dump($rol);exit;
        
        $manager->flush();        
    }

    
    public function getOrder() {
        return 2;
    }

}

?>
