<?php

namespace AppBundle\Seguridad;

/**
 * Listado de permisos existentes
 *
 * @author emi88
 */
class Permisos {
    //Planificaciones
    const PLANIF_LISTAR = 1;
    const PLANIF_CREAR = 2;
    const PLANIF_EDITAR = 3;
    const PLANIF_DUPLICAR = 21;
    const PLANIF_ENVIAR_REVISION = 22;
    const PLANIF_BORRAR = 4;
    const PLANIF_VER = 5;
    const PLANIF_CORRECCIONES = 23;
    
    //Usuarios
    const USUARIO_LISTAR = 6;
    const USUARIO_CREAR = 7;
    const USUARIO_EDITAR = 8;
    const USUARIO_BORRAR = 9;
    const USUARIO_VER = 10;
    
    //Roles
    const ROL_LISTAR = 11;
    const ROL_CREAR = 12;
    const ROL_EDITAR = 13;
    const ROL_BORRAR = 14;
    const ROL_VER = 15;
    
    //Permisos
    const PERMISO_LISTAR = 16;
    const PERMISO_CREAR = 17;
    const PERMISO_EDITAR = 18;
    const PERMISO_BORRAR = 19;
    const PERMISO_VER = 20;
}
