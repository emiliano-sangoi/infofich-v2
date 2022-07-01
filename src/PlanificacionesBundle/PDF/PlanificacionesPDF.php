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

        $fontSize = 12;

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
        $this->SetFontSize(9);

        $this->addPage();


        // print a line of text

        $fontSize = 12;


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
    <td> ' . $this->parametros['nombreCarrera'] . '</td>
    <td> ' . $this->parametros['anio'] . '</td>
    <td> ' . $this->parametros['planEstudio'] . '</td>
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
    <td> ' . $this->parametros['periodoLectivo'] . '</td>
    <td> ' . $this->parametros['caracter'] . '</td>
    <td> ' . $this->parametros['anioCursada'] . '</td>
</tr>

</table>';

        $html .= '<p><b>Contenidos Minimos</b></p>';
        if($this->parametros['contenidosMinimos']){
            $html .=   '<p>' . $this->parametros['contenidosMinimos'] . '</p>';
        } else {
            $html .= 'No presenta';
        }
        

        // Equipo Docente:
        $html .= '<h1>EQUIPO DOCENTE</h1>';

        $html .= '<table cellspacing="0" cellpadding="1">
<tr>
    <td><b>Docente Responsable</b></td>
    <td><b>Docentes Colaboradores</b></td>
    <td><b>Docentes Adscriptos</b></td>
</tr>
<tr><td>' . $this->parametros['docenteResponsable'] . '</td>
    <td>';
        $docentesColaboradores = $this->parametros['docentesColaboradores'];
        if ($docentesColaboradores) {
            foreach ($docentesColaboradores as $docentesColaborador) {
                $html .= $docentesColaborador . '<br>';
            }
        } else {
            $html .= 'No presenta';
        }


        $html .= '</td>       

        <td>';
        $docentesAdscriptos = $this->parametros['docentesAdscriptos'];
        if ($docentesAdscriptos) {
            foreach ($docentesAdscriptos as $docentesAdscripto) {
                if ($docentesAdscripto) {
                    $html .= $docentesAdscripto . '<br>';
                }
            }
        } else {
            $html .= 'No presenta';
        }

        $html .= '</td></tr>

</table>';

