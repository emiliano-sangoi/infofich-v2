<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoActividadCurricular
 *
 * @ORM\Table(name="planif_tipos_actividad_curricular")
 * @ORM\Entity(repositoryClass="PlanificacionesBundle\Repository\TipoActividadCurricularRepository")
 */
class TipoActividadCurricular {
    
    const TEORICA = 1;
    const COLOQUIO = 2;
    const SEMINARIO = 3;
    const TP = 4;
    const TALLER = 5;
    const TEORICA_PRACTICA = 6;
    const RESOLUC_PROB = 7;
    const CONSULTA = 8;
    const EVALUACIONES = 9;
    const EMPLEO = 10;
    const OTRAS_ACT = 11;
    
    private static $nombres_tipos = array(
        self::TEORICA => 'Clase teórica',
        self::COLOQUIO => 'Coloquio',
        self::SEMINARIO => 'Seminario',
        self::TP => 'Trabajo práctico',
        self::TALLER => 'Taller',
        self::TEORICA_PRACTICA => 'Clase teórico–práctica',
        self::RESOLUC_PROB => 'Resolución de problemas',
        self::CONSULTA => 'Consulta',
        self::EVALUACIONES => 'Evaluaciones en sus diversas modalidades',        
        self::EMPLEO => 'Empleo de plataformas virtuales de aprendizaje',
        self::OTRAS_ACT => 'Otras actividades',
    );
    
    public static function getTipos(){
        return self::$nombres_tipos;
    }
    
    public static function getTiposPractica(){
        
    }

    
    public static function isTipoValido($cod_tipo){
        return isset($this->nombres_tipos[ $cod_tipo ]);
    } 
    
    public static function isPractica($cod_tipo){
        return in_array($cod_tipo, array(
            self::TP,
            self::RESOLUC_PROB,            
            // TODO: Definir codigos 
        ));
    }
    
    public static function isExperimental($cod_tipo){
        return in_array($cod_tipo, array(
            self::RESOLUC_PROB,
            self::TALLER,            
            // TODO: Definir codigos 
        ));
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var int
     *
     * @ORM\Column(name="codigo", type="integer", unique=true)
     * 
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=64, unique=true)
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
        return $this->descripcion;
    }
    
      /**
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return TipoActividadCurricular
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
    
    
        /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TipoActividadCurricular
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

}
