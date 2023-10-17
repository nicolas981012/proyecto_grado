<?php
require('../fpdf/fpdf.php');
require('../jpgraph/src/jpgraph.php');
require('../jpgraph/src/jpgraph_pie.php');
require('../jpgraph/src/jpgraph_pie3d.php');
require('../jpgraph/src/jpgraph_bar.php');
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
        $this->MultiCell(220, 20, 'REPORTE GARANTIAS REALIZADAS POR SEDE', 0, 'C', 0,);



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
        for($i = 0; $i < count($header); $i++)
            $this->Cell(80, 8, $header[$i], 1, 0, 'C', 1);
        $this->Ln();
        $this->SetFillColor(255, 204, 204);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 10);

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=soporte_tecnico_oklahoma', 'root', '');
        } catch (PDOException $error) {
            echo $error->getmessage();
        }
        $nombres = [];
        $cantidad = [];
        $select = $pdo->prepare("SELECT b.ciu_emp AS sede, count(c.id_gar) AS cantidad 
            FROM mantenimiento a 
            JOIN sedes_empresa b ON a.sed_emp_man = b.id_emp 
            JOIN garantia c ON a.id_man=c.id_man_gar 
            GROUP BY b.ciu_emp;");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_OBJ)) {
            $x = 0;
            $y = $this->GetY();
            $this->SetX(25);
            $this->Cell(80, 10, $row->sede, 1, 0, 'C', 0);
            $nombres[] = $row->sede;
            $this->Cell(80, 10, $row->cantidad, 1, 0, 'C', 0);
            $cantidad[] = $row->cantidad;
            $x++;
            $this->Ln();
        }

        $grafico = new Graph(700, 400, 'auto');
        $grafico->SetScale("textlin");
        $grafico->title->Set("");
        $grafico->xaxis->SetTickLabels($nombres);


        $barplot1 = new BarPlot($cantidad);
        $barplot1->SetWidth(30);

        $grafico->Add($barplot1);
        $grafico->Stroke("hola.png");
        $this->Image("hola.png", 30, 110, 150, 80);
    }
    public function gaficoPDF($datos = array(), $nombreGrafico = NULL, $ubicacionTamamo = array(), $titulo = NULL)
    {

        if (!is_array($datos) || !is_array($ubicacionTamamo)) {
            echo "los datos del grafico y la ubicacion deben de ser arreglos";
        } elseif ($nombreGrafico == NULL) {
            echo "debe indicar el nombre del grafico a crear";
        } else {

            foreach ($datos as $key => $value) {
                $data[] = $value[0];
                $nombres[] = $key;
                $color[] = $value[1];
            }
            $x = $ubicacionTamamo[0];
            $y = $ubicacionTamamo[1];
            $ancho = $ubicacionTamamo[2];
            $altura = $ubicacionTamamo[3];

            $graph = new PieGraph(600, 400);

            if (!empty($titulo)) {
                $graph->title->Set($titulo);
            }

            $p1 = new PiePlot3D($data);
            $p1->SetSliceColors($color);

            $p1->SetLegends($nombres);

            $graph->Add($p1);

            $graph->Stroke("$nombreGrafico.png");
            $this->Image("$nombreGrafico.png", $x, $y, $ancho, $altura);
        }
    }
}
$pdf = new PDF();
$header = array('SEDE', 'CANTIDAD GARANTIAS');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetXY(25, 60);
$pdf->TablaColores($header);
$pdf->Output();
