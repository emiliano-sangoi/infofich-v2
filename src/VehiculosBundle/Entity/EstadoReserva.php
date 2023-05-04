<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estado de la reserva
 * @ORM\Entity
 * @ORM\Table(name="vehiculo_reserva_estado")")
 * @ORM\Entity(repositoryClass="VehiculosBundle\Repository\EstadoRepository")
 */
class EstadoReserva implements \JsonSerializable{

    const NUEVA = 1;
    const ACEPTADA = 2;
    const RECHAZADA = 3;
    const CANCELADA = 4;
    const AVALADA = 5;

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
            case self::NUEVA:
                return 'light';
            case self::CANCELADA:
                return 'warning';
            case self::RECHAZADA:
                return 'danger';
            case self::AVALADA:
                return 'success';
            case self::ACEPTADA:
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
            self::NUEVA,
            self::AVALADA,
            self::ACEPTADA,
            self::CANCELADA,
            self::RECHAZADA
        ));
    }

    public static function getNombrePorCod($cod) {
        switch ($cod) {
            case self::NUEVA:
                return 'Nueva';
            case self::ACEPTADA:
                return 'Aceptada';
            case self::AVALADA:
                return 'Avalada';
            case self::CANCELADA:
                return 'Cancelada';
            case self::RECHAZADA:
                return 'Rechazada';
            default:
                return false;
        }
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return EstadoReserva
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
     * @return EstadoReserva
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
     * @return EstadoReserva
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
