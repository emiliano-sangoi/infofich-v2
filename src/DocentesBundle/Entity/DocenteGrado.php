<?php

namespace DocentesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Docente
 *
 * @ORM\Table(name="planif_docentes_grado")
 * @ORM\Entity(repositoryClass="DocentesBundle\Repository\DocenteGradoRepository")
 */
class DocenteGrado extends Docente {

    /**
     * @var string
     *
     * @ORM\Column(name="nro_legajo", type="string", length=64, nullable=true)
     */
    private $nroLegajo;
   

    public function __toString() {
        return $this->nroLegajo . ' - ' . $this->persona->getApeNom(false);
    }
    
    public function getDescripcion() {
        return 'Legajo: ' . $this->nroLegajo . ' / ' . $this->persona->getTipoYNroDocumento() . ' / ' .  $this->persona->getApeNom(false);
    }

    public function getCodApeNom($apellido_uppercase = false) {
        return $this->nroLegajo . ' - ' . $this->persona->getApeNom($apellido_uppercase);
    }

    /**
     * Set nroLegajo
     *
     * @param string $nroLegajo
     *
     * @return Docente
     */
    public function setNroLegajo($nroLegajo) {
        $this->nroLegajo = $nroLegajo;

        return $this;
    }

    /**
     * Get nroLegajo
     *
     * @return string
     */
    public function getNroLegajo() {
        return $this->nroLegajo;
    }

    /**
     * Set fechaInactivo
     *
     * @param \DateTime $fechaInactivo
     *
     * @return DocenteGrado
     */
    public function setFechaInactivo($fechaInactivo) {
        $this->fechaInactivo = $fechaInactivo;

        return $this;
    }

    /**
     * Get fechaInactivo
     *
     * @return \DateTime
     */
    public function getFechaInactivo() {
        return $this->fechaInactivo;
    }


  
}
