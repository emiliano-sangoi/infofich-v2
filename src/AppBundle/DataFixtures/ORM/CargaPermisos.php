<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Permiso;
use AppBundle\Seguridad\Permisos;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\Planificacion;

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
        
        // LISTAR =========================================================================
        
        $this->permisos[Permisos::PLANIF_LISTAR ] = array(
            'titulo' => 'Permite listar las planificaciones.',
            'desc' => 'Dependeniendo del ROL, se listaran todas las planificaciones o solo algunas.',
        );
        
        $this->permisos[ Permisos::PLANIF_CREAR ] = array(
            'titulo' => 'Permite crear una planificacion.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PLANIF_EDITAR ] = array(
            'titulo' => 'Permite modificar una planificacion.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PLANIF_BORRAR ] = array(
            'titulo' => 'Permite borrar una planificacion.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PLANIF_VER ] = array(
            'titulo' => 'Permite ver una planificacion.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PLANIF_ENVIAR_REVISION ] = array(
            'titulo' => 'Permite enviar la planificacion a revisión.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PLANIF_ENVIAR_CORRECCION ] = array(
            'titulo' => 'Permite enviar la planificacion a corrección.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PLANIF_CORRECCIONES ] = array(
            'titulo' => 'Permite gestionar las correcciones de una planificación',
            'desc' => 'Permite gestionar las correcciones sugeridas por SA en una planificación.',            
        );
        
        // USUARIOS =========================================================================
        
        $this->permisos[ Permisos::USUARIO_LISTAR ] = array(
            'titulo' => 'Permite ver todos los usuarios existentes.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::USUARIO_CREAR ] = array(
            'titulo' => 'Crea un usuario.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::USUARIO_EDITAR ] = array(
            'titulo' => 'Editar un usuario.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::USUARIO_VER ] = array(
            'titulo' => 'Ver datos del usuario.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::USUARIO_BORRAR ] = array(
            'titulo' => 'Borrar o baja logica del usuario.',
            'desc' => null,
        );
        
        // ROLES =========================================================================
        
        $this->permisos[ Permisos::ROL_BORRAR ] = array(
            'titulo' => 'Baja de rol.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::ROL_LISTAR ] = array(
            'titulo' => 'Consultar y/o buscar roles existentes.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::ROL_EDITAR ] = array(
            'titulo' => 'Modificar datos de un rol.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::ROL_CREAR ] = array(
            'titulo' => 'Alta de nuevo rol.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::ROL_VER ] = array(
            'titulo' => 'Consultar informacion de un rol.',
            'desc' => null,
        );
        
        // PERMISOS =========================================================================

        $this->permisos[ Permisos::PERMISO_BORRAR ] = array(
            'titulo' => 'Baja de permiso.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PERMISO_LISTAR ] = array(
            'titulo' => 'Consultar y/o buscar permisos existentes.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PERMISO_EDITAR ] = array(
            'titulo' => 'Modificar datos de un permiso.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PERMISO_CREAR ] = array(
            'titulo' => 'Alta de nuevo permiso.',
            'desc' => null,
        );
        
        $this->permisos[ Permisos::PERMISO_VER ] = array(
            'titulo' => 'Consultar informacion de un permiso.',
            'desc' => null,
        );

        // Agregar aca todos los permisos existentes ...
    }
    
    

    public function getOrder() {
        return 1;
    }

}

?>
