<?php
require('../fpdf/fpdf.php');
include_once '../db/connect_db.php';
class PDF extends FPDF
{
        function Header()
        {
            
           

            $this->SetFont('Arial', 'B', 14);
            $this->SetY(12);
            $this->Image("../img/escudito.png", 40, 9, 20, 15, "PNG", "http://evilnapsis.com/");
            $this->setFillColor(230, 230, 230);
            $this->MultiCell(220, 20, 'REPORTE DOCENTES ACTIVOS ', 0, 'C', 0,);
           

           
            $this->Line(30, 25, 180, 25);
           
            
            
        }
       
            function TablaColores($header)
            {
            $this->SetFillColor(59,87,144);
            $this->SetTextColor(255);
            $this->SetDrawColor(128,0,0);
            $this->SetLineWidth(.1);
            $this->SetFont('','B');
            for($i=0;$i<count($header);$i++)
            $this->Cell(38,5,$header[$i],1,0,'C',1);
            $this->Ln();
            $this->SetFillColor(255,204,204);
            $this->SetTextColor(0);
            $this->SetFont('Arial','',10);
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=proyecto_grado', 'root', '');
            } catch (PDOException $error) {
                echo $error->getmessage();
            }
            $select = $pdo->prepare("SELECT * FROM docente");
            $select->execute();
            while($row=$select->fetch(PDO::FETCH_OBJ))
            {
                $this->Cell(38,7,$row->idDocente,1);
                $this->Cell(38,7,$row->Nombre,1);
                $this->Cell(38,7,$row->Apellido,1);
                $this->Cell(38,7,$row->Telefono,1);
                $this->Cell(38,7,$row->estado,1);
               
                $this->Ln();
            }

            
            } 
            function datos(){

                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=proyecto_grado', 'root', '');
                } catch (PDOException $error) {
                    echo $error->getmessage();
                }
                $select = $pdo->prepare("SELECT * FROM docente");
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
                $this->Cell(23, 5, 'IDENTIFICACION: ', 8, 8, 'L', 'TRUE');
                $this->SetY(47);
                $this->SetFont('Arial', '', 7);
                $this->SetX(38.5);
                $this->MultiCell(53, 4, $row->idDocente, 0, 'L', 0);
    
                $this->SetY(51.8);
                $this->setFillColor(230, 230, 230);
                $this->SetFont('Arial', 'B', 7);
                $this->SetX(16);
                $this->Cell(25, 5, 'NOMBRE: ', 8, 8, 'L', 'TRUE');
                $this->SetY(52.5);
                $this->SetFont('Arial', '', 7);
                $this->SetX(38.5);
                $this->MultiCell(53, 4, $row->Nombre, 0, 'L', 0);
    
    
                $this->SetY(57.5);
                $this->SetFont('Arial', 'B', 7);
                $this->setFillColor(230, 230, 230);
                $this->SetX(16);
                $this->Cell(23, 5, 'APELLIDO: ', 8, 8, 'L', 'TRUE');
                $this->SetY(58.5);
                $this->SetFont('Arial', '', 7);
                $this->SetX(38.5);
                $this->MultiCell(53, 4, $row->Apellido, 0, 'L', 0);
    
                $this->Line(100, 65, 100, 45);
                $this->Line(100, 45, 195, 45);
                $this->Line(100, 65, 195, 65);
                $this->Line(195, 65, 195, 45);
    
                $this->SetY(46.5);
                $this->SetFont('Arial', 'B', 7);
                $this->setFillColor(230, 230, 230);
                $this->SetX(101);
                $this->Cell(20, 5, 'TELEFONO: ', 8, 8, 'L', 'TRUE');
                $this->Ln(2);
                $this->SetY(47);
                $this->SetFont('Arial', '', 7);
                //$pdf->Cell(250, 4, $row->equ_man, 8, 8, 'C');
                $this->SetX(121);
                //$pdf->MultiCell(240,4, $row->equ_man, 0, 'C', 0);
                $this->Multicell(78, 4, $row->Telefono, 0, 'L', 0);
    
                $this->SetY(51.8);
                $this->SetFont('Arial', 'B', 7);
                $this->setFillColor(230, 230, 230);
                $this->SetX(101);
                $this->Cell(20, 5, 'ESTADO: ', 8, 8, 'L', 'TRUE');
                $this->SetY(52.5);
                $this->SetFont('Arial', '', 7);
                //$pdf->Cell(218, 4, $row->mar_equ, 8, 8, 'C');
                $this->SetX(121);
                $this->MultiCell(79, 4, $row->estado, 0, 'L', 0);
    
                
            }
}
    $pdf=new PDF();
    $header=array('ID','NOMBRE','APELLIDO','TELEFONO','ESTADO');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->TablaColores($header);
    $pdf->Output();