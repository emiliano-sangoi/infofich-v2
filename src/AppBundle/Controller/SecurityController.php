<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends Controller {

    /**
     * Login de usuarios
     * 
     * Parte fue extraido de:
     *      https://ourcodeworld.com/articles/read/459/how-to-authenticate-login-manually-an-user-in-a-controller-with-or-without-fosuserbundle-on-symfony-3
     * 
     * 
     * @param Request $request
     * @return type
     */
    public function loginAction(Request $request) {

        $form = $this->createForm('AppBundle\Form\LoginType', null);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $username = $form['username']->getData();
            $plain_password = $form['password']->getData();

            $em = $this->getDoctrine()->getManager();
            $repoUsuarios = $em->getRepository('\AppBundle\Entity\Usuario');
            $usuario = $repoUsuarios->findOneByUsername($username);

            $ok = $usuario instanceof Usuario && $this->loguearUsuario($usuario, $plain_password, $request);

            if ($ok) {

                return $this->redirectToRoute('homepage');
            } else {
                $form->addError(new FormError('Usuario y/o contraseñas incorrectos.'));
            }
        }

        return $this->render('AppBundle:Security:login.html.twig', array(
                    'form_login' => $form->createView(),
                    'page_title' => 'Ingreso al sistema',
        ));
    }

    /**
     * Metodo auxiliar que permite loguear la usuario
     * 
     * @param \AppBundle\Controller\Usuario $usuario
     * @param Request $request
     */
    private function loguearUsuario(Usuario $usuario, $plain_password, Request $request) {

        // Traer el encoder configurado en el security:
        $factory = $this->get('security.encoder_factory');

        $encoder = $factory->getEncoder($usuario);
        $salt = null; //TODO: Agregar salt al usuario

        if (!$encoder->isPasswordValid($usuario->getPassword(), $plain_password, $salt)) {
            return false;
        }

        $firewall_name = 'firewall_admin';

        //Crear token
        $token = new UsernamePasswordToken($usuario, $plain_password, $firewall_name, $usuario->getRoles());
        $this->get('security.token_storage')->setToken($token);

        //Almacenarlo en session:
        $this->get('session')->set('_security_' . $firewall_name, serialize($token));

        // Fire the login event manually
        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

        return true;
    }

    public function logoutAction() {
        
    }

}
