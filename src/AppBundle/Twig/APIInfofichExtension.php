<?php

namespace AppBundle\Twig;

use AppBundle\Service\APIInfofichService;
use AppBundle\Util\Texto;
use FICH\APIInfofich\Model\Carrera;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class APIInfofichExtension extends AbstractExtension {

    /**
     *
     * @var APIInfofichService 
     */
    private $infofichService;

    public function __construct(APIInfofichService $apiInfofichService) {
        $this->infofichService = $apiInfofichService;
    }

    public function getFilters() {
        return array(
            //new TwigFilter('ejemplo', array($this, 'getNombreCarrera')),            
        );
    }
    
    public function getFunctions()
    {
        return array(
            new TwigFunction('nom_carrera', array($this, 'getNombreCarrera')),
        );
    }

    /**
     * Devuelve el nombre de la carrera
     * 
     * @param string $codigo
     * @return string|null
     */
    public function getNombreCarrera($codigo) {
        //dump($codigo);
        $carrera = $this->infofichService->getCarrera($codigo);
        if ($carrera instanceof Carrera) {
            return Texto::ucWordsCustom($carrera->getNombreCarrera());
        }
        return null;        
    }
    

}
