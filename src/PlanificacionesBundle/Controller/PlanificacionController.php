<?php

namespace PlanificacionesBundle\Controller;

use AppBundle\Seguridad\Permisos;
use AppBundle\Util\Texto;
use Doctrine\ORM\QueryBuilder;
use FICH\APIInfofich\Model\Carrera;
use FICH\APIInfofich\Model\Materia;
use PlanificacionesBundle\Entity\Estado;
use PlanificacionesBundle\Entity\HistoricoEstados;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Entity\PlanificacionDocenteAdscripto;
use PlanificacionesBundle\Entity\PlanificacionDocenteColaborador;
use PlanificacionesBundle\Form\BuscadorType;
use PlanificacionesBundle\Form\PlanificacionType;
use PlanificacionesBundle\Repository\HistoricoEstadosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use function dump;

class PlanificacionController extends Controller {

    private $resumen;
    private $infofichService;

    public function indexAction(Request $request) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_LISTAR, array('data' => null));

        $form_filtros = $this->createForm(BuscadorType::class, null);
        $form_filtros->handleRequest($request);

        $query = $this->buildQuery($form_filtros);

        // $form = $this->createForm('PlanificacionesBundle\Form\BuscadorType', null);

        $paginator = $this->get('knp_paginator');
        $paginado = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1), /* page number */ 10 /* limit per page */
        );

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("PLANIFICACIONES");


        return $this->render('PlanificacionesBundle:planificacion:inicio.html.twig', array(
                    'page_title' => 'Planificaciones de grado',
                    'form' => $form_filtros->createView(),
                    'paginado' => $paginado,
                    'puede_crear' => $this->isGranted(Permisos::PLANIF_CREAR, array('data' => null))
        ));
    }

    private function buildQuery(Form $form_filtros) {

        $em = $this->getDoctrine()->getManager();

        /* @var $qb QueryBuilder */
        $qb = $em->getRepository(Planificacion::class)->createQueryBuilder('p');

        $anioAcad = $form_filtros->get('anioAcad')->getData();
        if ($anioAcad) {
            $qb->andWhere($qb->expr()->eq('p.anioAcad', ':anioAcad'));
            $qb->setParameter(':anioAcad', $anioAcad);
        }

        $carrera = $form_filtros->get('carrera')->getData();
        if ($carrera) {
            $qb->andWhere($qb->expr()->eq('p.carrera', ':carrera'));
            $qb->setParameter(':carrera', $carrera);
        }

        $codigoAsignatura = $form_filtros->get('codigoAsignatura')->getData();
        if ($codigoAsignatura) {
            $qb->andWhere($qb->expr()->eq('p.codigoAsignatura', ':codigoAsignatura'));
            $qb->setParameter(':codigoAsignatura', $codigoAsignatura);
        }

        return $qb->getQuery();
    }

    /**
     * 
     * 
     * @param Request $request
     * @return type
     */
    public function newAction(Request $request) {

        $this->denyAccessUnlessGranted(Permisos::PLANIF_CREAR, array('data' => null));

        $planificacion = new Planificacion();
        $form = $this->createForm(PlanificacionType::class, $planificacion, array(
            'api_infofich_service' => $this->get('api_infofich_service')
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //nombre de la asignatura:      
            $asignatura = $this->get('api_infofich_service')->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
            $nombreAsignatura = Texto::ucWordsCustom($asignatura->getNombreMateria());
            $planificacion->setNombreAsignatura($nombreAsignatura);


            $em = $this->getDoctrine()->getManager();
            $em->persist($planificacion);
            $em->flush();

            //asignar estado: creada + en preparacion
            //---------------------------------------------------------------------------
            /* @var $repoHistorico HistoricoEstadosRepository */
            $repoHistorico = $em->getRepository(HistoricoEstados::class);

            $usuario = $this->getUser();
            $repoHistorico->setEstadoCreada($planificacion, $usuario);
            $repoHistorico->asignarEstado($planificacion, Estado::PREPARACION, null);
            //---------------------------------------------------------------------------

            $this->addFlash('success', 'La planificacion fué creada correctamente.');

            //Causar redireccion para evitar "re-submits" del form:
            return $this->redirectToRoute('planif_info_basica_editar', array('id' => $planificacion->getId()));
        }

        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem("NUEVA");


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
        $asignatura = $this->infofichService->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        $page_title = Texto::ucWordsCustom($asignatura->getNombreMateria());

        $this->addInfoBasica($planificacion);
        $this->addDocentes($planificacion);
        // validación datos cargados
        $requisitos = $planificacion->getRequisitosAprobacion();
        if (isset($requisitos)) {
            $this->addRequisitos($planificacion);
            $this->resumen['ver_requisitos'] = 1;
        } else {
            $this->resumen['ver_requisitos'] = 0;
        }
        $this->addObjetivos($planificacion);
        //Resultados
        $resultados = $planificacion->getResultados();
        if (isset($resultados)) {
            $this->resumen['ver_resultados'] = 1;
            $this->addResultados($planificacion);
        } else {
            $this->resumen['ver_resultados'] = 0;
        }

        $this->addTemario($planificacion);
        $this->addBibliografia($planificacion);
        $this->addCronograma($planificacion);
        $this->addDistribucion($planificacion);
        $this->addViaje($planificacion);



        // Breadcrumbs
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("homepage"));
        $breadcrumbs->addItem("Planificaciones", $this->get("router")->generate("planificaciones_homepage"));
        $breadcrumbs->addItem($planificacion);
        $breadcrumbs->addItem("REVISAR");


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


        /* Carrera {#796 ▼
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
        /* Materia {#787 ▼
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
        $asignatura = $this->infofichService->getAsignatura($planificacion->getCarrera(), $planificacion->getCodigoAsignatura());
        if ($asignatura instanceof Materia) {
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

        if ($planificacion->getDocenteResponsable()) {
            $this->resumen['docente_resp'] = $planificacion->getDocenteResponsable()->getCodApeNom(true);
        }

        $this->resumen['docentes_colab'] = null;
        $i = 0;
        /* @var $docente PlanificacionDocenteColaborador */
        foreach ($planificacion->getDocentesColaboradores() as $docente) {
            $this->resumen['docentes_colab'][] = $docente->getDocenteGrado()->getCodApeNom(true);
            $i++;
        }
        $this->resumen['docentes_colab_count'] = $i;


        $this->resumen['docentes_adscriptos'] = null;
        $i = 0;
        /* @var $docente PlanificacionDocenteAdscripto */
        foreach ($planificacion->getDocentesAdscriptos() as $docente) {
            $cod_ape_nom = $docente->getDocenteAdscripto()->__toString();
            // dump($cod_ape_nom, $docente->getDocente());exit;
            $cod_ape_nom .= ' (Resolución N° ' . $docente->getDocenteAdscripto()->getResolucion() . ')';
            $this->resumen['docentes_adscriptos'][] = $cod_ape_nom;
            $i++;
        }
        $this->resumen['docentes_adscriptos_count'] = $i;

        //  dump($this->resumen);exit;
    }

    /**
     * 
     * @param Planificacion $planificacion
     */
    private function addRequisitos(Planificacion $planificacion) {

        $requisitos = $planificacion->getRequisitosAprobacion();

        $this->resumen['porcentajeAsistencia'] = null;
        $this->resumen['fechaPrimerParcial'] = null;
        $this->resumen['fechaSegundoParcial'] = null;
        $this->resumen['fechaRecupPrimerParcial'] = null;
        $this->resumen['fechaRecupSegundoParcial'] = null;
        $this->resumen['prevePromParcialTeoria'] = null;
        $this->resumen['prevePromParcialPractica'] = null;
        $this->resumen['preveCfi'] = null;
        $this->resumen['modalidadCfi'] = null;
        $this->resumen['fechaParcialCfi'] = null;
        $this->resumen['fechaRecupCfi'] = null;
        $this->resumen['examenFinalModalidadRegulares'] = null;
        $this->resumen['examenFinalModalidadLibres'] = null;

        if ($requisitos) {
            $this->resumen['porcentajeAsistencia'] = $requisitos->getPorcentajeAsistencia();
            //parciales y recuperatorios
            $this->resumen['fechaPrimerParcial'] = $requisitos->getFechaPrimerParcial();
            $this->resumen['fechaSegundoParcial'] = $requisitos->getFechaSegundoParcial();

            $this->resumen['fechaRecupPrimerParcial'] = $requisitos->getFechaRecupPrimerParcial();
            $this->resumen['fechaRecupSegundoParcial'] = $requisitos->getFechaRecupSegundoParcial();

            if ($requisitos->getPrevePromParcialTeoria()) {
                $this->resumen['prevePromParcialTeoria'] = 'Sí promociona la teoría';
            } else {
                $this->resumen['prevePromParcialTeoria'] = 'No promociona la teoría';
            }

            if ($requisitos->getPrevePromParcialPractica()) {
                $this->resumen['prevePromParcialPractica'] = 'Sí promociona la práctica';
            } else {
                $this->resumen['prevePromParcialPractica'] = 'No promociona la práctica';
            }

            if ($requisitos->getPreveCfi()) {
                $this->resumen['preveCfi'] = 'Sí';
            } else {
                $this->resumen['preveCfi'] = 'No';
            }

            $this->resumen['modalidadCfi'] = $requisitos->getModalidadCfi();
            $this->resumen['fechaParcialCfi'] = $requisitos->getFechaParcailCfi();
            $this->resumen['fechaRecupCfi'] = $requisitos->getFechaRecupCfi();

            $this->resumen['examenFinalModalidadRegulares'] = $requisitos->getExamenFinalModalidadRegulares();
            $this->resumen['examenFinalModalidadLibres'] = $requisitos->getExamenFinalModalidadLibres();
        }
    }

    /**
     * 
     * @param Planificacion $planificacion
     */
    private function addObjetivos(Planificacion $planificacion) {
        $this->resumen['objetivosGral'] = null;
        $this->resumen['objetivosEspecificos'] = null;

        $this->resumen['objetivosGral'] = $planificacion->getObjetivosGral();
        $this->resumen['objetivosEspecificos'] = $planificacion->getObjetivosEspecificos();
    }

    /**
     * 
     * @param Planificacion $planificacion
     */
    private function addResultados(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['resultados'] = null;
        $resultados = $planificacion->getResultados();
        $this->resumen['resultados'] = $resultados;
    }

    /**
     * 
     * @param Planificacion $planificacion
     */
    private function addTemario(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['temario'] = null;
        $temario = $planificacion->getTemario();
        $this->resumen['temario'] = $temario;
    }

    /**
     * 
     * @param Planificacion $planificacion
     */
    private function addBibliografia(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['bibliografia'] = null;
        $bibliografia = $planificacion->getBibliografiasPlanificacion();      
        $this->resumen['bibliografia'] = $bibliografia;
    }

    /**
     * 
     * @param Planificacion $planificacion
     */
    private function addCronograma(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['cronograma'] = null;
        $cronograma = $planificacion->getActividadCurricular();
        $this->resumen['cronograma'] = $cronograma;
        //dump($cronograma);
    }

    /**
     * 
     * @param Planificacion $planificacion
     */
    private function addDistribucion(Planificacion $planificacion) {
        $this->resumen['totalCargaHorariaAula'] = $planificacion->getTotalCargaHorariaAula();
        $this->resumen['totalCargaHorariaAutonomo'] = $planificacion->getTotalCargaHorariaAutonomo();
        $this->resumen['totalTeoria'] = $planificacion->getTotalTeoria();
        $this->resumen['totalColoquio'] = $planificacion->getTotalColoquio();
        $this->resumen['totalTeoricoPractica'] = $planificacion->getTotalTeoricoPractica();
        $this->resumen['totalFormacionPractica'] = $planificacion->getTotalFormacionPractica(); 
        $this->resumen['totalConsulta'] = $planificacion->getTotalConsulta();
        $this->resumen['totalEvaluacion'] = $planificacion->getTotalEvaluacion();
        $this->resumen['totalOtrasAct'] = $planificacion->getTotalOtrasAct();
    }

    /**
     * 
     * @param Planificacion $planificacion
     */
    private function addViaje(Planificacion $planificacion) {
        //ver esto con Emi
        $this->resumen['viajes'] = null;
        $viajes = $planificacion->getViajesAcademicos();
        $this->resumen['viajes'] = $viajes;
    }

}
