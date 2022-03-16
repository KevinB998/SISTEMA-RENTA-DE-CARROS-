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
    $this->Cell(30,10,'Reporte de usuarios',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->Cell(30,10,'Cedula', 1, 0, 'C', 0);
    $this->Cell(25,10,'Nombres', 1, 0, 'C', 0);
    $this->Cell(30,10,'Apellidos', 1, 0, 'C', 0);
    $this->Cell(35,10,'Direccion', 1, 0, 'C', 0);
    $this->Cell(30,10,'Email', 1, 0, 'C', 0);
    $this->Cell(30,10,'Usuario', 1, 1, 'C', 0);
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
$consulta = "SELECT * FROM perfil_persona";
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
        $pdf->Cell(30,10,$fila['cedula'], 1, 0, 'C', 0);
        $pdf->Cell(25,10,$fila['nombres'], 1, 0, 'C', 0);
        $pdf->Cell(30,10,$fila['apellidos'], 1, 0, 'C', 0);
        $pdf->Cell(35,10,$fila['direccion'], 1, 0, 'C', 0);
        $pdf->Cell(30,10,$fila['email'], 1, 0, 'C', 0);
        $pdf->Cell(30,10,$fila['usuario'], 1, 1, 'C', 0);
    }

    $pdf->Output();
?>