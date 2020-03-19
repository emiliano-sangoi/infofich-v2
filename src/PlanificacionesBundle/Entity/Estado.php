<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estado
 *
 * @ORM\Table(name="planif_estados")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\EstadoRepository")
 */
class Estado {

    const PREPARACION = 1;
    const REVISION = 2;
    const CORRECCION = 3;
    const PUBLICADA = 4;

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

    public static function getNombrePorCod($cod) {
        switch ($cod) {
            case self::PREPARACION:
                return 'En preparación';
            case self::REVISION:
                return 'En revisión';
            case self::CORRECCION:
                return 'En corrección';
            case self::PUBLICADA:
                return 'Publicada';
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
}
