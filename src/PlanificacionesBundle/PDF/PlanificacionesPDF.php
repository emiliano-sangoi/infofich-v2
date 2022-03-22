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
        $this->CreateTextBox('PLANIFICACIÓN ' . $this->parametros['anio'], $x0, 45, 180, 0, 10, 'B', 'C');


        // Dibuja las cabeceras de la tabla
        /* $this->SetXY($x0, 62);
          $header = isset($this->parametros['tabla_cab']) ? $this->parametros['tabla_cab'] : array();
          $widthColumn = array(17, 12, 23, 44, 18, 19, 19, 19, 19);
          $this->createHeaderTable($header, $widthColumn); */
    }

    public function render() {
        $border = 0;
        $this->SetFontSize(6);

        $this->addPage();


        // print a line of text

        $fontSize = 9;

        
        $html = '<h1>INFORMACIÓN BÁSICA</h1>';
        // INFORMACION BASICA

$html .= '<table cellspacing="0" cellpadding="1">
<tr>
    <td><b>Asignatura</b></td>
    <td><b>Carrera </b></td>
    <td><b>Año academico </b></td>
    <td><b>Plan de Estudios </b></td>

</tr>
<tr>
    <td >' . $this->parametros['nombreAsignatura'] . '</td>
    <td> ' . $this->parametros['nombreCarrera'] .  '</td>
    <td> ' . $this->parametros['anio'] .  '</td>
    <td> ' . $this->parametros['planEstudio'] .  '</td>
</tr>
<tr><td></td></tr>
<tr>
    <td><b>Departamento</b></td>
    <td><b>Periodo Lectivo </b></td>
    <td><b>Caracter</b> </td>
    <td><b>Año Cursada</b></td>

</tr>
<tr>
    <td >' . $this->parametros['departamento'] . '</td>
    <td> ' . $this->parametros['periodoLectivo'] .  '</td>
    <td> ' . $this->parametros['caracter'] .  '</td>
    <td> ' . $this->parametros['anioCursada'] .  '</td>
</tr>

</table>';

$html .= '<p><b>Contenidos Minimos</b></p>
          <p>' . $this->parametros['contenidosMinimos'] . '</p>';

          // Equipo Docente:
        $html .= '<h1>EQUIPO DOCENTE</h1>';

        $html .= '<table cellspacing="0" cellpadding="1">
<tr>
    <td><b>Docente Responsable</b></td>
</tr>
<tr><td>' . $this->parametros['docenteResponsable'] . '</td></tr>

<tr><td><b>Docentes Colaboradores</b></td></tr>

<tr><td>';
        $docentesColaboradores = $this->parametros['docentesColaboradores'];
        if ($docentesColaboradores) {
            foreach ($docentesColaboradores as $docentesColaborador) {
                $html .= $docentesColaborador . '<br>';
            }
        }

        $html .=  '</td></tr>

        <tr><td><b>Docentes Adscriptos</b></td></tr>

        <tr><td>';
        $docentesAdscriptos = $this->parametros['docentesAdscriptos'];
        if ($docentesAdscriptos) {
            foreach ($docentesAdscriptos as $docentesAdscripto) {
                $html .= $docentesAdscripto . '<br>';
            }
        }
                $html .=  '</td></tr>

</table>';


        $html .= '<h1>APROBACION ASIGNATURA </h1>
        <table cellspacing="0" cellpadding="1">
        <tr>
            <td><b>Aprobacion</b></td>
            <td><b>Asistencia</b></td>        
            <td><b>Primer Parcial </b></td> 
            <td><b>Segundo Parcial </b></td>

        </tr>
        <tr>
            <td></td>
            <td>' . $this->parametros['porcentajeAsistencia'] . '%</td>
            <td>'. $this->parametros['fechaPrimerParcial']->format("d/m/Y") . '</td>
            <td>'. $this->parametros['fechaSegundoParcial']->format("d/m/Y") . '</td>            
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><b>Recuperatorio 1er. parcial</b></td>
            <td><b>Recuperatorio 2do. parcial</b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>'. $this->parametros['fechaRecupPrimerParcial']->format("d/m/Y") . '</td>
            <td>'. $this->parametros['fechaRecupSegundoParcial']->format("d/m/Y") . '</td>
        </tr>
        </table>';
        //<td>' . $this->parametros['modalidadCfi'] . '</td>
        $html .= '<h1>OBJETIVOS ASIGNATURA </h1>';
        $html .= '<p><b>Objetivos Generales </b> <br>' . $this->parametros['objetivosGral'] . '</p>';
        $html .= '<p><b>Objetivos Específicos</b> <br>' . $this->parametros['objetivosEspe'] . '</p>';
        

        //Resultados de  Aprendizaje
        $html .= '<h1>RESULTADOS APRENDIZAJE </h1>';

        $resultados = $this->parametros['resultados'];
        if ($resultados) {
            foreach ($resultados as $resultado) {
                $html .= '<p>' . $resultado . '</p>';
            }
        }

        //Temario
        $html .= '<h1>TEMARIO </h1>';
        $temario = $this->parametros['temario'];
        if ($temario) {
            foreach ($temario as $tema) {
                $html .= '<p><b>Nro Unidad: </b> ' . $tema->getUnidad() . '</p>';
                $html .= '<p><b>Titulo:  </b> ' . $tema->getTitulo() . '</p>';
                $html .= '<p><b>Contenido: </b> ' . $tema->getContenido() . '</p>';
            }
        }

        //TODO: Bibliografia
        $html .= '<h1>BIBLIOGRAFIA </h1>';
        $bibliografia = $this->parametros['bibliografia'];
        if ($bibliografia) {
            foreach ($bibliografia as $biblio) {
               $html .= '<p><b>Tipo: </b>' . $biblio->getTipoBibliografia()  . '</p>';
               
               $bibliografiaInfo = $biblio->getBibliografia()->getInfoCompleta();
               
               $html .= '<p>' . $bibliografiaInfo  . '</p>';
                
                /*$html .= '<p><b>Título: </b> ' . $biblio->getTitulo() . '</p>';
                $html .= '<p><b>Autores: </b> ' . $biblio->getAutores() . '</p>';
                $html .= '<p><b>Editorial: </b> ' . $biblio->getEditorial() . '</p>';
                $html .= '<p><b>Añio de Edición: </b> ' . $biblio->getAnioEdicion() . '</p>';
                $html .= '<p><b>Nro de Edicion: </b> ' . $biblio->getNroEdicion() . '</p>';
                $html .= '<p><b>ISSN-ISBN: </b> ' . $biblio->getIssnIsbn() . '</p>';*/
            }
        }


        //Actividades
        $actividades = $this->parametros['actividades'];
        $html .= '<h1>ACTIVIDADES CURRICULARES </h1>';
        if ($actividades) {
            $html .= '<table cellspacing="0" cellpadding="1">';
            foreach ($actividades as $actividad) {
                $fecha = $actividad->getFecha();
                $html .= '<tr><td><b>Unidad</b> </td>
                            <td><b>Tipo de Clase</b></td>
                            <td><b>Fecha</b></td></tr>';
                $html .= '<tr><td>'. $actividad->getTemario() . '</td>
                            <td>' . $actividad->getTipoActividadCurricular() . '</td>
                            <td> ' . $fecha->format("d/m/Y") . '</td></tr>';
                
               $html .= '<tr><td><b>Descripcion</b> </td>
                            <td><b>Carga Horaria Aula</b></td>
                            <td><b>Carga Horaria Autonomo</b></td></tr>';
                $html .= '<tr><td>'. $actividad->getDescripcion() . '</td>
                            <td>' . $actividad->getCargaHorariaAula() . '</td>
                            <td> ' . $actividad->getCargaHorariaAutonomo() . '</td></tr>
                            <tr><td></td></tr>';
            
            }
            $html .= '</table>';
        }

        //Viajes Academicos
        $viajesAcademicos = $this->parametros['viajesAcademicos'];
        $html .= '<h1>VIAJES ACADEMICOS </h1>';
        if ($viajesAcademicos) {
            foreach ($viajesAcademicos as $viaje) {
                $fecha = $viaje->getFechaTentativa();
                $fechaR = $viaje->getFechaTentativaRegreso();
                $html .= '<p><b>Descripcion: </b> ' . $viaje->getDescripcion() . '</p>';
                $html .= '<p><b>Objetivos: </b> ' . $viaje->getObjetivos() . '</p>';
                $html .= '<p><b>Recorrido: </b> ' . $viaje->getRecorrido() . '</p>';
                $html .= '<p><b>Cantidad Estudiantes: </b> ' . $viaje->getCantEstudiantes() . '</p>';
                $html .= '<p><b>Cantidad Docentes: </b> ' . $viaje->getCantDocentes() . '</p>';
                $html .= '<p><b>Fecha Tentativa: </b>' . $fecha->format('d/m/Y') . '</p>';
                $html .= '<p><b>fecha Tentativa Regreso: </b>' . $fechaR->format('d/m/Y') . '</p>';
            }
        }

        $html .= '</body>';
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
          //        $this->CreateTextBox(count($this->parametros['tabla_det']), $x0+160, $y + 7, 20, 0, 9, 'B', 'R', 1); */
    }

}
