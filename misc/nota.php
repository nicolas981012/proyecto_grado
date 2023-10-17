<?php
require('../fpdf/fpdf.php');
include_once '../db/connect_db.php';


function sacarsede($dato)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT * FROM sedes_empresa WHERE id_emp='$dato'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->ciu_emp;
}
function sacardireccion($dato)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT * FROM sedes_empresa WHERE id_emp='$dato'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->dir_emp;
}
function sacartelefono($dato)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT * FROM sedes_empresa WHERE id_emp='$dato'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->tel_emp;
}
function sacarnombre($nombre)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT * FROM personas WHERE doc_per='$nombre'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->nom_per . ' ' . ' ' . $row->ape_per;
}
function sacarnombrempleado($nombret)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT nom_usu,ape_usu FROM usuario WHERE doc_usu='$nombret'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->nom_usu . '' . '' . $row->ape_usu;
}
function sacartelefonoc($nombre)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT * FROM personas WHERE doc_per='$nombre'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->tel_per;
}
function sacardir($nombre)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT * FROM personas WHERE doc_per='$nombre'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->dir_per;
}
function sacarcor($nombre)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
    } catch (PDOException $error) {
        echo $error->getmessage();
    }
    $select = $pdo->prepare("SELECT * FROM personas WHERE doc_per='$nombre'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    return $row->cor_per;
}
class PDF extends FPDF
{

    //Pie de página
    function Footer()
    {

        $this->Line(20, 257, 190, 257);
        $this->Line(20, 271, 190, 271);
        $this->Line(20, 257, 20, 271);
        $this->Line(190, 257, 190, 271);
        $this->SetY(259);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(200, 2.5,  'Pasados(60)dias a partir de la fecha de ingreso del bien,sin que el consumidor acuda a retirarlo se dara por abandonado.', 0, 'C', 0);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(200, 3,  'Segun articulo 18,LEY 1480 DE 2011', 0, 'C', 0);
        $this->ln(2);
        $this->SetFont('Arial', 'B', 9);
        $this->MultiCell(200, 2,  'CONSULTA TU ORDEN EN : https://soporte.oklahomacomputadores.com/', 0, 'C', 0);

        $this->SetY(273);
        $this->SetFont('Arial', '', 7);
        $this->MultiCell(200, 1.3,  '--Cliente--', 0, 'C', 0);
    }
}



date_default_timezone_set('America/Bogota');
$id = $_GET['id'];
$fecha = date('Y-m-d ', time());
$select = $pdo->prepare("SELECT * FROM mantenimiento WHERE id_man='$id' OR con_man ='$id'");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$pdf = new PDF('P', 'mm', 'LETTER');

$pdf->AddPage('portrait', array(215.9, 279.4));

$pdf->Image("../img/LogoNegro5.png", 30, 32, 150, 80, "PNG", "https://oklahomacomputadores.com/");
$pdf->Image("../img/LogoNegro5.png", 30, 170, 150, 80, "PNG", "https://oklahomacomputadores.com/");

$pdf->SetFont('Arial', 'B', 14);
$pdf->SetY(12);
$pdf->Image("../img/logo.png", 20, 9, 20, 15, "PNG", "http://evilnapsis.com/");
$pdf->setFillColor(230, 230, 230);
$pdf->MultiCell(220, 5, 'ORDEN DE SERVICIO - OKLAHOMA COMPUTADORES ' . sacarsede($row->sed_emp_man), 0, 'C', 0,);
$pdf->SetFont('Arial', 'I', 10);
$pdf->MultiCell(220, 5, sacardireccion($row->sed_emp_man) . '' . ' TEL: ' . sacartelefono($row->sed_emp_man), 0, 'C', 0);

$pdf->Line(10, 8, 200, 8);
$pdf->Line(10, 25, 200, 25);
$pdf->Line(10, 8, 10, 25);
$pdf->Line(200, 8, 200, 25);

//////////////////////////////////////////////////////////////////

$pdf->SetY(25);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(310, 5, $row->id_man, 10, 1, 'C');

