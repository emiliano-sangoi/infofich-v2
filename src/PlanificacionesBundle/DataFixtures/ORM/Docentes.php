<?php

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class Docentes extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface{


  public function load(ObjectManager $manager){




  }

  public function getOrder(){
        return 1;
  }



}


 ?>
