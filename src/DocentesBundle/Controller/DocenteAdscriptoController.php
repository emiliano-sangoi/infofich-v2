<?php

namespace DocentesBundle\Controller;

use AppBundle\Entity\Persona;
use DocentesBundle\Entity\DocenteAdscripto;
use DocentesBundle\Form\BuscarAdscriptoType;
use DocentesBundle\Form\DocenteAdscriptoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Docenteadscripto controller.
 *
 */
class DocenteAdscriptoController extends Controller {

    /**
     * Lists all docenteAdscripto entities.
     *
     */
    public function indexAction(Request $request) {

        $dql = "SELECT u FROM DocentesBundle:DocenteAdscripto u";
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);

        //$form = $this->createForm('PlanificacionesBundle\Form\BuscadorType', null);

        $paginator = $this->get('knp_paginator');
        $docentes = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1), /* page number */ 15 /* limit per page */
        );


        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes adscriptos", $this->get("router")->generate("docentes_adscriptos"));


        return $this->render('DocentesBundle:adscriptos:index.html.twig', array(
                    'docentes' => $docentes,
                    'page_title' => 'InfoFICH - Docentes adscriptos',
        ));
    }

    /**
     * Alta de una persona
     * 
     * @param Request $request
     * @return type
     */
    public function newAction(Request $request) {

        $docenteAdscripto = new DocenteAdscripto();
        $form = $this->createForm(DocenteAdscriptoType::class, $docenteAdscripto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            if ($docenteAdscripto->getPersona()->getId()) {
                $persona = $em->merge($docenteAdscripto->getPersona());
                $docenteAdscripto->setPersona($persona);
            }

            $em->persist($docenteAdscripto);
            $em->flush();

            $this->addFlash('success', 'Docente adscripto creado correctamente');

            return $this->redirectToRoute('docentes_adscriptos');

            //return $this->redirectToRoute('docentes_adscriptos_show', array('id' => $docenteAdscripto->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes adscriptos", $this->get("router")->generate("docentes_adscriptos"));
        $breadcrumbs->addItem("Nuevo");

        return $this->render('DocentesBundle:adscriptos:new.html.twig', array(
                    'docenteAdscripto' => $docenteAdscripto,
                    'form' => $form->createView(),
                    'page_title' => 'Docentes adscriptos - Nuevo docente',
        ));
    }

    private function buscarPersona($documento, $tipo_doc) {

        $em = $this->getDoctrine()->getManager();
        $repoPersona = $em->getRepository(Persona::class);
        $persona = $repoPersona->findOneBy(array(
            'tipoDocumento' => $tipo_doc,
            'documento' => $documento,
        ));

        return $persona;
    }

    /**
     * Ver información del docente
     *
     */
    public function showAction(DocenteAdscripto $docenteAdscripto) {

        $deleteForm = $this->createDeleteForm($docenteAdscripto);
        $form = $this->createForm(DocenteAdscriptoType::class, $docenteAdscripto, array(
            'disabled' => true
        ));

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes adscriptos", $this->get("router")->generate("docentes_adscriptos"));
        $breadcrumbs->addItem($docenteAdscripto->__toString());

        return $this->render('DocentesBundle:adscriptos:show.html.twig', array(
                    'docenteAdscripto' => $docenteAdscripto,
                    'delete_form' => $deleteForm->createView(),
                    'form' => $form->createView(),
                    'page_title' => 'Docentes adscriptos - Ver docente',
        ));
    }

    public function editActiodn(Request $request, DocenteAdscripto $docenteAdscripto) {

        $em = $this->getDoctrine()->getManager();

        $editForm = $form = $this->createForm(DocenteAdscriptoType::class, $docenteAdscripto);


        $data = $request->request->get('docentesbundle_docenteadscripto');
        $id = isset($data['persona']['id']) ? $data['persona']['id'] : null;
        $id_prev = $docenteAdscripto->getPersona()->getId();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $id != $id_prev) {
            //  dump($data['persona']['id'], $docenteAdscripto->getPersona()->getId());exit;
            $persona = $em->getRepository(Persona::class)->findOneById($data['persona']['id']);
            $docenteAdscripto->setPersona($persona);
            $em->flush();
        }

        //  return $this->redirectToRoute('docentes_adscriptos_edit', array('id' => $docenteAdscripto->getId()));

        return $this->edit($request, $docenteAdscripto);
    }

    //private function modificarPersonaAction()

    /**
     * Displays a form to edit an existing docenteAdscripto entity.
     *
     */
    public function editAction(Request $request, DocenteAdscripto $docenteAdscripto) {

        $em = $this->getDoctrine()->getManager();

        $deleteForm = $this->createDeleteForm($docenteAdscripto);
        $editForm = $form = $this->createForm(DocenteAdscriptoType::class, $docenteAdscripto);

        $persona_id = $docenteAdscripto->getPersona()->getId();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $persona = $docenteAdscripto->getPersona();

            if ($persona->getId() != $persona_id) {                
                //si se modifico la persona se deben borrar las sentencias SQL pendientes para
                //que no intente actualizar los campos de la persona que tenia seteada previamente.
                $em->clear();
                
                
                //luego se graban los cambios que haya modificado el usuario en el form en el objeto de la base de datos
                $docenteAdscripto = $em->merge($docenteAdscripto);
                
                //guardar cambios en la base de datos
                $em->flush();

                //volver a llamar al metodo ahora con la entidad modificada correctamente
                return $this->editAction($request, $docenteAdscripto);
            }

            $em->flush();

            $this->addFlash('success', 'Docente modificado correctamente.');

            return $this->redirectToRoute('docentes_adscriptos_show', array('id' => $docenteAdscripto->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes adscriptos", $this->get("router")->generate("docentes_adscriptos"));
        $breadcrumbs->addItem($docenteAdscripto->__toString(), $this->get("router")->generate("docentes_adscriptos_show", array('id' => $docenteAdscripto->getId())));
        $breadcrumbs->addItem('Editar');

        return $this->render('DocentesBundle:adscriptos:edit.html.twig', array(
                    'docenteAdscripto' => $docenteAdscripto,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'page_title' => 'Docentes adscriptos - Editar docente',
        ));
    }

    /**
     * Deletes a docenteAdscripto entity.
     *
     */
    public function deleteAction(Request $request, DocenteAdscripto $docenteAdscripto) {
        $form = $this->createDeleteForm($docenteAdscripto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($docenteAdscripto);
            $em->flush();
        }

        return $this->redirectToRoute('docentes_adscriptos');
    }

    /**
     * Creates a form to delete a docenteAdscripto entity.
     *
     * @param DocenteAdscripto $docenteAdscripto The docenteAdscripto entity
     *
     * @return Form The form
     */
    private function createDeleteForm(DocenteAdscripto $docenteAdscripto) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('docentes_adscriptos_delete', array('id' => $docenteAdscripto->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
