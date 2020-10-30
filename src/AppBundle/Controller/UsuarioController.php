<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller {

    /**
     * Lists all usuario entities.
     *
     */
    public function indexAction(Request $request) {
        //$em = $this->getDoctrine()->getManager();
        // $usuarios = $em->getRepository('AppBundle:Usuario')->findAll();


        $dql = "SELECT u FROM AppBundle:Usuario u";
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);

        //$form = $this->createForm('PlanificacionesBundle\Form\BuscadorType', null);

        $paginator = $this->get('knp_paginator');
        $paginado = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1), /* page number */ 15 /* limit per page */
        );

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("USUARIOS");

        return $this->render('AppBundle:usuario:index.html.twig', array(
                    'usuarios' => $paginado,
                    'page_title' => 'Usuarios'
        ));
    }

    /**
     * Creates a new usuario entity.
     *
     */
    public function newAction(Request $request) {
        $usuario = new Usuario();

        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->add('persona', 'AppBundle\Form\PersonaType');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //dump($usuario);exit;
            $em = $this->getDoctrine()->getManager();

            try {

                $plainPwd = $form->get('plainPassword')->getData();

                // Codificar la contraseña:
                $encodedPwd = $this->container->get('security.password_encoder')
                        ->encodePassword($usuario, $plainPwd);
                $usuario->setPassword($encodedPwd);

                $em->persist($usuario);
                $em->flush();

                $this->addFlash('success', 'Usuario creado correctamente');

                return $this->redirectToRoute('usuarios_show', array('id' => $usuario->getId()));
            } catch (UniqueConstraintViolationException $ex) {
                $msg = 'Ya existe una persona con el tipo y numero de documento ingresado.';
                $form->get('persona')->get('documento')->addError(new FormError($msg));
            }
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Usuarios", $this->get("router")->generate("usuarios_index"));
        $breadcrumbs->addItem("NUEVO");

        return $this->render('AppBundle:usuario:new.html.twig', array(
                    'usuario' => $usuario,
                    'page_title' => 'Nuevo usuario',
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a usuario entity.
     *
     */
    public function showAction(Usuario $usuario) {
        $deleteForm = $this->createDeleteForm($usuario);

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Usuarios", $this->get("router")->generate("usuarios_index"));
        $breadcrumbs->addItem($usuario);
        //$breadcrumbs->addItem($usuario);

        return $this->render('AppBundle:usuario:show.html.twig', array(
                    'usuario' => $usuario,
                    'delete_form' => $deleteForm->createView(),
                    'page_title' => $usuario->__toString() . ' - Ver',
        ));
    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     */
    public function editAction(Request $request, Usuario $usuario) {

        $deleteForm = $this->createDeleteForm($usuario);
        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->add('persona', 'AppBundle\Form\PersonaType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            try {

                $plainPwd = $form->get('plainPassword')->getData();

                if ($plainPwd) {
                    // Codificar y actualizar la contraseña:
                    $encodedPwd = $this->container->get('security.password_encoder')
                            ->encodePassword($usuario, $plainPwd);
                    $usuario->setPassword($encodedPwd);
                }

                //dump($usuario);exit;

                $em->flush();

                $this->addFlash('success', 'Datos modificados correctamente');

                return $this->redirectToRoute('usuarios_edit', array('id' => $usuario->getId()));
            } catch (UniqueConstraintViolationException $ex) {
                $msg = 'Ya existe una persona con el tipo y numero de documento ingresado.';
                $form->get('persona')->get('documento')->addError(new FormError($msg));
            }
        }

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Usuarios", $this->get("router")->generate("usuarios_index"));
        $breadcrumbs->addItem($usuario, $this->get("router")->generate("usuarios_show", array('id' => $usuario->getId())));
        $breadcrumbs->addItem('EDITAR');

        return $this->render('AppBundle:usuario:edit.html.twig', array(
                    'usuario' => $usuario,
                    'form' => $form->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'page_title' => $usuario->__toString() . ' - Editar',
        ));
    }

    /**
     * Deletes a usuario entity.
     *
     */
    public function deleteAction(Request $request, Usuario $usuario) {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            try {
                $em->remove($usuario);
                $em->flush();
                              
                $this->addFlash('success', 'El usuario fue dado de baja correctamente.');
                
            } catch (UniqueConstraintViolationException $ex) {

                //Si el usuario esta siendo utilizado por otra tabla, se lo da de baja logicamente:
                $usuario->setFechaBaja(new \DateTime());
                $em->flush();
                
                $this->addFlash('warning', 'El usuario fue dado de baja correctamente (baja lógica).');
            }
                        
        }

        return $this->redirectToRoute('usuarios_index');
    }

    /**
     * Creates a form to delete a usuario entity.
     *
     * @param Usuario $usuario The usuario entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Usuario $usuario) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('usuarios_delete', array('id' => $usuario->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
