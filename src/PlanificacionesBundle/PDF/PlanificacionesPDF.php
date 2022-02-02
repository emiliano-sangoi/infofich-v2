<?php

namespace PlanificacionesBundle\PDF;
use PlanificacionesBundle\Entity\ImprimirPDF;

/**
 * Description of PlanificacionesPDF
 *
 * @author rgalarza
 */
class PlanificacionesPDF extends ImprimirPDF {

    public function __construct($parametros) {

        parent::__construct($parametros);
        $this->parametros = $parametros;

        $this->setPrintHeader(true);
        
        $this->SetMargins(PDF_MARGIN_LEFT, 69, PDF_MARGIN_RIGHT);

    }

    public function Header() {

        parent::Header();
        
        $fontSize = 9;

        $x0 = PDF_MARGIN_LEFT;

        $est1 = array('width' => 0.1, 'join' => 'round', 'dash' => 0, 'color' => array(0, 0, 0));
        $c1 = array(204, 204, 204); //color gris de relleno definido con 3 valores es interpretado como RGB
        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // Título (Relleno)
        $this->RoundedRect($x0, 43, 190, 8, 4, $round_corner = '0000', $style = 'F', $est1, $c1);

        
        // Título (texto)
        $this->CreateTextBox('PLANIFICACIÓN '. $this->parametros['anio'], $x0, 45, 180, 0, 10, 'B', 'C');

        
        // Dibuja las cabeceras de la tabla
        /*$this->SetXY($x0, 62);
        $header = isset($this->parametros['tabla_cab']) ? $this->parametros['tabla_cab'] : array();
        $widthColumn = array(17, 12, 23, 44, 18, 19, 19, 19, 19);
        $this->createHeaderTable($header, $widthColumn);*/
    }

