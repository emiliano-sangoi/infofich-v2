<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\ModificarPasswordType;
use AppBundle\Form\RecuperarPasswordType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends Controller
{

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
    public function loginAction(Request $request)
    {

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
    private function loguearUsuario(Usuario $usuario, $plain_password, Request $request)
    {

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

    public function logoutAction()
    {

    }

    public function recuperarPasswordAction(Request $request)
    {


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

            if ($user instanceof Usuario) {

                if (filter_var($user->getPersona()->getEmail(), FILTER_VALIDATE_EMAIL)) {

                    $hash = $this->generarRandomStr(64);
                    $user->setStringRecupPwd($hash);
                    $user->setFechaGenStringRecup(new \DateTime());
                    $em->flush();//actualizar cambios

                    $url_recup = $request->getSchemeAndHttpHost() .
                        $this->generateUrl('app_recuperar_password_finalizar');
//                        $this->generateUrl('app_recuperar_password_finalizar', array('string_verif' => $hash, 'username' => $username));

                    $contenido = $this->renderView('AppBundle:Security:recuperar-mail.html.twig', array(
                        'usuario' => $user,
                        'url_recup' => $url_recup
                    ));

                    //Enviar correo electrónico ...
                    if($this->getParameter('kernel.environment') != 'prod'){
                        //usado para desarrollo
                        $this->enviarMail('emiliano.sangoi@gmail.com', $contenido);
                    }else{
                        $this->enviarMail($user->getPersona()->getEmail(), $contenido);
                    }

                    return $this->redirectToRoute('app_recuperar_password_msg', array('id' => $user->getId()));


                } else {
                    $form->get('username')->addError(new FormError('El usuario no posee una dirección de correo o la misma no posee un formato correcto.'));
                }
            } else {
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

    public function finalizarRecuperacionAction(Request $request)
    {

//        $string_verif = $request->query->get('string_verif');
//        $username = $request->query->get('username');


//        if(!$usuario instanceof Usuario){
//            $this->addFlash('No se ha encontrado ningún usuario con el nombre de usuario: ' . $username);
//            return $this->redirectToRoute('homepage');
//        }

//        if(is_null($usuario->getStringRecupPwd()) || is_null($usuario->getFechaGenStringRecup())){
//            $this->addFlash('El usuario no ha solicitado un blanqueo de contraseño o esta accediendo a un enlace que ha expirado.');
//            return $this->redirectToRoute('homepage');
//        }

//        $now = new \DateTime();
//        $ini = $usuario->getFechaGenStringRecup();
//        $diff = $now->diff($ini);
//
//        if($diff->format('%s') > 3600){
//            //El enlace expiro.
//            $this->addFlash('El enlace para recuperar la contraseña ha expirado.');
//            return $this->redirectToRoute('homepage');
//        }
//
//        if($usuario->getStringRecupPwd() != $string_verif){
//            $this->addFlash('danger', 'El código de verificación no corresponde al definido para el usuario.');
//            return $this->redirectToRoute('homepage');
//        }

        $form = $this->createForm(ModificarPasswordType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $cod_verif = $form->get('stringRecupPwd')->getData();


            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository(Usuario::class)->findOneByStringRecupPwd($cod_verif);
            if (!$usuario) {
                $form->addError(new FormError('No se ha encontrado ningún usuario con el código ingresado. '));
            } else {

                $now = new \DateTime();
                $ini = $usuario->getFechaGenStringRecup();

                if ($now->diff($ini)->format('%s') > 3600) {
                    //El enlace expira pasada una hora luego del mail de recuperación enviado.
                    $msg = 'El código de verificación ha expirado. Vuelva a repetir el procedimiento y actualice la 
                    contraseña luego de recibir el correo electrónico con el código de verificación.';
                    $form->addError(new FormError($msg));
                } else {
                    //ok
                    $pwd1 = $form->get('password')->getData();
                    $pwd2 = $form->get('password2')->getData();

                    if ($pwd1 == $pwd2) {

                        $encodedPwd = $this->container->get('security.password_encoder')
                            ->encodePassword($usuario, $pwd1);

                        //Actualizar contraseña
                        $usuario->setPassword($encodedPwd);
                        $usuario->setStringRecupPwd(null);
                        $usuario->setFechaGenStringRecup(null);
                        $em->flush();

                        return $this->redirectToRoute('app_recuperar_password_finalizar_msg_ok');

                    } else {
                        $form->addError(new FormError('Las contraseñas no coinciden'));
                    }
                }
            }
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio de sesión", $this->get("router")->generate("app_login"));
        $breadcrumbs->addItem("Recuperar contraseña");
        $breadcrumbs->addItem("Finalizar");


        return $this->render('AppBundle:Security:recuperar-password-finalizar.html.twig', array(
            //'usuario' => $usuario,
            'page_title' => 'Recuperar contraseña',
            'form' => $form->createView()
        ));

    }

    private function enviarMail($to, $contenido, $from = null)
    {

        if ($from != null && !filter_var($from, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if ($from == null) {
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

    public function recuperarPasswordMsgAction(Request $request, Usuario $usuario)
    {

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio de sesión", $this->get("router")->generate("app_login"));
        $breadcrumbs->addItem("Recuperar contraseña");


        return $this->render('AppBundle:Security:recuperar-password-msg.html.twig', array(
            'usuario' => $usuario,
            'page_title' => 'Recuperar contraseña',
        ));

    }

    public function msgPwdActualizadaAction(Request $request)
    {

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio de sesión", $this->get("router")->generate("app_login"));
        $breadcrumbs->addItem("Recuperar contraseña");
        $breadcrumbs->addItem("Contraseña actualizada");


        return $this->render('AppBundle:Security:recuperar-password-msg-ok.html.twig', array(
            'page_title' => 'Recuperar contraseña',
        ));

    }

    private function generarRandomStr($longitud = 14)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i < $longitud) {
            $num = rand() % 60;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

}
