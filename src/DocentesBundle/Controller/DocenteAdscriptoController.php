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

    public function buscarAction(Request $request) {

        $form = $this->createForm(BuscarAdscriptoType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tipo_doc = $form->get('tipoDocumento')->getData();
            $documento = $form->get('documento')->getData();
            $resolucion = $form->get('resolucion')->getData();


            $em = $this->getDoctrine()->getManager();
            $repoPersona = $em->getRepository(Persona::class);
            $persona = $repoPersona->findOneBy(array(
                'tipoDocumento' => $tipo_doc,
                'documento' => $documento,
            ));

            $repoAdscriptos = $em->getRepository(DocenteAdscripto::class);
            $docente = $repoAdscriptos->findOneBy(array(
                'tipoDocumento' => $tipo_doc,
                'persona' => $documento,
            ));
            if ($resolucion) {
                
            }

            if ($persona instanceof Persona) {
                
            } else {
                
            }

            dump($tipo_doc, $documento, $resolucion);
            exit;
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes adscriptos", $this->get("router")->generate("docentes_adscriptos"));
        $breadcrumbs->addItem("Buscar");

        return $this->render('DocentesBundle:adscriptos:buscar.html.twig', array(
                    'form' => $form->createView(),
                    'page_title' => 'Docentes adscriptos - Buscar docente',
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
            
            if( $docenteAdscripto->getPersona()->getId() ){
                $persona = $em->merge( $docenteAdscripto->getPersona() );
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
        
        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Docentes adscriptos", $this->get("router")->generate("docentes_adscriptos"));
        $breadcrumbs->addItem("Ver");

        return $this->render('DocentesBundle:adscriptos:show.html.twig', array(
                    'docenteAdscripto' => $docenteAdscripto,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing docenteAdscripto entity.
     *
     */
    public function editAction(Request $request, DocenteAdscripto $docenteAdscripto) {
        $deleteForm = $this->createDeleteForm($docenteAdscripto);
        $editForm = $this->createForm('DocentesBundle\Form\DocenteAdscriptoType', $docenteAdscripto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('docentes_adscriptos_edit', array('id' => $docenteAdscripto->getId()));
        }

        return $this->render('docenteadscripto/edit.html.twig', array(
                    'docenteAdscripto' => $docenteAdscripto,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
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

        return $this->redirectToRoute('docentes_adscriptos_index');
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
