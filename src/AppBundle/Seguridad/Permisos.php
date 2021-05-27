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
    const PLANIF_BORRAR = 4;
    const PLANIF_VER = 5;
    
    //Usuarios
    const USUARIO_LISTAR = 6;
    const USUARIO_CREAR = 7;
    const USUARIO_EDITAR = 8;
    const USUARIO_BORRAR = 9;
    const USUARIO_VER = 10;
}