    public function render() {
        $border = 0;
        $this->SetFontSize(6);

        $this->addPage();


        // print a line of text
    
    $fontSize = 9;
    
    $html = '<h1>INFORMACIÓN BÁSICA</h1>';
    // INFORMACION BASICA
    $html .= '<p><b>Asignatura: </b>'.$this->parametros['nombreAsignatura'] .'</p>';
    $html .= '<p><b>Carrera:  </b>' . $this->parametros['nombreCarrera'].'</p>';
    $html .= '<p><b>Año Cursada:  </b>' . $this->parametros['anioCursada'].'</p>';
    $html .= '<p><b>Plan Estudios:  </b>'. $this->parametros['planEstudio'].'</p>';
    $html .= '<p><b>Departamento:  </b>' . $this->parametros['departamento'].'</p>';
    $html .= '<p><b>Período:  </b>'. $this->parametros['periodoLectivo'].'</p>';
    $html .= '<p><b>Carácter: </b>' .$this->parametros['caracter'].'</p>';
    $html .= '<p><b>Contenidos Mínimos: </b>' . $this->parametros['contenidosMinimos'].'</p>';

    // Equipo Docente:
    $html .= '<h1>EQUIPO DOCENTE</h1>';
      
    $html .= '<p><b>Docente Responsable: </b>' . $this->parametros['docenteResponsable'] .'</p>';
    $html .= '<p><b>Docentes Colaboradores: </b>';

    $docentesColaboradores = $this->parametros['docentesColaboradores'];
    if($docentesColaboradores){
        foreach ($docentesColaboradores as $docentesColaborador){
            $html .= '<p>' . $docentesColaborador . '</p>';        
        }
    }
    $html .='</p>';
    $html .= '<p><b>Docentes Adscriptos: </b>';
    $docentesAdscriptos = $this->parametros['docentesAdscriptos'];
    if($docentesAdscriptos){
        foreach ($docentesAdscriptos as $docentesAdscripto){
            $html .= '<p>' . $docentesAdscripto . '</p>';
         
        }
    }
    $html .='</p>';

    $html .= '<h1>APROBACION ASIGNATURA </h1>';
    $html .= '<p><b>Porcentaje Asistencia:: </b>' . $this->parametros['porcentajeAsistencia']. '</p>';
    $html .= '<p><b>Modalidad CFI:  </b> '. $this->parametros['modalidadCfi'] . '</p>';
        
    $html .= '<h1>OBJETIVOS ASIGNATURA </h1>'; 

    $html .= '<p><b>Objetivos Específicos: </b> ' . $this->parametros['objetivosEspe']. '</p>';
    $html .= '<p><b>Objetivos Generales: : </b> '. $this->parametros['objetivosGral']. '</p>';

    //Resultados de  Aprendizaje
    $html .= '<h1>RESULTADOS APRENDIZAJE </h1>'; 
    
    $resultados = $this->parametros['resultados'];
    if($resultados){
        foreach ($resultados as $resultado){
            $html .= '<p><b>Resultado : </b> '. $resultado. '</p>';
    
        }
    }
    
    //Temario
    $html .= '<h1>TEMARIO </h1>'; 
    $temario = $this->parametros['temario'];
    if($temario){
        foreach ($temario as $tema){
            $html .= '<p><b>Nro Unidad:  : </b> '. $tema->getUnidad(). '</p>';
            $html .= '<p><b>Titulo:  : </b> '. $tema->getTitulo(). '</p>';
            $html .= '<p><b>Contenido:  : </b> '. $tema->getContenido(). '</p>';
        }
    }

    //TODO: Bibliografia
    $html .= '<h1>BIBLIOGRAFIA </h1>'; 
    /*$bibliografia = $this->parametros['bibliografia'];
    if($bibliografia){
                foreach ($bibliografia as $biblio){
                    $html .= '<p><b>Título: </b> '. $biblio->getTitulo(). '</p>';
                    $html .= '<p><b>Autores: </b> '. $biblio->getAutores(). '</p>';
                    $html .= '<p><b>Editorial: </b> '. $biblio->getEditorial(). '</p>';
                    $html .= '<p><b>Añio de Edición: </b> '. $biblio->getAnioEdicion(). '</p>';
                    $html .= '<p><b>Nro de Edicion: </b> '. $biblio->getNroEdicion(). '</p>';
                    $html .= '<p><b>ISSN-ISBN: </b> '. $biblio->getIssnIsbn(). '</p>';                  
                
                }
            }
        
*/
        //Actividades
        $actividades = $this->parametros['actividades'];
        $html .= '<h1>ACTIVIDADES CURRICULARES </h1>'; 
        if($actividades){
            foreach ($actividades as $actividad){
                $html .= '<p><b>Unidad: </b> '. $actividad->getTemario(). '</p>';
                $html .= '<p><b>Tipo de Clase: </b> '. $actividad->getTipoActividadCurricular(). '</p>';
                $html .= '<p><b>Fecha: $actividad->getFecha() </b></p>';
                $html .= '<p><b>Descripcion: </b> '. $actividad->getDescripcion(). '</p>';
                $html .= '<p><b>Carga Horaria Aula: </b> '. $actividad->getCargaHorariaAula(). '</p>';
                $html .= '<p><b>Carga Horaria Autonomo:: </b> '. $actividad->getCargaHorariaAutonomo(). '</p>';
            }
        }

        //Viajes Academicos
        $viajesAcademicos = $this->parametros['viajesAcademicos'];
        $html .= '<h1>VIAJES ACADEMICOS </h1>'; 
        if($viajesAcademicos){
            foreach ($viajesAcademicos as $viaje){
                $html .= '<p><b>Descripcion: </b> '. $viaje->getDescripcion(). '</p>';
                $html .= '<p><b>Objetivos: </b> '. $viaje->getObjetivos(). '</p>';
                $html .= '<p><b>Recorrido: </b> '. $viaje->getRecorrido(). '</p>';
                $html .= '<p><b>Cantidad Estudiantes: </b> '. $viaje->getCantEstudiantes(). '</p>';
                $html .= '<p><b>Cantidad Docentes: </b> '. $viaje->getCantDocentes(). '</p>';
                $html .= '<p><b>Fecha Tentativa: </b> . $viaje->getFechaTentativa(). </p>';
                $html .= '<p><b>fecha Tentativa Regreso: $actividad->getFechaTentativaRegreso(): </b></p>';
             
            }
        }
        
        
    $this->writeHTML($html, true, 0, true, 0);

/*

    



        // Dibuja el detalle de la tabla
        /*$this->SetXY($x0, 69);
        $data = isset($this->parametros['tabla_det']) ? $this->parametros['tabla_det'] : array();
        $widthColumn = array(array(17,'L'), array(12,'L'), array(23,'L'), array(44,'L'), array(18,'L'), array(19,'R'), array(19,'R'), array(19,'R'), array(19,'R'));
        $this->createDataTable($data, $widthColumn);
        
        $y = $this->GetY();
        $est1 = array('width' => 0.1, 'join' => 'round', 'dash' => 0, 'color' => array(0, 0, 0));
        $c1 = array(204, 204, 204); //color gris de relleno definido con 3 valores es interpretado como RGB
        // Título (Relleno)
        $this->RoundedRect($x0, $y + 5, 190, 8, 4, $round_corner = '0000', $style = 'F', $est1, $c1);

        // Título (texto)
        $this->CreateTextBox('Cantidad de registros informados: 2' , $x0, $y + 7, 180, 0, 9, 'B', 'L', 1);
//        $this->CreateTextBox(count($this->parametros['tabla_det']), $x0+160, $y + 7, 20, 0, 9, 'B', 'R', 1);*/
    }

}

