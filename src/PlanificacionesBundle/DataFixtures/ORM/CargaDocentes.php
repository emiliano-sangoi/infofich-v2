<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PlanificacionesBundle\Entity\Docente;


class CargaDocentes{
//class CargaDocentes extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface{


  public function load(ObjectManager $manager){
      
      $d = new Docente();
      $d->setApellidos("Basconcel");
      $d->setNombres("Brisa");
      $d->setDni("111111111");
      $d->setNroLegajo("111");
      $d->setTelefono("123456789");
      $d->setEmail("brisa.basconcel@gmail.com");
      $manager->persist($d);
      
      $d2 = new Docente();
      $d2->setApellidos("Galarza");
      $d2->setNombres("Romina");
      $d2->setDni("22222222");
      $d2->setNroLegajo("2222");
      $d2->setTelefono("123456789");
      $d2->setEmail("romina.galarza@gmail.com");
      $manager->persist($d2);
      
      
      $d3 = new Docente();
      $d3->setApellidos("Sangoi");
      $d3->setNombres("Emiliano");
      $d3->setDni("33496269");
      $d3->setNroLegajo("3333");
      $d3->setTelefono("123456789");
      $d3->setEmail("emiliano.sangoi@gmail.com");
      $manager->persist($d3);

      $manager->flush();
      

  }

  public function getOrder(){
        return 1;
  }



}


 ?>
