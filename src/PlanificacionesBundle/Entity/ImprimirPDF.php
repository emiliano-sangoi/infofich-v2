<?php

namespace PlanificacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of ImprimirPDF
 *
 * @author rgalarza
 */
class ImprimirPDF extends \TCPDF {

    private $parametros;
    private $textColorHeader = 0;
    private $fillColorHeader = 204;
    private $drawColorHeader = 204;
    private $lineWidthHeader = 0;
    private $textColorData = 0;
    private $fillColorData = 204;
    private $drawColorData = 204;
    private $lineWidthData = 0;

    public function __construct($parametros) {

        parent::__construct();
        $this->parametros = $parametros;
        $this->SetFont('helvetica', '', '11');
        //$this->SetFont('helvetica', '', 10);

        $titulo = isset($this->parametros['titulo']) ? $this->parametros['titulo'] : '';
        $this->setTitle($titulo);

        $this->setHeaderMargin(10);
        $this->SetFooterMargin(15);

        // set auto page breaks
        $this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $this->setPrintHeader(true);
        $this->setPrintFooter(true);

        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $this->setFooterFont(array('helvetica', '', 7));

        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set JPEG quality
        $this->setJPEGQuality(75);

//        $this->startPageGroup();
    }

    /**
     * Dibuja el encabezado de todas las páginas de los archivos PDF
     */
    public function Header() {
        //die(getcwd());

        $filenameLogo = 'logo_fich.png';

        $PDF_HEADER_TITLE="PLANICACIONES";
        $PDF_HEADER_STRING="ASIGNATURA";

// Image example with resizing
//$this->Image('../Resources/public/images/logo_infofich.png');
//Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
//$this->Image('/var/www/html/infofich2/src/PlanificacionesBundle/Resources/public/images/logo_fich.png', 0, 0, 474, 167, 'PNG');
///var/www/html/infofich2/src/PlanificacionesBundle/Resources/public/images/logo_fich.png
$this->Image(__DIR__.'/../Resources/public/images/logo_fich.png', 
$x = PDF_MARGIN_LEFT, 
$y = PDF_MARGIN_TOP - 15, 
$w = '70', 
$h = '20', 
$type = 'PNG', 
$link = 'http://infofich.unl.edu.ar/login', 
$align = '', 
$resize = false, $dpi = 150, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = true);

//var_dump('../Resources/public/images/logo_infofich.png');
///var/www/html/infofich2/src/PlanificacionesBundle/Resources/public/images/logo_fich.png
//var_dump($this->Image('/var/www/html/infofich2/src/PlanificacionesBundle/Resources/public/images/logo_fich.png', 0, 0, 150, 150, 'PNG')); exit;

        // esta carpeta ..cuál es?
        $PDF_HEADER_LOGO="../Resources/public/images/tcpdf/" . $filenameLogo; //Solo me funciona si esta dentro de la carpeta images de la libreria

        //$this->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

        
        // Set font
                // convert TTF font to TCPDF format and store it on the fonts folder
                //$fontname = TCPDF_FONTS::addTTFfont('../Resources/public/fonts/Lato/Lato-Regular.ttf"', 'TrueTypeUnicode', '', 96);
                //$fontname=$this->pdf->addTTFfont('../Resources/public/fonts/Lato/Lato-Regular.ttf"', '', '', 32);

                // use the font
                //$pdf->SetFont($fontname, '', 14, '', false);
        
        $this->SetFont('helvetica', 'B', 10);
        $border = 0;
        
        $logoDir = K_PATH_IMAGES;

    

        // Logo de la Provincia
       $file2 = 'assets/images/logo_fich.png';
       
    
       //$this->Image($file2, $x = PDF_MARGIN_LEFT+120, $y = PDF_MARGIN_TOP - 15, $w = '61', $h = '21', $type = 'PNG', $link = 'www.santafe.gov.ar', $align = '', $resize = false, $dpi = 150, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);

       //$this->Image($file2, 180, 30, 50, 15, 'PNG');

        // Logo de la INFOFICH
        $file = 'assets/images/logo_infofich.png';
        $file =  __DIR__.'/../Resources/public/images/logo_infofich.png';
        $this->Image($file, $x = 160, $y = 15, $w = '50', $h = '20', $type = 'PNG', $link = 'www.infofich.unl.edu.ar', $align = '', $resize = false, $dpi = 150, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = true);

//        $file = 'assets/imagenes/logocaja_2.jpg';
//        $this->Image($file, $x = 130, $y = PDF_MARGIN_TOP - 15, $w = '190', $h = '80', $type = 'JPG', $link = 'www.santafe.gov.ar', $align = '', $resize = false, $dpi = 150, $palign = '', $ismaskInformePDF = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = true);

        
        // Barra de encabezado
//        $file = 'https://www.santafe.gob.ar/assets/standard/images/barra-header.png';
//        $this->Image($file, $x = PDF_MARGIN_LEFT, $y = 35, $w = '190', $h = '1', $type = 'PNG', $link = 'www.santafe.gov.ar', $align = '', $resize = true, $dpi = 150, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false);
    }

