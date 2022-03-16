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
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Vuelos de reserva',0,0,'C');
    // Salto de línea
    $this->Ln(20);

    $this->Cell(20,10,'Num.', 1, 0, 'C', 0);
    $this->Cell(20,10,'Vuelo', 1, 0, 'C', 0);
    $this->Cell(30,10,'Cedula', 1, 0, 'C', 0);
    $this->Cell(25,10,'Asientos', 1, 0, 'C', 0);
    $this->Cell(25,10,'Precio', 1, 0, 'C', 0);
    $this->Cell(35,10,'Fech Reserva', 1, 0, 'C', 0);
    $this->Cell(35,10,'Fech vuelo', 1, 1, 'C', 0);
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
$consulta = "SELECT * FROM reserva";
$resultado = $con->query($consulta);


// Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',12);
    /*for($i=1;$i<=40;$i++)
        $pdf->Cell(0,10,utf8_decode('Imprimiendo línea número ').$i,0,1);*/

    /*while ($fila = mysqli_fetch_assoc($resultado)) {
        $pdf->Cell()
    }*/
    while ($fila = $resultado->fetch_assoc()) {
        $pdf->Cell(20,10,$fila['id_reserva'], 1, 0, 'C', 0);
        $pdf->Cell(20,10,$fila['id_vuelo_r'], 1, 0, 'C', 0);
        $pdf->Cell(30,10,$fila['cedula_r'], 1, 0, 'C', 0);
        $pdf->Cell(25,10,$fila['can_asientos'], 1, 0, 'C', 0);
        $pdf->Cell(25,10,$fila['precio_reserva'], 1, 0, 'C', 0);
        $pdf->Cell(35,10,$fila['fecha_reserva'], 1, 0, 'C', 0);
        $pdf->Cell(35,10,$fila['fecha_vuelo'], 1, 1, 'C', 0);
    }

    $pdf->Output();
?>