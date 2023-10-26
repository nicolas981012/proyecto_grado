<?php
require('../fpdf/fpdf.php');
include_once '../db/connect_db.php';



class PDF extends FPDF
{

    //Pie de página
    function Footer()
    {

        
    }
}
//$id = $_GET['id'];


$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->Image("../img/marco.jpg", 1, 1, 290, 200, "JPG", "");
$pdf->Image("../img/escudo.png", 134, 32, 30, 20, "PNG", "");

$pdf->SetFont('Times', 'BI', 30);
$pdf->Cell(280, 100,"CERTIFICA", 10, 1, 'C');

$pdf->SetY(65);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(278, 5, "A el alumno:", 10, 1, 'C');

$pdf->Line(100, 90, 200, 90);

$pdf->SetY(95);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(280, 5, "Por haber cursado y aprobado satisfactoria el curso en ingles:", 10, 1, 'C');


//datos del curso
$pdf->SetY(110);
$pdf->SetFont('Arial', 'BI', 15);
$pdf->Cell(280, 5, "Numeros en ingles", 10, 1, 'C');


$pdf->SetY(125);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(280, 5, "Expedido el dia 26 de octubre del 2023 Santana,Boyaca", 10, 1, 'C');

$pdf->Line(80, 150, 110, 150);
$pdf->Line(190, 150, 220, 150);
$pdf->Output();
