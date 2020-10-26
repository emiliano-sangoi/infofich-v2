<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
                $query, /* query NOT result */ $request->query->getInt('page', 1), /* page number */ 10 /* limit per page */
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
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('usuarios_show', array('id' => $usuario->getId()));
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

        return $this->render('AppBundle:usuario:show.html.twig', array(
                    'usuario' => $usuario,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     */
    public function editAction(Request $request, Usuario $usuario) {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuarios_edit', array('id' => $usuario->getId()));
        }

        return $this->render('AppBundle:usuario:edit.html.twig', array(
                    'usuario' => $usuario,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
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
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('usuarios_index');
    }

    /**
     * Creates a form to delete a usuario entity.
     *
     * @param Usuario $usuario The usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('usuarios_delete', array('id' => $usuario->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