//Requisitos de Aprobacion    
        $html .= '<h1>APROBACION ASIGNATURA </h1>';
        if ($this->parametros['requisitosAprobacion']) {
            $prevePromTeo = ($this->parametros['requisitosAprobacion']['prevePromParcialTeo']) ? 'Sí' : 'No';
            $prevePromPra = ($this->parametros['requisitosAprobacion']['prevePromParcialPractica']) ? 'Sí' : 'No';
            $preveCfi = ($this->parametros['requisitosAprobacion']['preveCfi']) ? 'Sí' : 'No';
            $modalidadCfi = ($this->parametros['requisitosAprobacion']['modalidadCfi']) ? 'Sí' : 'No';
            $fechaPrimerParcial = ($this->parametros['requisitosAprobacion']['fechaPrimerParcial']) ? $this->parametros['requisitosAprobacion']['fechaPrimerParcial']->format("d/m/Y") : 'Sin Definir';
            $fechaSegundoParcial = ($this->parametros['requisitosAprobacion']['fechaSegundoParcial']) ? $this->parametros['requisitosAprobacion']['fechaSegundoParcial']->format("d/m/Y") : 'Sin Definir';
            $fechaRecupPrimerParcial = ($this->parametros['requisitosAprobacion']['fechaRecupPrimerParcial']) ? $this->parametros['requisitosAprobacion']['fechaRecupPrimerParcial']->format("d/m/Y") : 'Sin Definir';
            $fechaRecupSegundoParcial = ($this->parametros['requisitosAprobacion']['fechaRecupSegundoParcial']) ? $this->parametros['requisitosAprobacion']['fechaRecupSegundoParcial']->format("d/m/Y") : 'Sin Definir';
            $fechaParcailCfi = ($this->parametros['requisitosAprobacion']['fechaParcailCfi']) ? $this->parametros['requisitosAprobacion']['fechaParcailCfi']->format("d/m/Y") : 'Sin Definir';
            $fechaRecupCfi = ($this->parametros['requisitosAprobacion']['fechaRecupCfi']) ? $this->parametros['requisitosAprobacion']['fechaRecupCfi']->format("d/m/Y") : 'Sin Definir';


            $html .= '<table cellspacing="0" cellpadding="1">
            <tr>
                <td><b>Aprobacion</b></td>
                <td><b>Asistencia</b></td>        
                <td><b>Primer Parcial </b></td> 
                <td><b>Segundo Parcial </b></td>

            </tr>
            <tr>
                <td></td>
                <td>' . $this->parametros['requisitosAprobacion']['porcentajeAsistencia'] . '%</td>
                <td>' . $fechaPrimerParcial . '</td>
                <td>' . $fechaSegundoParcial . '</td>            
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
                <td>' . $fechaRecupPrimerParcial . '</td>
                <td>' . $fechaRecupSegundoParcial . '</td>
            </tr>
            <tr><td></td></tr>
            <tr>         
                <td><b>Promoción</b></td>
                <td><b>¿Prevé promoción teoría?</b></td>        
                <td><b>¿Prevé promoción práctica? </b></td> 
                <td></td>
            </tr>
            <tr>
                <td></td>            
                <td>' . $prevePromTeo . '</td>
                <td>' . $prevePromPra . '</td>
                <td></td>
            </tr>

            <tr><td></td></tr>
            <tr>         
                <td><b>Coloquio final integrador (CFI)</b></td>
                <td><b>¿Prevé CFI?</b></td>        
                <td><b>Fecha integrador </b></td> 
                <td><b>Fecha recuperatorio</b></td>
            </tr>
            <tr>
                <td></td>            
                <td>' . $preveCfi . '</td>
                <td>' . $fechaParcailCfi . '</td>
                <td>' . $fechaRecupCfi . '</td>
            </tr>
            <tr><td></td></tr>
            <tr>         
                <td></td>
                <td><b>Modalidad CFI </b></td>        
                <td></td> 
                <td></td>
            </tr>
            <tr>
                <td></td>            
                <td>' . $modalidadCfi . '</td>
                <td></td>
                <td></td>
            </tr>
            <tr><td></td></tr>
            <tr>         
                <td><b>Modalidad exámen final </b></td>
                <td><b>Regulares </b></td>        
                <td><b>Libres</b></td> 
                <td></td>
            </tr>
            <tr>
                <td></td>                       
                <td>' . $this->parametros['requisitosAprobacion']['examenFinalReg'] . '</td>
                <td>' . $this->parametros['requisitosAprobacion']['examenFinalLibre'] . '</td>          
                <td></td>
            </tr>
            </table>';
        }

        $html .= '<h1>OBJETIVOS ASIGNATURA </h1>';
        $html .= '<p><b>Objetivos Generales </b> <br>';
        if($this->parametros['objetivosGral']){
            $html .= $this->parametros['objetivosGral'] .'</p>';
        }else{
            $html .= 'No presenta</p>';
        }
                 
        $html .= '<p><b>Objetivos Específicos</b> <br>';
        if($this->parametros['objetivosEspe']){
            $html .= $this->parametros['objetivosEspe'] .'</p>';
        }else{
            $html .= 'No presenta</p>';
        }


        //Resultados de  Aprendizaje
        $html .= '<h1>RESULTADOS APRENDIZAJE </h1>';

        $resultados = $this->parametros['resultados'];
        if ($resultados[0]) {
            foreach ($resultados as $resultado) {
                $html .= '<p>' . $resultado . '</p>';
            }
        } else {
            $html .= '<p>No presenta </p>'; //Siempre hay algo en el objeto
        }

        //Temario
        $html .= '<h1>TEMARIO </h1>';
        $temario = $this->parametros['temario'];


        if ($temario[0]) {
            $html .= '<table cellspacing="0" cellpadding="1">';
            foreach ($temario as $tema) {
                $html .= '<tr>
                            <td><b>Nro Unidad</b></td>
                            <td><b>Titulo</b></td>
                          </tr>';
                $html .= '<tr>
                          <td>' . $tema->getUnidad() . '</td>';
                $html .= '<td>' . $tema->getTitulo() . '</td>'
                        . '</tr>';
                $html .= '<tr>
                          <td><b>Contenido: </b></td></tr>'
                        . '<tr><td colspan="2">' . $tema->getContenido() . '</td></tr>';
                $html .= '<tr><td></td></tr>';
            }
            $html .= '</table>';
        } else {
            $html .= '<p>No presenta </p>'; //Siempre hay algo en el objeto
        }


        $html .= '<h1>BIBLIOGRAFIA </h1>';
        $bibliografia = $this->parametros['bibliografia'];
        if ($bibliografia) {
            foreach ($bibliografia as $biblio) {
                $html .= '<p><b>Tipo: </b>' . $biblio->getTipoBibliografia() . '</p>';

                $bibliografiaInfo = $biblio->getInfoCompleta();

                $html .= '<p>' . $bibliografiaInfo . '</p>';

                /* $html .= '<p><b>Título: </b> ' . $biblio->getTitulo() . '</p>';
                  $html .= '<p><b>Autores: </b> ' . $biblio->getAutores() . '</p>';
                  $html .= '<p><b>Editorial: </b> ' . $biblio->getEditorial() . '</p>';
                  $html .= '<p><b>Añio de Edición: </b> ' . $biblio->getAnioEdicion() . '</p>';
                  $html .= '<p><b>Nro de Edicion: </b> ' . $biblio->getNroEdicion() . '</p>';
                  $html .= '<p><b>ISSN-ISBN: </b> ' . $biblio->getIssnIsbn() . '</p>'; */
            }
        } else {
            $html .= '<p>No presenta </p>'; //Siempre hay algo en el objeto
        }


        //Actividades
        $actividades = $this->parametros['actividades'];
        $html .= '<h1>ACTIVIDADES CURRICULARES </h1>';
        if ($actividades[0]) {
            $html .= '<table cellspacing="0" cellpadding="1">';
            foreach ($actividades as $actividad) {
                $fecha = $actividad->getFecha();
                $html .= '<tr><td><b>Unidad</b> </td>
                            <td><b>Tipo de Clase</b></td>
                            <td><b>Fecha</b></td></tr>';
                $html .= '<tr><td>' . $actividad->getTemario() . '</td>
                            <td>' . $actividad->getTipoActividadCurricular() . '</td>
                            <td> ' . $fecha->format("d/m/Y") . '</td></tr>';

                $html .= '<tr>
                            <td><b>Carga Horaria Aula</b></td>
                            <td><b>Carga Horaria Autonomo</b></td>
                            <td></td>
                            </tr>';
                $html .= '<tr>
                            <td>' . $actividad->getCargaHorariaAula() . '</td>
                            <td> ' . $actividad->getCargaHorariaAutonomo() . '</td>
                            <td></td>
                            </tr>';
                $html .=  '<tr>
                            <td><b>Descripcion</b> </td>
                            </tr>
                            <tr>
                            <td  colspan="3">' . $actividad->getDescripcion() . '</td>
                            </tr>
                            <tr><td></td></tr>';
            }
            $html .= '</table>';
        } else {
            $html .= '<p>No presenta </p>'; //Siempre hay algo en el objeto
        }

        //Viajes Academicos
        $viajesAcademicos = $this->parametros['viajesAcademicos'];
        $html .= '<h1>VIAJES ACADEMICOS </h1>';

        if ($viajesAcademicos[0]) {
            $html .= '<table cellspacing="0" cellpadding="1">';
            foreach ($viajesAcademicos as $viaje) {
                $fecha = $viaje->getFechaTentativa();
                $fechaR = $viaje->getFechaTentativaRegreso();

                $html .= '<tr><td><b>Descripcion </b> </td><td></td></tr>';
                $html .= '<tr><td>' . $viaje->getDescripcion() . '</td><td></td></tr>';

                $html .= '<tr><td><b>Objetivos </b></td>';
                $html .= '<td><b>Recorrido </b></td></tr>';
                $html .= '<tr><td>' . $viaje->getObjetivos() . '</td>';
                $html .= '<td>' . $viaje->getRecorrido() . '</td></tr>';


                $html .= '<tr><td><b>Cantidad Estudiantes </b></td>';
                $html .= '<td><b>Cantidad Docentes </b></td></tr>';
                $html .= '<tr><td>' . $viaje->getCantEstudiantes() . '</td>';
                $html .= '<td>' . $viaje->getCantDocentes() . '</td></tr>';

                $html .= '<tr><td><b>Fecha Tentativa </b></td>';
                $html .= '<td><b>Fecha Tentativa Regreso </b></td></tr>';
                $html .= '<tr><td>' . $fecha->format('d/m/Y') . '</td>';
                $html .= '<td>' . $fechaR->format('d/m/Y') . '</td></tr>';
            }
            $html .= '</table>';
        } else {
            $html .= '<p>No presenta </p>'; //Siempre hay algo en el objeto
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
