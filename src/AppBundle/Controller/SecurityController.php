<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\RecuperarPasswordType;
use DateTime;
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
                
                //actualizar fecha de ultimo ingreso:
                $usuario->setUltimoIngreso(new DateTime);
                $em->flush();

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
    
    public function recuperarPasswordAction(Request $request) {
        
        
        $form = $this->createForm(RecuperarPasswordType::class);
        $form->handleRequest($request);
        
         if ($form->isSubmitted() && $form->isValid()) {

            $username = $form['username']->getData();
            //
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(Usuario::class)->findOneBy(array(
                'username' => $username,
                'fechaBaja' => null
            ));

            if($user instanceof Usuario){

                if(filter_var($user->getPersona()->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    $hash = $this->generarRandomStr();
//                    $encodedPwd = $this->container->get('security.password_encoder')
//                        ->encodePassword($user, $nuevaPwd);

                    $user->setStringRecupPwd($hash);
                    $user->setResetPwd(true);
                    $em->flush();//actualizar cambios

                    //Enviar correo electrónico ...
                    $this->enviarMail('emiliano.sangoi@gmail.com', 'Recuperar contraseña');

                    return $this->redirectToRoute('app_recuperar_password_msg', array('id' => $user->getId()));


                }else{
                    $form->get('username')->addError(new FormError('El usuario no posee una dirección de correo o la misma no posee un formato correcto.'));
                }

                //Enviar correo con contraseña nueva

                dump($username);exit;
            }else{
                $form->get('username')->addError(new FormError('No se encontró ningún usuario con el nombre de usuario ingresado.'));
            }
            
         }
        
        
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio de sesión", $this->get("router")->generate("app_login"));
        $breadcrumbs->addItem("Recuperar contraseña");
        
        
        return $this->render('AppBundle:Security:recuperar-password.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => 'Recuperar contraseña',
        ));
    }

    private function enviarMail($to, $contenido, $from = null){

        if($from != null && !filter_var($from,FILTER_VALIDATE_EMAIL)){
            return false;
        }

        if($from == null){
            $from = $this->getParameter('gidis_email');
        }

        $titulo = 'Infofich - Recuperar contraseña';

        //Crear msg:
        $message = new \Swift_Message($titulo);

        $message
            ->setFrom($from)
            ->setTo($to)
            ->setBody($contenido, 'text/html');

        $fallas = null;
        $this->get('mailer')->send($message, $fallas);

        if ($fallas) {
            return false;
        }

        return true;

    }

    public function recuperarPasswordMsgAction(Request $request, Usuario $usuario) {

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio de sesión", $this->get("router")->generate("app_login"));
        $breadcrumbs->addItem("Recuperar contraseña");


        return $this->render('AppBundle:Security:recuperar-password-msg.html.twig', array(
            'usuario' => $usuario,
            'page_title' => 'Recuperar contraseña',
        ));

    }

    private function generarRandomStr($longitud = 14)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i <= $longitud)
        {
            $num = rand() % 60;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

}
