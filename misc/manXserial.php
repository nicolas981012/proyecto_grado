<?php
require('../fpdf/fpdf.php');
include_once '../db/connect_db.php';
class PDF extends FPDF
{
    function Header()
    {
        $this->Image("../img/LogoNegro5.png", 10, 90, 170, 130, "PNG", "https://oklahomacomputadores.com/");


        $this->SetFont('Arial', 'B', 14);
        $this->SetY(12);
        $this->Image("../img/logo.png", 30, 9, 20, 15, "PNG", "http://evilnapsis.com/");
        $this->setFillColor(230, 230, 230);
        $this->MultiCell(220, 20, 'REPORTE MANTENIMIENTOS O GARANTIA POR SERIAL ', 0, 'C', 0,);



        $this->Line(30, 25, 187, 25);
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
        $x = 36;
        for ($i = 0; $i < count($header); $i++)
            $this->Cell(30 + $i * 4, 8, $header[$i], 1, 0, 'C', 1);
        $this->Ln();
        $this->SetFillColor(255, 204, 204);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 10);

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
        } catch (PDOException $error) {
            echo $error->getmessage();
        }
        $select = $pdo->prepare("SELECT * FROM mantenimiento WHERE ser_equ='MP1A5JF7'");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_OBJ)) {
            $x = $this->GetX();
            $y = $this->GetY();
            $this->MultiCell(30, 10, $row->id_man, 1, 'L', 0);
            $date = date_create("2020-03-29");
            $x += 30;
            $this->SetXY($x, $y);
            $this->MultiCell(34, 10, date_format(new DateTime($row->fec_man), 'Y-m-d'), 1, 'L', 0);
            $x += 34;
            $this->SetXY($x, $y);
            $this->MultiCell(38, 10, $row->equ_man, 1, 'L', 0);
            $x += 38;
            $this->SetXY($x, $y);
            $this->MultiCell(42, 10, $row->doc_cli, 1, 'L', 0);
            $x += 42;
            $this->SetXY($x, $y);
            $this->SetAutoPageBreak('false');
            $this->MultiCell(46, 10, ' $ ' . ' ' . number_format($row->val_man), 1, 'L', 0);
        }
    }
    function Tabla()
    {
        $this->SetX(9);
        $this->SetFont('Arial', '', 12);
        //$pdf->multicell(200, 1,, 10, 1, 'C');
        $this->MultiCell(200, 3,  'Datos del equipo:', 0, 'L', 0);
    }
    function mensaje1()
    {
        $this->SetFont('Arial', '', 12);
        //$pdf->multicell(200, 1,, 10, 1, 'C');
        $this->MultiCell(200, 2.5,  'Mantenimientos que han sido realizados en Oklahoma computadores:', 0, 'L', 0);
    }
    function mensaje2()
    {
        $this->SetFont('Arial', '', 12);
        //$pdf->multicell(200, 1,, 10, 1, 'C');
        $this->MultiCell(200, 2.5,  'Motivos de los mantenimientos:', 0, 'L', 0);
    }
    function datos()
    {

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
        } catch (PDOException $error) {
            echo $error->getmessage();
        }
        $select = $pdo->prepare("SELECT * FROM mantenimiento WHERE ser_equ='MP1A5JF7'");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_OBJ);


        $this->SetY(46.5);
        $this->setFillColor(230, 230, 230);
        $this->SetFont('Arial', 'B', 11);
        $this->SetX(16);
        $this->Cell(30, 6, 'EQUIPO: ', 8, 8, 'L', 'TRUE');
        $this->SetY(47);
        $this->SetFont('Arial', '', 11);
        $this->SetX(45.5);
        $this->MultiCell(53, 4, $row->equ_man, 0, 'L', 0);

        $this->SetY(51.8);
        $this->setFillColor(230, 230, 230);
        $this->SetFont('Arial', 'B', 11);
        $this->SetX(16);
        $this->Cell(30, 6, 'SERIAL: ', 8, 8, 'L', 'TRUE');
        $this->SetY(52.5);
        $this->SetFont('Arial', '', 11);
        $this->SetX(45.5);
        $this->MultiCell(53, 4, $row->ser_equ, 0, 'L', 0);


        $this->SetY(57.5);
        $this->SetFont('Arial', 'B', 11);
        $this->setFillColor(230, 230, 230);
        $this->SetX(16);
        $this->Cell(30, 6, 'MARCA: ', 8, 8, 'L', 'TRUE');
        $this->SetY(58.5);
        $this->SetFont('Arial', '', 11);
        $this->SetX(45.5);
        $this->MultiCell(53, 4, $row->mar_equ, 0, 'L', 0);


        $this->SetY(63.5);
        $this->SetFont('Arial', 'B', 11);
        $this->setFillColor(230, 230, 230);
        $this->SetX(16);
        $this->Cell(30, 6, 'REFERENCIA: ', 8, 8, 'L', 'TRUE');
        $this->Ln(2);
        $this->SetY(64);
        $this->SetFont('Arial', '', 11);
        //$pdf->Cell(250, 4, $row->equ_man, 8, 8, 'C');
        $this->SetX(45.5);
        //$pdf->MultiCell(240,4, $row->equ_man, 0, 'C', 0);
        $this->Multicell(78, 4.7, $row->ref_equ, 0, 'L', 0);
    }

    function TablaColores2()
    {


        try {
            $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
        } catch (PDOException $error) {
            echo $error->getmessage();
        }
        $select = $pdo->prepare("SELECT * FROM mantenimiento WHERE ser_equ='MP1A5JF7'");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_OBJ)) {
            $i = 0;
            $i++;
            $this->MultiCell(180, 10, $i . ') ' . $row->id_man . ' - ' . $row->fal_equ, 0, 'L', 0);
        }
    }
}
$pdf = new PDF();
$header = array('ID', 'FECHA', 'EQUIPO', 'CLIENTE', 'VALOR');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->datos();
$pdf->SetY(40);
$pdf->Tabla();
$pdf->SetY(75);
$pdf->mensaje1();
$pdf->SetY(80);
$pdf->TablaColores($header);
$pdf->Ln();
$pdf->mensaje2();
$pdf->Ln();
$pdf->TablaColores2();
$pdf->Output();
