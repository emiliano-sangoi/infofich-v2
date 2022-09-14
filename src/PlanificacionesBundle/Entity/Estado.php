<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estado
 *
 * @ORM\Table(name="planif_estados")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\EstadoRepository")
 */
class Estado implements \JsonSerializable{

    const CREADA = 1;
    const PREPARACION = 2;
    const REVISION = 3;
    const CORRECCION = 4;
    const PUBLICADA = 5;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var smallint
     *
     * @ORM\Column(name="codigo", type="smallint", unique=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=64)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=512, nullable=true)
     */
    private $descripcion;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    public function __toString() {
        return $this->nombre;
    }
    
    public function getCssClass() {
        switch ($this->codigo){
            case self::PREPARACION:
                return 'light';
            case self::REVISION:
                return 'warning';
            case self::CORRECCION:
                return 'danger';
            case self::PUBLICADA:
                return 'success';
        }
        
        return '';
    }
    
    /**
     * Verifica si el estado pasado como parametro es valido.
     * 
     * @param type $cod
     * @return type
     */
    public static function isValido($cod) {
        return in_array($cod, array(
            self::CREADA,
            self::PREPARACION,
            self::REVISION,
            self::CORRECCION,
            self::PUBLICADA
        ));
    }

    public static function getNombrePorCod($cod) {
        switch ($cod) {
            case self::CREADA:
                return 'Creada';
            case self::PREPARACION:
                return 'En preparación';
            case self::REVISION:
                return 'En revisión';
            case self::CORRECCION:
                return 'En corrección';
            case self::PUBLICADA:
                return 'Publicada';
            default:
                return false;
        }
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Estado
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Estado
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }


    /**
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return Estado
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
        );
    }

}
