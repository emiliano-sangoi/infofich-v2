<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rol;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RolController extends Controller {

    public function indexAction(Request $request) {

        $dql = "SELECT r FROM AppBundle:Rol r";
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $rols = $paginator->paginate(
                $query, $request->query->getInt('page', 1), 10
        );

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("ROLES");

        return $this->render('AppBundle:rol:index.html.twig', array(
                    'rols' => $rols,
                    'page_title' => 'Roles'
        ));
    }

    public function newAction(Request $request) {
        $rol = new Rol();
        $form = $this->createForm('AppBundle\Form\RolType', $rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                                               
            $em = $this->getDoctrine()->getManager();
            $em->persist($rol);
            $em->flush();
            
            $this->addFlash('success', 'Nuevo rol creado correctamente');

            return $this->redirectToRoute('rol_show', array('id' => $rol->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Roles", $this->get("router")->generate("rol_index"));
        $breadcrumbs->addItem("NUEVO ROL");


        return $this->render('AppBundle:rol:new.html.twig', array(
                    'rol' => $rol,
                    'page_title' => 'Nuevo rol',
                    'form' => $form->createView(),
        ));
    }

    public function showAction(Rol $rol) {
        $deleteForm = $this->createDeleteForm($rol);

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $router = $this->get("router");
        $breadcrumbs->addItem("Inicio", $router->generate("homepage"));
        $breadcrumbs->addItem("Roles", $router->generate("rol_index"));
        $breadcrumbs->addItem($rol, $router->generate("rol_show", array('id' => $rol->getId())));        
        $breadcrumbs->addItem('VER');

        return $this->render('AppBundle:rol:show.html.twig', array(
                    'rol' => $rol,
                    'page_title' => $rol . ' - Ver',
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction(Request $request, Rol $rol) {
        $deleteForm = $this->createDeleteForm($rol);
        $editForm = $this->createForm('AppBundle\Form\RolType', $rol);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Cambios guardados correctamente.');
            
            return $this->redirectToRoute('rol_edit', array('id' => $rol->getId()));
        }


        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Roles", $this->get("router")->generate("rol_index"));
        $breadcrumbs->addItem($rol, $this->get("router")->generate("rol_show", array('id' => $rol->getId())));
        $breadcrumbs->addItem('EDITAR');

        return $this->render('AppBundle:rol:edit.html.twig', array(
                    'rol' => $rol,
                    'page_title' => $rol . ' - Editar',
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction(Request $request, Rol $rol) {
        $form = $this->createDeleteForm($rol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rol);
            $em->flush();
            
            $this->addFlash('success', 'Rol borrado correctamente.');
        }

        return $this->redirectToRoute('rol_index');
    }

    /**
     * Creates a form to delete a rol entity.
     *
     * @param Rol $rol The rol entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rol $rol) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('rol_delete', array('id' => $rol->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
    
    
    /**
     * Devuelve los permisos que posee un rol.
     * 
     * @param Rol $rol
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getRolAsJsonAction(Rol $rol){
        
        return new \Symfony\Component\HttpFoundation\JsonResponse($rol);
        
    }

}
