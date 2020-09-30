<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Util\Texto;
use FICH\APIInfofich\Model\Carrera;
use FICH\APIInfofich\Model\Materia;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\Planificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PlanificacionController extends Controller {

    private $resumen;
    private $infofichService;

    public function indexAction(Request $request) {

        return $this->render('PlanificacionesBundle:planificacion:inicio.html.twig');
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function newAction(Request $request) {

        $planificacion = new Planificacion();
        $form = $this->createForm("PlanificacionesBundle\Form\PlanificacionType", $planificacion, array(
            'api_infofich_service' => $this->get('api_infofich_service')
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($planificacion);
            $em->flush();

            //asignar estado:
            $repoHistorico = $em->getRepository('\PlanificacionesBundle\Entity\HistoricoEstados');
            $repoHistorico->asignarEstado($planificacion, Estado::PREPARACION);

            $this->addFlash('success', 'La planificacion creada correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $planificacion->getId()));
        }


        return $this->render('PlanificacionesBundle:1-info-basica:edit.html.twig', array(
                    'form' => $form->createView(),
                    'info_basica_route' => $this->generateUrl('planificaciones_nueva'),
                    'planificacion' => $planificacion,
                    'page_title' => 'Nueva planificación'
        ));
    }

    /**
     * Muestra el contenido cargado de la planificacion.
     * 
     * @param Request $request
     * @return type
     */
    public function revisarAction(Request $request, Planificacion $planificacion) {

        $this->resumen = array();
        $this->infofichService = $this->get('api_infofich_service');

        //titulo principal:      
        $asignatura = $this->infofichService->getAsignatura($planificacion->getCarrera(), $planificacion->getAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());

        $this->addInfoBasica($planificacion);
        $this->addDocentes($planificacion);


        //dump($planificacion->getDocenteResponsable()->getDocente()->getPersona()->getApellidos());exit;
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:planificacion:revisar.html.twig', array(
                    'planificacion' => $planificacion,
                    'asignatura' => $asignatura,
                    'page_title' => $page_title,
                    'resumen' => $this->resumen
        ));
    }

    public function showNotificacionAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('PlanificacionesBundle:planificacion:mensaje.html.twig');
        //, array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),));
    }

    /**
     * Funcion auxiliar que busca y valida los campos a mostrar en el resumen.
     * Se encarga de asugar que los campos necesarios esten seteados, con valores o null en su defecto.
     * Tambien les da el formato final a utilizar en la twig.
     * 
     * @param Planificacion $planificacion
     */
    private function addInfoBasica(Planificacion $planificacion) {

        $this->resumen['carrera'] = null;
        $this->resumen['carrera_plan'] = null;
        $this->resumen['anioAcad'] = $planificacion->getAnioAcad();
        $this->resumen['nombreMateria'] = null;
        $this->resumen['contenidosMinimos'] = $planificacion->getContenidosMinimos();
        
        
        /*Carrera {#796 ▼
            #codigoCarrera: "03"
            #nombreCarrera: "INGENIERÍA EN INFORMÁTICA"
            #planCarrera: "2006"
            #versionPlan: "29"
            #estado: "V"
            #tipoTitulo: 1
            #tipoCarrera: "Grado"
        */
        //obtiene las carreras de grado de la fich:       
        $carrera = $this->infofichService->getCarrera($planificacion->getCarrera());
        if ($planificacion->getCarrera() && $carrera instanceof Carrera) {
            $this->resumen['carrera'] = $planificacion->getCarrera() . ' - ' . $carrera->getNombreCarrera();
            $this->resumen['carrera_plan'] = $carrera->getPlanCarrera();
        }
        
        //Ejemplo de campos de una materia:
        /*Materia {#787 ▼
                    #codigoMateria: "00716"
                    #nombreMateria: "INTELIGENCIA ARTIFICIAL"
                    #tipoMateria: "O"
                    #horasSemanales: null
                    #cargaHoraria: null
                    #valorMateria: "60"
                    #promediable: true
                    #obligatoria: false
                }
         */
        $asignatura = $this->infofichService->getAsignatura($planificacion->getCarrera(), $planificacion->getAsignatura());
        if($asignatura instanceof Materia){
            $this->resumen['nombreMateria'] = $asignatura->getNombreMateria();
        }
    }
    
    /**
     * Funcion auxiliar que busca y valida los campos a mostrar en el resumen.
     * Se encarga de asugar que los campos necesarios esten seteados, con valores o null en su defecto.
     * Tambien les da el formato final a utilizar en la twig.
     * 
     * @param Planificacion $planificacion
     */
    private function addDocentes(Planificacion $planificacion) {
        
        $this->resumen['docente_resp'] = null;
        
        if($planificacion->getDocenteResponsable()){            
            $this->resumen['docente_resp'] = $planificacion->getDocenteResponsable()->getDocente()->getCodApeNom(true);                        
        }
        
        $this->resumen['docentes_colab'] = null;
        $i = 0;
        foreach ($planificacion->getDocentesColaboradores() as $docente){
            $this->resumen['docentes_colab'][] = $docente->getDocente()->getCodApeNom(true);
            $i++;
        }
        $this->resumen['docentes_colab_count'] = $i;
        
        
        $this->resumen['docentes_adscriptos'] = null;
        $i = 0;
        //dump($planificacion->getDocentesAdscriptos()->toArray());exit;
        foreach ($planificacion->getDocentesAdscriptos() as $docente){
            $cod_ape_nom = $docente->getDocente()->getCodApeNom(true);
           // dump($cod_ape_nom, $docente->getDocente());exit;
            $cod_ape_nom .= ' (Resolución N° ' . $docente->getResolucion() . ')';
            $this->resumen['docentes_adscriptos'][] = $cod_ape_nom;
            $i++;
        }
        $this->resumen['docentes_adscriptos_count'] = $i;
        
      //  dump($this->resumen);exit;
    }

}