    public function render() {}

    /**
     * Escribe un texto en una posición determinada del archivo PDF, 
     * seteando ancho, alto, borde, fuente, tipo de letra, tamaño y alineación
     * 
     * @param type $textval
     * @param type $x
     * @param type $y
     * @param type $width
     * @param type $height
     * @param type $fontsize
     * @param type $fontstyle
     * @param type $align
     * @param type $border
     */
    public function createTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L', $border = 0) {
        $this->SetXY($x, $y);
        //$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
        $this->SetFont('helvetica', $fontstyle, $fontsize);
        //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M') {
        $this->Cell($width, $height, $textval, $border, false, $align);
    }

    public function createTable($header, $data) {
        // Colors, line width and bold font
        $this->SetFillColor($this->fillColorHeader);
        $this->SetTextColor($this->textColorHeader);
        $this->SetDrawColor($this->drawColorHeader);
        $this->SetLineWidth($this->lineWidthHeader);
        //$this->SetFont('helvetica', 'B');
        //$this->SetFont('helvetica', 'I', '11');
        $this->SetFontSize(8);
        // Header
        $num_headers = count($header);
        $width_col = 190 / $num_headers;
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($width_col, 7, $header[$i], 1, false, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor($this->fillColorData);
        $this->SetTextColor($this->textColorData);
        $this->SetDrawColor($this->drawColorData);
        $this->SetLineWidth($this->lineWidthData);
        $this->SetFont('helvetica');
        $this->SetFontSize(7);
        // Data
        $fill = 0;
        foreach ($data as $row) {
            foreach ($row as $value) {
                $align = (is_numeric($value)) ? 'R' : 'L';
                $this->Cell($width_col, 6, $value, 1, false, $align, 0);
            }
            $this->Ln();
//            $fill=!$fill;
        }
    }

    /**
     * Dibuja el encabezado de una tabla
     * Se debe pasar:
     * @param type $header: array con las cabeceras de cada columna
     * @param type $widthColumn: array con los anchos de cada una de las columnas
     * @param type $fontsize
     * @param type $fontstyle
     * @param type $align: por defecto, las cabeceras se alinean en el centro, salvo que se pase otra alineación
     * @param type $border
     * @param type $ln
     * @param type $fill
     */
    public function createHeaderTable($header, $widthColumn, $fontsize = 8, $fontstyle = 'B', $align = 'C', $border = true, $ln = false, $fill = true) {
        // Colors, line width and bold font
        $this->SetFillColor($this->fillColorHeader);
        $this->SetTextColor($this->textColorHeader);
        $this->SetDrawColor($this->drawColorHeader);
        $this->SetLineWidth($this->lineWidthHeader);
        $this->SetFont('helvetica', $fontstyle);
        $this->SetFontSize($fontsize);
        // Header
        for ($i = 0; $i < count($header); ++$i) {
            $this->Cell($widthColumn[$i], 7, $header[$i], $border, $ln, $align, $fill);
        }
        $this->Ln();
    }

    /**
     * Dibuja el contenido de la tabla.
     * Se debe pasar:
     * @param type $data: array con todos los registros que debe tener la tabla
     * @param type $widthColumn: array con los anchos y alineación de cada una de las columnas. Ejemplo: array(array(16,'L'), array(59,'L'), array(23,'R')....);
     * @param type $fontsize
     * @param type $fontstyle
     * @param type $align
     * @param type $border
     * @param type $ln
     * @param type $fill
     */
    public function createDataTable($data, $widthColumn, $fontsize = 7, $fontstyle = '', $align = 'L', $border = true, $ln = false, $fill = false) {
        // Color and font restoration
        $this->SetFillColor($this->fillColorData);
        $this->SetTextColor($this->textColorData);
        $this->SetDrawColor($this->drawColorData);
        $this->SetLineWidth($this->lineWidthData);
        $this->SetFont('helvetica',$fontstyle);
        $this->SetFontSize($fontsize);
        // Data
        /*foreach ($data as $row) {
            foreach ($row as $k => $value) {
                $this->Cell($widthColumn[$k][0], 6, $value, $border, $ln, $widthColumn[$k][1], $fill);
            }
            $this->Ln();
//            $fill=!$fill;
        }*/
    }
    
    /**
     * Dibuja el pie de página de todas las hojas de los archivos PDF
     */
    public function Footer() {
        

        $this->Line(PDF_MARGIN_LEFT, 297 - $this->getFooterMargin(), 220 - PDF_MARGIN_RIGHT, 297 - $this->getFooterMargin());
        
        $this->SetFont('dejavusans', '', 10, '', true);
        $this->CreateTextBox('Fecha generación: ' . date('d/m/Y H:i:s'), PDF_MARGIN_LEFT, 297 - $this->getFooterMargin(), 65, 10, 8, '', 'L');      
        $this->CreateTextBox('Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 39 - PDF_MARGIN_LEFT + 127, 297 - $this->getFooterMargin(), 63, 10, 8, '', 'R');
    }

}
