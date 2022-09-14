<?php

namespace AppBundle\Service;

use AppBundle\Entity\Persona;
use AppBundle\Entity\Rol;
use AppBundle\Entity\Usuario;
use AppBundle\Repository\RolRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use FICH\APIRectorado\Config\WSHelper;
use PDO;
use PDOException;
use stdClass;

/**
 * Description of InfofichViejoService
 *
 * @author emi88
 */
class InfofichViejoService {

    /**
     * Conexion a la base de datos
     * @var PDO
     */
    private $pdoLink;

    /**
     *
     * @var stdClass 
     */
    private $dbParams;

    /**
     *
     * @var string
     */
    private $ultimoError;

    /**
     *
     * @var EntityManager 
     */
    private $em;
    
    /**
     *
     * @var RolRepository 
     */
    private $repoRoles;
    

    public function __construct($entityManager, $db_infofich_viejo) {

        $this->em = $entityManager;

        $this->dbParams = new stdClass;
        $this->dbParams->host = $db_infofich_viejo['host'];
        $this->dbParams->puerto = $db_infofich_viejo['puerto'];
        $this->dbParams->nombre = $db_infofich_viejo['nombre'];
        $this->dbParams->usuario = $db_infofich_viejo['usuario'];
        $this->dbParams->password = $db_infofich_viejo['password'];
        
        $this->repoRoles = $this->em->getRepository('AppBundle:Rol');
    }

