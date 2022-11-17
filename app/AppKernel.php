<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),

            new Vich\UploaderBundle\VichUploaderBundle(),
            new PlanificacionesBundle\PlanificacionesBundle(),
            
            new \Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            
            // https://github.com/whiteoctober/BreadcrumbsBundle
            new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),
            new DocentesBundle\DocentesBundle(),
            new VehiculosBundle\VehiculosBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            
            // Bundle para generar fixtures a partir de datos existentes en la base de datos:
            //      https://github.com/Webonaute/DoctrineFixturesGeneratorBundle
            // Activar, usar, desactivar:
            //$bundles[] = new Webonaute\DoctrineFixturesGeneratorBundle\DoctrineFixturesGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
    
    
    public function getCacheDir()
    {
     /*   if($this->environment == 'prod'){
            return '/tmp/infofich2/cache/' . $this->environment;
        }*/
        
        return parent::getCacheDir();
    }
//    
//    public function getLogDir()
//    {
//        if($this->environment == 'dev'){
//            return '/home/vagrant/infofich2/logs/'  . $this->environment;
//        }
//        return parent::getLogDir();
//    }
}
