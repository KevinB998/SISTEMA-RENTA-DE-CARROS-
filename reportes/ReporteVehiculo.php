<?php
require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    //$this->Image('logo.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',11);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Reporte de vehiculos',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->Cell(30,10,'Identificador', 1, 0, 'C', 0);
    $this->Cell(30,10,'Marca', 1, 0, 'C', 0);
    $this->Cell(30,10,'Cant. Dispo', 1, 0, 'C', 0);
    $this->Cell(30,10,'Horario', 1, 0, 'C', 0);
    $this->Cell(30,10,'Dia', 1, 0, 'C', 0);
    $this->Cell(30,10,'Precio', 1, 1, 'C', 0);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

require '../recursos/conexion.php';
$consulta = "SELECT * FROM vehiculo";
$resultado = $con->query($consulta);


// Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',9);
    /*for($i=1;$i<=40;$i++)
        $pdf->Cell(0,10,utf8_decode('Imprimiendo línea número ').$i,0,1);*/

    /*while ($fila = mysqli_fetch_assoc($resultado)) {
        $pdf->Cell()
    }*/
    while ($fila = $resultado->fetch_assoc()) {
        $pdf->Cell(30,10,$fila['id_vehiculo'], 1, 0, 'C', 0);
        $pdf->Cell(30,10,$fila['marca'], 1, 0, 'C', 0);
        $pdf->Cell(30,10,$fila['can_disponible'], 1, 0, 'C', 0);
        $pdf->Cell(30,10,$fila['horarios'], 1, 0, 'C', 0);
        $pdf->Cell(30,10,$fila['dias'], 1, 0, 'C', 0);
        $pdf->Cell(30,10,$fila['precio'], 1, 1, 'C', 0);
        
    }

    $pdf->Output();
?>