<?php

use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

// Descomentar:
class CargaUsuarios extends AbstractFixture implements FixtureInterface, ContainerAwareInterface{
// y comentar:
//class CargaUsuarios {


  private $fosUserManagerService;


  private $_usuarios = array(
    0 => array(
      'username' => 'rgalarza',
      'email' => 'romina.galarza@gmail.com',
      'password' => '1234',
      'roles' => array('ROLE_ADMIN')
    ),
    1 => array(
      'username' => 'esangoi',
      'email' => 'emiliano.sangoi@gmail.com',
      'password' => '1234',
      'roles' => array('ROLE_ADMIN')
    ),
    2 => array(
      'username' => 'bbasconcel',
      'email' => 'brisabasconcel@gmail.com',
      'password' => '1234',
      'roles' => array('ROLE_ADMIN')
    ),
    3 => array(
      'username' => '32185238',
      'email' => 'florenciaforesti@gmail.com',
      'password' => '32185238',
      'roles' => array('ROLE_USER')
    ),
    4 => array(
      'username' => '24902580',
      'email' => 'abacolla@gmail.com',
      'password' => '24902580',
      'roles' => array('ROLE_USER')
    ),
    5 => array(
      'username' => '13190428',
      'email' => 'cgiorgetti@fich.unl.edu.ar',
      'password' => '13190428',
      'roles' => array('ROLE_USER')
    ),
    6 => array(
      'username' => '14760883',
      'email' => 'parismarta@gmail.com',
      'password' => '14760883',
      'roles' => array('ROLE_USER')
    ),
    7 => array(
      'username' => '31700769',
      'email' => 'ggesualdo@fich.unl.edu.ar',
      'password' => '31700769',
      'roles' => array('ROLE_USER')
    ),
    8 => array(
      'username' => '28148023',
      'email' => 'mromanatti@fich.unl.edu.ar',
      'password' => '28148023',
      'roles' => array('ROLE_USER')
    ),
    9 => array(
      'username' => '14921804',
      'email' => 'nancypiovano@gmail.com',
      'password' => '14921804',
      'roles' => array('ROLE_USER')
    ),
    10 => array(
      'username' => '14921804',
      'email' => 'clozeco@fich.unl.edu.ar',
      'password' => '14921804',
      'roles' => array('ROLE_USER')
    )
    
  );

  private $container;

  public function setContainer(ContainerInterface $container = null)
  {
      $this->container = $container;
  }

/*
  public function __construct(FOS\UserBundle\Doctrine\UserManager $userManager){
    $this->fosUserManagerService = $userManager;
  }*/



  public function load(ObjectManager $manager){

    /**
      docs: https://symfony.com/doc/current/bundles/FOSUserBundle/user_manager.html
    */
    $this->fosUserManagerService = $this->container->get('fos_user.user_manager');

    foreach ($this->_usuarios as $u_data) {

      $user = $this->fosUserManagerService->createUser();

      $user->setUsername($u_data['username']);
      $user->setEmail($u_data['email']);
      $user->setEmailCanonical($u_data['email']);
      $user->setLocked(0); // don't lock the user
      $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
      // this method will encrypt the password with the default settings :)
      $user->setPlainPassword($u_data['password']);

      foreach ($u_data['roles'] as $rol) {
        $user->addRole($rol);
      }


      $this->fosUserManagerService->updateUser($user);

    }



  }







}


















 ?>