    /**
     * Crea un objecto PDO con la conexion a la base de datos.
     * 
     * @return type
     */
    private function conectar() {
        if ($this->pdoLink instanceof PDO) {
            return;
        }

        $this->ultimoError = '';

        try {
            //'mysql:host=localhost;dbname=test'
            $dsn = 'mysql:';
            $dsn .= 'host=' . $this->dbParams->host;
            $dsn .= ';dbname=' . $this->dbParams->nombre;

            if ($this->dbParams->puerto) {
                $dsn .= ';port=' . $this->dbParams->puerto;
            }

            // dump($dsn);exit;

            $this->pdoLink = new PDO($dsn, $this->dbParams->usuario, $this->dbParams->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
        } catch (PDOException $e) {
            $this->pdoLink = false;
            $this->ultimoError = "Ocurrio un error al conectarse a la base de datos con los parametros.";
        }
    }

    /**
     * Devuelve todos los usuarios de sistema_usuarios
     * 
     * @return boolean
     */
    public function getUsuarios() {

        $this->conectar();

        if (!$this->pdoLink) {
            return false;
        }

        $sql = "SELECT * FROM sistema_usuarios";

        $stmt = $this->pdoLink->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Importa los usuarios del sistema viejo al actual.
     * 
     * @param boolean $truncar Si es true vacia la tabla app_usuarios antes de insertar.
     * @return boolean|array false o un array con los datos.
     */
    public function importarUsuarios($truncar = false) {

        $this->conectar();

        if (!$this->pdoLink) {
            return false;
        }

        //Vaciar la tabla usuarios:
        if ($truncar) {
            try {
                $this->em->getConnection()->query('DELETE FROM app_usuario_roles');
                $this->em->getConnection()->query('DELETE FROM app_usuarios');
                $this->em->getConnection()->query('DELETE FROM app_personas');
            } catch (Exception $ex) {
                $this->ultimoError = 'Ocurrio un error al vaciar la tabla app_usuarios';
                return false;
            }
        }
        
        $rolAdmin = $this->repoRoles->findOneByNombre(Rol::ROLE_ADMIN);
        $rolUsuario = $this->repoRoles->findOneByNombre(Rol::ROLE_USUARIO);
        $rolSA = $this->repoRoles->findOneByNombre(Rol::ROLE_SEC_ACADEMICA);
        $rolDocente = $this->repoRoles->findOneByNombre(Rol::ROLE_DOCENTE_GRADO);

        $admins = array(
            '33496269', //Emiliano
            '31272619', //Romi
            '30786020', //Brisa   
            '24902580', //Ana
            '28148023', //Mariana
            '11415920', //Polo
            '32185238', //Florencia
            // agregar aca los usuarios admins del viejo sistema
        );
        
        $sa = array(
            '13190428', //Carlos Giorgetti
            '14760883', //Marta Paris
            '31700769', //Gabi Gesualdo
        );

        $docentes = array();
        $sql_docentes = "SELECT su.numero_documento FROM `sistema_roles_usuarios` AS sru 
                            INNER JOIN `sistema_usuarios` AS su ON sru.id_usuario = su.id_usuario 
                            WHERE sru.`id_rol` = 4 ORDER BY su.numero_documento DESC ";

        $stmt = $this->pdoLink->query($sql_docentes);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $doc = $row['numero_documento'];
            if(is_numeric($doc)){
                $docentes[] = $doc; 
            }
        }

        $sql = "SELECT * FROM sistema_usuarios";

        $stmt = $this->pdoLink->query($sql);

        $i = $r = 0;
        $insertados = $rechazados = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            //dump(get_class($user));exit;
            $doc = $row['numero_documento'];
            //dump($row);exit;
            
            //no incluir repetidos:
            if(!is_numeric($doc) || in_array($doc, $insertados)){
                $rechazados[] = $row;
                $r++;
                continue;
            }
            
            $persona = new Persona();
            $persona->setApellidos( ucwords( strtolower($row['apellidos']) ) );
            $persona->setNombres( ucwords( strtolower($row['nombres']) ) );
            $persona->setDocumento($doc);
            
            //Tipo de documento
            // en la BD esta la descripcion DNI, LC, LE, etc.
            // se traduce esta descripcion al codigo utilizado por los web services de rectorado.
            $cod_tipo_doc = WSHelper::getCodigoTipoDocPorDesc( $row['tipo_docum'] );
            if(is_null($cod_tipo_doc)){
                throw new \Exception("No se pudo traducir el tipo de documento " . $row['tipo_docum'] . ' a un codigo valido.');
            }
            $persona->setTipoDocumento($cod_tipo_doc);
            
            //email:
            if(filter_var($row['email'], FILTER_VALIDATE_EMAIL)){
                $persona->setEmail($row['email']);
            }
            
            $insertados[] = $doc;

            $usuario = new Usuario();
            $usuario->setPersona($persona);
            $usuario->setUsername($row['nombre_usuario']);
            $usuario->setPassword($row['password']);
            
            //Roles:
            if(in_array($usuario->getUsername(), $admins)){
                $usuario->addRole($rolAdmin);
            }else if(in_array($usuario->getUsername(), $sa)){
                $usuario->addRole($rolSA); 
            }else if(in_array($usuario->getUsername(), $docentes)){
                $usuario->addRole($rolDocente);               
            }else{
                $usuario->addRole($rolUsuario);
            }           

            $this->em->persist($usuario);

            $i++;
        }


      //  try {
            $this->em->flush();
      //  } catch (UniqueConstraintViolationException $uex) {
            
      //  }

            

        return array(
            'insetados' => $insertados,
            'insetados_n' => $i,
            'rechazados' => $rechazados,
            'rechazados_n' => $r,
        );

        /*
         * Mas datos:
         * array:24 [
          "id_usuario" => "1"
          "nro_legajo" => "11228"
          "unidad_academica" => "FICH"
          "nro_inscripcion" => "0"
          "tipo_docum" => "DNI"
          "numero_documento" => "24707463"
          "nombre_usuario" => "imelgrat"
          "password" => "*39D1730AD884EB4CD8F5618CC3E5310202ACD0BD"
          "reset_password" => "1"
          "nombres" => "Iván Ariel"
          "apellidos" => "Melgrati"
          "email" => "imelgrat@gmail.com"
          "oficina" => "Estudio"
          "interno" => "148"
          "telefono_fijo" => "(0342)4695631"
          "telefono_celular" => "(0342)154061891"
          "comentario" => "Webmaster del sitio. Administrador del sitio de inventario"
          "egresado_grado" => "0"
          "id_usuario_creacion" => "1"
          "fecha_creacion" => "2011-04-26 15:55:22"
          "ultimo_ingreso" => "2018-03-06 21:32:18"
          "fecha_actualizacion" => null
          "string_verificacion" => null
          "nueva_password" => null
          ]

         * 
         */
    }

}
