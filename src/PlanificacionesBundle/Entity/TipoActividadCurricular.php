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
    const LABORATORIO = 10;
    const OTRAS_ACT = 11;
    
    private static $nombres_tipos = array(
        self::TEORICA => 'Clase teórica', // modif 4/11 
        self::COLOQUIO => 'Coloquio', // modif 4/11
        //self::SEMINARIO => 'Seminario',
        self::TP => 'Clase práctica', // modif 4/11
        //self::TALLER => 'Taller',
        self::TEORICA_PRACTICA => 'Clase teórico–práctica', // modif 4/11
       // self::RESOLUC_PROB => 'Resolución de problemas',
        self::CONSULTA => 'Consulta', // modif 4/11
        self::EVALUACIONES => 'Evaluaciones',        //modif 4/11
      //  self::EMPLEO => 'Empleo de plataformas virtuales de aprendizaje',
        self::OTRAS_ACT => 'Otras actividades',
        self::LABORATORIO => 'Laboratorio', //agregado el 30/5/2023
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
            self::TP
           // self::RESOLUC_PROB,            
            // TODO: Definir codigos 
        ));
    }
    public static function isColoquio($cod_tipo){
        return in_array($cod_tipo, array(
            self::COLOQUIO
        ));
    }
    
    public static function isTeoria($cod_tipo){
        return in_array($cod_tipo, array(
            self::TEORICA
        ));
    }
    
    public static function isTeoricoPractica($cod_tipo){
        return in_array($cod_tipo, array(
            self::TEORICA_PRACTICA,
            // TODO: Definir codigos 
        ));
    }
    
    public static function isConsulta($cod_tipo){
        return in_array($cod_tipo, array(
            self::CONSULTA,
            // TODO: Definir codigos 
        ));
    }
    
    public static function isEvaluacion($cod_tipo){
        return in_array($cod_tipo, array(
            self::EVALUACIONES,
            // TODO: Definir codigos 
        ));
    }
    
    public static function isOtrasActividades($cod_tipo){
        return in_array($cod_tipo, array(
            self::OTRAS_ACT,
            // TODO: Definir codigos 
        ));
    }

    public static function isLaboratorio($cod_tipo){
        return in_array($cod_tipo, array(
            self::LABORATORIO,
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
