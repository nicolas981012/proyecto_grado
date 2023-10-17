<?php
require('../fpdf/fpdf.php');
include_once '../db/connect_db.php';
class PDF extends FPDF
{
    function Header()
    {
        $this->Image("../img/LogoNegro5.png", 18, 90, 170, 130, "PNG", "https://oklahomacomputadores.com/");


        $this->SetFont('Arial', 'B', 14);
        $this->SetY(12);
        $this->Image("../img/logo.png", 40, 9, 20, 15, "PNG", "http://evilnapsis.com/");
        $this->setFillColor(230, 230, 230);
        $this->MultiCell(220, 20, 'REPORTE MANTENIMIENTOS POR USUARIO ', 0, 'C', 0,);



        $this->Line(30, 25, 180, 25);
    }
    function Footer()
    {
        $this->Line(20, 267, 190, 267);
        $this->Line(20, 281, 190, 281);
        $this->Line(20, 267, 20, 281);
        $this->Line(190, 267, 190, 281);
        $this->SetY(269);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(200, 2.5, 'Pasados(60)dias a partir de la fecha de ingreso del bien,sin que el consumidor acuda a retirarlo se dara por abandonado.', 0, 'C', 0);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(200, 3, 'Segun articulo 18,LEY 1480 DE 2011', 0, 'C', 0);
        $this->ln(2);
        $this->SetFont('Arial', 'B', 9);
        $this->MultiCell(200, 2, 'CONSULTA TU ORDEN EN : https://soporte.oklahomacomputadores.com/', 0, 'C', 0);
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    function TablaColores($header)
    {
        $this->SetFillColor(59, 87, 144);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.1);
        $this->SetFont('', 'B');
        for ($i = 0; $i < count($header); $i++)
            $this->Cell(38, 5, $header[$i], 1, 0, 'C', 1);
        $this->Ln();
        $this->SetFillColor(255, 204, 204);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 10);
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
        } catch (PDOException $error) {
            echo $error->getmessage();
        }
        $select = $pdo->prepare("SELECT b.usu AS Tecnico, count(a.id_man) AS cantidad 
        FROM mantenimiento a JOIN usuario b ON a.id_usu = b.doc_usu GROUP BY b.usu;");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_OBJ)) {
            $this->Cell(38, 7, $row->Tecnico, 1);
            $this->Cell(38, 7, $row->cantidad, 1);
            $this->Ln();
        }
    }
    function Tabla()
    {
        $this->SetX(14);
        $this->SetFont('Arial', '', 12);
        //$pdf->multicell(200, 1,, 10, 1, 'C');
        $this->MultiCell(200, 3,  'Datos del tecnico:', 0, 'L', 0);
    }
    function mensaje1()
    {
        $this->SetFont('Arial', '', 12);
        //$pdf->multicell(200, 1,, 10, 1, 'C');
        $this->MultiCell(200, 2.5,  'Mantenimientos que se encuentran pendientes a la fecha:', 0, 'L', 0);
    }
    function datos()
    {

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
        } catch (PDOException $error) {
            echo $error->getmessage();
        }
        $select = $pdo->prepare("SELECT * FROM usuario WHERE doc_usu='1234567'");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_OBJ);

        $this->Line(15, 45, 95, 45);
        $this->Line(15, 65, 95, 65);
        $this->Line(15, 45, 15, 65);
        $this->Line(95, 65, 95, 45);

        $this->SetY(46.5);
        $this->setFillColor(230, 230, 230);
        $this->SetFont('Arial', 'B', 7);
        $this->SetX(16);
        $this->Cell(23, 6, 'IDENTIFICACION: ', 8, 8, 'L', 'TRUE');
        $this->SetY(47);
        $this->SetFont('Arial', '', 7);
        $this->SetX(38.5);
        $this->MultiCell(53, 4, $row->doc_usu, 0, 'L', 0);

        $this->SetY(51.8);
        $this->setFillColor(230, 230, 230);
        $this->SetFont('Arial', 'B', 7);
        $this->SetX(16);
        $this->Cell(23, 6, 'NOMBRE: ', 8, 8, 'L', 'TRUE');
        $this->SetY(52.5);
        $this->SetFont('Arial', '', 7);
        $this->SetX(38.5);
        $this->MultiCell(53, 4, $row->nom_usu, 0, 'L', 0);


        $this->SetY(57.5);
        $this->SetFont('Arial', 'B', 7);
        $this->setFillColor(230, 230, 230);
        $this->SetX(16);
        $this->Cell(23, 6, 'APELLIDO: ', 8, 8, 'L', 'TRUE');
        $this->SetY(58.5);
        $this->SetFont('Arial', '', 7);
        $this->SetX(38.5);
        $this->MultiCell(53, 4, $row->ape_usu ? $row->ape_usu : '', 0, 'L', 0);

        $this->Line(100, 65, 100, 45);
        $this->Line(100, 45, 195, 45);
        $this->Line(100, 65, 195, 65);
        $this->Line(195, 65, 195, 45);

        $this->SetY(46.5);
        $this->SetFont('Arial', 'B', 7);
        $this->setFillColor(230, 230, 230);
        $this->SetX(101);
        $this->Cell(20, 6, 'TELEFONO: ', 8, 8, 'L', 'TRUE');
        $this->Ln(2);
        $this->SetY(47);
        $this->SetFont('Arial', '', 7);
        //$pdf->Cell(250, 4, $row->equ_man, 8, 8, 'C');
        $this->SetX(121);
        //$pdf->MultiCell(240,4, $row->equ_man, 0, 'C', 0);
        $this->Multicell(78, 4, $row->tel_usu, 0, 'L', 0);

        $this->SetY(51.8);
        $this->SetFont('Arial', 'B', 7);
        $this->setFillColor(230, 230, 230);
        $this->SetX(101);
        $this->Cell(20, 6, 'SEDE ', 8, 8, 'L', 'TRUE');
        $this->SetY(52.5);
        $this->SetFont('Arial', '', 7);
        //$pdf->Cell(218, 4, $row->mar_equ, 8, 8, 'C');
        $this->SetX(121);
        $this->MultiCell(79, 4, $row->sed_emp, 0, 'L', 0);
    }
}
$pdf = new PDF();
$header = array('ID', 'FECHA', 'EQUIPO', 'SERIAL', 'FALLA');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->datos();
$pdf->SetY(40);
$pdf->Tabla();
$pdf->SetY(75);
$pdf->mensaje1();
$pdf->SetY(80);
$pdf->TablaColores($header);
$pdf->Output();
