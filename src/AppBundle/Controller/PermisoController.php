<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Permiso;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Permiso controller.
 *
 */
class PermisoController extends Controller {

    /**
     * Lists all permiso entities.
     *
     */
    public function indexAction(Request $request) {

        $dql = "SELECT p FROM AppBundle:Permiso p";
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $permisos = $paginator->paginate(
                $query, $request->query->getInt('page', 1), 10
        );

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("PERMISOS");

        return $this->render('AppBundle:permiso:index.html.twig', array(
                    'permisos' => $permisos,
                    'page_title' => 'Permisos'
        ));
    }

    /**
     * Creates a new permiso entity.
     *
     */
    public function newAction(Request $request) {
        $permiso = new Permiso();
        $form = $this->createForm('AppBundle\Form\PermisoType', $permiso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //Geneerar codigo aleatoriamente:
            $repoPermiso = $em->getRepository('AppBundle:Permiso');
            $permiso->setCodigo($repoPermiso->generarCodigo());

            try {
                $em->persist($permiso);
                $em->flush();

                $this->addFlash('success', 'Nuevo permiso creado correctamente');

                return $this->redirectToRoute('permisos_show', array('id' => $permiso->getId()));
            } catch (UniqueConstraintViolationException $ex) {
                $this->addFlash('error', 'Ocurrió un error al interntar crear un nuevo permiso. Codigo de permiso duplicado.');
            }
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $router = $this->get("router");
        $breadcrumbs->addItem("Inicio", $router->generate("homepage"));
        $breadcrumbs->addItem("Permisos", $router->generate("permisos_index"));
        $breadcrumbs->addItem("NUEVO PERMISO");

        return $this->render('AppBundle:permiso:new.html.twig', array(
                    'permiso' => $permiso,
                    'form' => $form->createView(),
                    'page_title' => 'Permisos - Nuevo permiso'
        ));
    }

    /**
     * Finds and displays a permiso entity.
     *
     */
    public function showAction(Permiso $permiso) {
        $deleteForm = $this->createDeleteForm($permiso);


        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $router = $this->get("router");
        $breadcrumbs->addItem("Inicio", $router->generate("homepage"));
        $breadcrumbs->addItem("Permisos", $router->generate("permisos_index"));
        $breadcrumbs->addItem($permiso, $router->generate("permisos_show", array('id' => $permiso->getId())));
        $breadcrumbs->addItem('VER');


        return $this->render('AppBundle:permiso:show.html.twig', array(
                    'permiso' => $permiso,
                    'delete_form' => $deleteForm->createView(),
                    'page_title' => 'Permisos - Ver permiso'
        ));
    }

    /**
     * Displays a form to edit an existing permiso entity.
     *
     */
    public function editAction(Request $request, Permiso $permiso) {
        $deleteForm = $this->createDeleteForm($permiso);
        
        $editForm = $this->createForm('AppBundle\Form\PermisoType', $permiso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash('success', 'Cambios guardados correctamente.');

            return $this->redirectToRoute('permisos_edit', array('id' => $permiso->getId()));
        }

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $router = $this->get("router");
        $breadcrumbs->addItem("Inicio", $router->generate("homepage"));
        $breadcrumbs->addItem("Permisos", $router->generate("permisos_index"));
        $breadcrumbs->addItem($permiso, $router->generate("permisos_show", array('id' => $permiso->getId())));
        $breadcrumbs->addItem('EDITAR');

        return $this->render('AppBundle:permiso:edit.html.twig', array(
                    'permiso' => $permiso,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'page_title' => 'Permisos - Editar permiso'
        ));
    }

    /**
     * Deletes a permiso entity.
     *
     */
    public function deleteAction(Request $request, Permiso $permiso) {
        $form = $this->createDeleteForm($permiso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($permiso);
            $em->flush();
        }

        return $this->redirectToRoute('permisos_index');
    }

    /**
     * Creates a form to delete a permiso entity.
     *
     * @param Permiso $permiso The permiso entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Permiso $permiso) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('permisos_delete', array('id' => $permiso->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
