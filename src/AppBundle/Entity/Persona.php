<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

// * @UniqueEntity(fields={"tipoDocumento", "documento"},
// *     message="Ya existe una persona registrada con el tipo y numero de documento ingresado."
// * )

/**
 * Persona
 *
 *
 * @ORM\Table(name="app_personas", 
 *    uniqueConstraints={
 *        @ORM\UniqueConstraint(name="persona_unique1", columns={"tipo_documento", "documento"}),
 *        @ORM\UniqueConstraint(name="persona_unique2", columns={"cuil"}),
 *    }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonaRepository")
 * 
 * @ORM\HasLifecycleCallbacks()
 */
class Persona implements \JsonSerializable {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=512)
     */
    protected $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=512)
     */
    protected $nombres;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_documento", type="smallint", nullable=true)
     */
    protected $tipoDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=12, unique=true)
     */
    protected $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="cuil", type="string", length=16, nullable=true, unique=true)
     */
    protected $cuil;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=32, nullable=true)
     */
    protected $telefono;

    /**
     *
     * @var DateTime 
     * 
     * @ORM\Column(name="fechaNacimiento", type="datetime", nullable=true)
     */
    protected $fechaNacimiento;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="genero", type="boolean", nullable=true)
     */
    protected $genero;

    public function __construct() {
        ;
    }

    public function __toString() {
        return $this->apellidos . ', ' . $this->nombres;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    
    /**
     * Get apellido y nombre
     *
     * @return string
     */
    public function getApeNom($apellido_uppercase = false) {
        $s = $apellido_uppercase ? strtoupper($this->apellidos) : $this->apellidos;
        return $s . ', ' . $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Persona
     */
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos() {
        return $this->apellidos;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     *
     * @return Persona
     */
    public function setNombres($nombres) {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string
     */
    public function getNombres() {
        return $this->nombres;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return Persona
     */
    public function setDocumento($documento) {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento() {
        return $this->documento;
    }

    /**
     * Get tipo documento
     *
     * @return integer
     */
    function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    /**
     * 
     * @param integer $tipoDocumento
     * 
     * @return $this
     */
    function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
        return $this;
    }

    function getTipoYNroDocumento() {
        $tipo = \FICH\APIRectorado\Config\WSHelper::getDescTipoDoc($this->tipoDocumento);
        if (isset($tipo[0])) {
            return strtoupper($tipo[0]) . ' - ' . $this->documento;
        }
        return $this->documento;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Persona
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Persona
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set cuil
     *
     * @param string $cuil
     *
     * @return Persona
     */
    public function setCuil($cuil) {
        $this->cuil = $cuil;

        return $this;
    }

    /**
     * Get cuil
     *
     * @return string
     */
    public function getCuil() {
        return $this->cuil;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return Persona
     */
    public function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    /**
     * Set genero
     *
     * @param boolean $genero
     *
     * @return Persona
     */
    public function setGenero($genero) {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return boolean
     */
    public function getGenero() {
        return $this->genero;
    }

    public function jsonSerialize() {
        return array(
            'id' => $this->id,
            'tipoDocumento' => $this->tipoDocumento,
            'documento' => $this->documento,
            'apellidos' => $this->apellidos,
            'nombres' => $this->nombres,
            'genero' => $this->genero,
            'telefono' => $this->telefono,
            'cuil' => $this->cuil,
            'email' => $this->email,
            'fechaNacimiento' => $this->fechaNacimiento ? $this->fechaNacimiento->getTimestamp() : null,
        );
    }

}
