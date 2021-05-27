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

    private $permisos;

    public function load(ObjectManager $manager) {

        $this->cargarPermisos($manager);

        foreach ($this->permisos as $cod => $perm) {

            $permiso = new Permiso();
            $permiso->setTitulo($perm['titulo']);
            $permiso->setDescripcion($perm['desc']);
            $permiso->setCodigo($cod);
            
            $manager->persist($permiso);
        }
        
        $manager->flush();
    }

    private function cargarPermisos(ObjectManager $manager) {
        
        $this->permisos[ Planificacion::PERMISO_LISTAR ] = array(
            'titulo' => 'Permite listar las planificaciones.',
            'desc' => 'Dependeniendo del ROL, se listaran todas las planificaciones o solo algunas.',
        );
        
        $this->permisos[ Planificacion::PERMISO_CREAR ] = array(
            'titulo' => 'Permite crear una planificacion.',
            'desc' => null,
        );
        
        $this->permisos[ Planificacion::PERMISO_EDITAR ] = array(
            'titulo' => 'Permite modficar una planificacion.',
            'desc' => null,
        );
        
        $this->permisos[ Planificacion::PERMISO_BORRAR ] = array(
            'titulo' => 'Permite borrar una planificacion.',
            'desc' => null,
        );
        
        $this->permisos[ Planificacion::PERMISO_VER ] = array(
            'titulo' => 'Permite ver una planificacion.',
            'desc' => null,
        );


        // Agregar aca todos los permisos existentes ...
    }
    
    

    public function getOrder() {
        return 2;
    }

}

?>
