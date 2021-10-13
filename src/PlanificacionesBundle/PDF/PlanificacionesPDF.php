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

        $x0 = PDF_MARGIN_LEFT;

        $fontSize = 9;
        $this->CreateTextBox('INFORMACIÓN BÁSICA', $x0, 50, 180, 0, 10, 'B', 'C');
        // Nombre Asignatura
        $this->CreateTextBox($this->parametros['nombreAsignatura'], $x0 + 5, 55, 180, 0, $fontSize, '', 'L');

        // Carrera
        $this->CreateTextBox('Carrera: ' . $this->parametros['nombreCarrera'], $x0 + 5, 60, 180, 0, $fontSize, '', 'L');

        // Departamento
        $this->CreateTextBox('Departamento: ' . $this->parametros['departamento'], $x0 + 5, 65, 180, 0, $fontSize, '', 'L');

        // Plan estudios
        $this->CreateTextBox('Plan Estudios: ' . $this->parametros['planEstudio'], $x0 + 5, 70, 180, 0, $fontSize, '', 'L');

        // Periodo
        $this->CreateTextBox('Período: ' . $this->parametros['periodoLectivo'], $x0 + 5, 75, 180, 0, $fontSize, '', 'L');

        // Anio Cursada
        $this->CreateTextBox('Año Cursada: ' . $this->parametros['anioCursada'], $x0 + 5, 80, 180, 0, $fontSize, '', 'L');

        // Caracter
        $this->CreateTextBox('Carácter: ' . $this->parametros['caracter'], $x0 + 5, 85, 180, 0, $fontSize, '', 'L');

        // Equipo Docente:
        $this->CreateTextBox('EQUIPO DOCENTE', $x0, 100, 180, 0, 10, 'B', 'C');
        $this->CreateTextBox('Docente Responsable: ' . $this->parametros['docenteResponsable'], $x0 + 5, 105, 180, 0, $fontSize, '', 'L');

        $docentesColaboradores = $this->parametros['docentesColaboradores'];

        $x1 = 110;
        foreach ($docentesColaboradores as $docentesColaborador){
            $this->CreateTextBox('Docente Colaborador: ' . $docentesColaborador, $x0 + 5, $x1+5, 180, 0, $fontSize, '', 'L');
            $x1 += 5;
        }

        $docentesAdscriptos = $this->parametros['docentesAdscriptos'];

        foreach ($docentesAdscriptos as $docentesAdscripto){
            $this->CreateTextBox('Docente Adscripto: ' . $docentesAdscripto, $x0 + 5, $x1+5, 180, 0, $fontSize, '', 'L');
            $x1 += 5;
        }

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