$pdf->Line(155, 30, 175, 30);

$pdf->Line(155, 30, 155, 25);
$pdf->Line(175, 30, 175, 25);

///////////////////////////////////////////////////////////////////

$pdf->SetY(25);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(360, 5, $fecha, 10, 1, 'C');

$pdf->Line(179, 30, 200, 30);

$pdf->Line(179, 30, 179, 25);
$pdf->Line(200, 30, 200, 25);


/////////////////////////////////////////////////////////////////////


$pdf->Line(10, 31, 200, 31);
$pdf->Line(10, 120, 200, 120);
$pdf->Line(10, 31, 10, 120);
$pdf->Line(200, 31, 200, 120);



//////////////////////////////////////////////////////////////////

$pdf->Line(15, 35, 95, 35);
$pdf->Line(15, 65, 95, 65);
$pdf->Line(15, 35, 15, 65);
$pdf->Line(95, 65, 95, 35);

$pdf->SetY(36);
$pdf->setFillColor(230, 230, 230);
$pdf->SetFont('Arial', 'B', 7);
$pdf->SetX(16);
$pdf->Cell(23, 6, 'IDENTIFICACION: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(37);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, $row->doc_cli, 0, 'L', 0);

$pdf->SetY(41.8);
$pdf->setFillColor(230, 230, 230);
$pdf->SetFont('Arial', 'B', 7);
$pdf->SetX(16);
$pdf->Cell(23, 6, 'NOMBRE: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(42.5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, sacarnombre($row->doc_cli), 0, 'L', 0);


$pdf->SetY(47.5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(23, 6, 'TELEFONO: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(48.5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, sacartelefonoc($row->doc_cli), 0, 'L', 0);


$pdf->SetY(53);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(23, 6, 'DIRECCION: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(54.5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, sacardir($row->doc_cli), 0, 'L', 0);


$pdf->SetY(59);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(23, 5, 'CORREO: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(59.5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, sacarcor($row->doc_cli), 0, 'L', 0);




$pdf->Line(100, 35, 195, 35);
$pdf->Line(100, 65, 195, 65);
$pdf->Line(100, 35, 100, 65);
$pdf->Line(195, 65, 195, 35);

$pdf->SetY(36);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 6, 'EQUIPO: ', 8, 8, 'L', 'TRUE');
$pdf->Ln(2);
$pdf->SetY(36.5);

$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->Multicell(78, 4, $row->equ_man, 0, 'L', 0);



$pdf->SetY(41.5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 6, 'MARCA: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(42.5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->MultiCell(79, 4, $row->mar_equ, 0, 'L', 0);

$pdf->SetY(47.4);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 6, 'REFERENCIA: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(48.5);

$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->MultiCell(72, 4, $row->ref_equ, 0, 'L', 0);


$pdf->SetY(53);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 6, 'SERIAL: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(54.5);

$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->MultiCell(20, 4, $row->ser_equ, 0, 'L', 0);


$pdf->SetY(59);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 5, 'RECIBE: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(59.5);

$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->MultiCell(79, 4, sacarnombrempleado($row->id_usu), 0, 'L', 0);





$pdf->Line(15, 67, 195, 67);
$pdf->Line(15, 117, 195, 117);
$pdf->Line(15, 67, 15, 117);
$pdf->Line(195, 117, 195, 67);

$pdf->SetY(70);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'FALLA: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(71.5);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->fal_equ, 0, 'L', 0);

$pdf->SetY(77);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'ACCESORIOS: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(78);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->acc_equ, 0, 'L', 0);


$pdf->SetY(84);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'ESTADO DEL EQUIPO: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(86);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->est_equ, 0, 'L', 0);


$pdf->SetY(91);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'TRABAJO REALIZADO: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(93);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->tra_equ, 0, 'L', 0);


$pdf->SetY(98);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'OBSERVACIONES: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(100);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->obs_man, 0, 'L', 0);


$pdf->SetY(110);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(140);
$pdf->Cell(50, 5, 'VALOR: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(110.5);
$pdf->SetX(0);
$pdf->SetFont('Arial', 'B', 8);
if ($row->val_man == 0) {
    $pdf->SetX(153);
    $pdf->MultiCell(36, 4, 'SEGUN DIAGNOSTICO', 0, 'L', 0);
} else {

    $pdf->SetX(156);
    $pdf->MultiCell(36, 4, ' $ ' . ' ' . number_format($row->val_man, 0), 0, 'L', 0);
}


//////////////////////////////////////////////////////////////////

$pdf->Line(20, 123, 190, 123);
$pdf->Line(20, 131, 190, 131);
$pdf->Line(20, 123, 20, 131);
$pdf->Line(190, 123, 190, 131);
$pdf->SetY(123);
$pdf->SetX(7);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(200, 5, 'Pasados(60)dias a partir de la fecha de ingreso del bien,sin que el consumidor acuda a retirarlo se dara por abandonado.', 10, 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(200, 1, 'Segun articulo 18,LEY 1480 DE 2011', 0, 0, 'C');

/////////////////////////////////////////////////////////////////////////
$pdf->Line(140, 135, 190, 135);
$pdf->SetY(133.5);
$pdf->SetX(32);
$pdf->Cell(200, 1, 'RECIBIDO :', 0, 0, 'C');

$pdf->SetY(137);
$pdf->SetX(65);
$pdf->Cell(200, 1, sacarnombre($row->doc_cli), 0, 0, 'C');

$pdf->SetY(133);
$pdf->SetX(17);
$pdf->SetFont('Arial', '', 7);
//$pdf->multicell(200, 1,, 10, 1, 'C');
$pdf->MultiCell(20, 2,  '--Oklahoma--', 0, 'C', 0);

///////////////////////////////////////////////////////////////////////////////////
$pdf->Line(0, 142, 300, 142);





/////////////////////////////// FINAL PARTE 1 ///////////////////////////////////////


////////////////////////////// INICIO PARTE 2 ///////////////////////////////////////

$pdf->SetFont('Arial', 'B', 14);
$pdf->SetY(151);
$pdf->Image("../img/logo.png", 20, 148, 20, 15, "PNG", "http://evilnapsis.com/");
$pdf->MultiCell(220, 5, 'ORDEN DE SERVICIO - OKLAHOMA COMPUTADORES ' . sacarsede($row->sed_emp_man), 0, 'C', 0);
$pdf->SetFont('Arial', 'I', 10);
$pdf->MultiCell(220, 5, sacardireccion($row->sed_emp_man) . '' . ' TEL: ' . sacartelefono($row->sed_emp_man), 0, 'C', 0);

$pdf->Line(10, 147, 200, 147);
$pdf->Line(10, 164, 200, 164);
$pdf->Line(10, 147, 10, 164);
$pdf->Line(200, 147, 200, 164);

//////////////////////////////////////////////////////////////////

$pdf->SetY(164);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(310, 5, $row->id_man, 10, 1, 'C');

$pdf->Line(155, 169, 175, 169);

$pdf->Line(155, 164, 155, 169);
$pdf->Line(175, 164, 175, 169);

///////////////////////////////////////////////////////////////////

$pdf->SetY(164);
$pdf->Cell(360, 5, $fecha, 10, 1, 'C');

$pdf->Line(179, 169, 200, 169);

$pdf->Line(179, 164, 179, 169);
$pdf->Line(200, 164, 200, 169);


/////////////////////////////////////////////////////////////////////


$pdf->Line(10, 170, 200, 170);
$pdf->Line(10, 254, 200, 254);
$pdf->Line(10, 170, 10, 254);
$pdf->Line(200, 170, 200, 254);


//////////////////////////////////////////////////////////////////

$pdf->Line(15, 172, 95, 172);
$pdf->Line(15, 202, 95, 202);
$pdf->Line(15, 172, 15, 202);
$pdf->Line(95, 172, 95, 202);


$pdf->SetY(173);
$pdf->setFillColor(230, 230, 230);
$pdf->SetFont('Arial', 'B', 7);
$pdf->SetX(16);
$pdf->Cell(23, 6, 'IDENTIFICACION: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(174);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, $row->doc_cli, 0, 'L', 0);

$pdf->SetY(178.8);
$pdf->setFillColor(230, 230, 230);
$pdf->SetFont('Arial', 'B', 7);
$pdf->SetX(16);
$pdf->Cell(23, 6, 'NOMBRE: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(179.5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, sacarnombre($row->doc_cli), 0, 'L', 0);


$pdf->SetY(184.5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(23, 6, 'TELEFONO: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(185.5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, sacartelefonoc($row->doc_cli), 0, 'L', 0);


$pdf->SetY(190.3);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(23, 6, 'DIRECCION: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(191);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, sacardir($row->doc_cli), 0, 'L', 0);


$pdf->SetY(196);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(23, 5, 'CORREO: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(196.5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(38.5);
$pdf->MultiCell(53, 4, sacarcor($row->doc_cli), 0, 'L', 0);




$pdf->Line(100, 172, 195, 172);
$pdf->Line(100, 202, 195, 202);
$pdf->Line(100, 172, 100, 202);
$pdf->Line(195, 172, 195, 202);


$pdf->SetY(173);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 6, 'EQUIPO: ', 8, 8, 'L', 'TRUE');
$pdf->Ln(2);
$pdf->SetY(174);

$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->Multicell(78, 4, $row->equ_man, 0, 'L', 0);



$pdf->SetY(178.8);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 6, 'MARCA: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(179.5);
$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->MultiCell(79, 4, $row->mar_equ, 0, 'L', 0);

$pdf->SetY(184.5);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 6, 'REFERENCIA: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(185.5);

$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->MultiCell(72, 4, $row->ref_equ, 0, 'L', 0);


$pdf->SetY(190.3);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 6, 'SERIAL: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(191);

$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->MultiCell(20, 4, $row->mar_equ, 0, 'L', 0);


$pdf->SetY(196);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(101);
$pdf->Cell(20, 5, 'RECIBE: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(196.5);

$pdf->SetFont('Arial', '', 7);
$pdf->SetX(121);
$pdf->MultiCell(79, 4, sacarnombrempleado($row->id_usu), 0, 'L', 0);





$pdf->Line(15, 204, 195, 204);
$pdf->Line(15, 252, 195, 252);
$pdf->Line(15, 204, 15, 252);
$pdf->Line(195, 252, 195, 204);

$pdf->SetY(205);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'FALLA: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(207);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->fal_equ, 0, 'L', 0);

$pdf->SetY(212);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'ACCESORIOS: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(214);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->acc_equ, 0, 'L', 0);


$pdf->SetY(219);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'ESTADO DEL EQUIPO: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(221);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->est_equ, 0, 'L', 0);


$pdf->SetY(226);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'TRABAJO REALIZADO: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(228);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->tra_equ, 0, 'L', 0);


$pdf->SetY(232);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(16);
$pdf->Cell(30, 8, 'OBSERVACIONES: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(234);
$pdf->SetX(0);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(46);
$pdf->MultiCell(146, 4, $row->obs_man, 0, 'L', 0);


$pdf->SetY(245);
$pdf->SetFont('Arial', 'B', 7);
$pdf->setFillColor(230, 230, 230);
$pdf->SetX(140);
$pdf->Cell(50, 5, 'VALOR: ', 8, 8, 'L', 'TRUE');
$pdf->SetY(245.5);
$pdf->SetX(0);
$pdf->SetFont('Arial', 'B', 8);
if ($row->val_man == 0) {
    $pdf->SetX(153);
    $pdf->MultiCell(36, 4, ' ' . 'SEGUN DIAGNOSTICO', 0, 'L', 0);
} else {

    $pdf->SetX(156);
    $pdf->MultiCell(36, 4, ' $ ' . ' ' . number_format($row->val_man, 0), 0, 'L', 0);
}


//////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////


$pdf->Output();
