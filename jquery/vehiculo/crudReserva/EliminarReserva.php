<?php

require_once '../recursos/conexion.php';
require_once '../recursos/funcionesReserva.php';
$idTabla = $_GET['idPerR']; 

if (eliminarReserva($con, $idTabla)) {
    header("location:ConsultarReserva.php");
} else {
    echo '<script language="javascript"> alert("Registro no pudo ser eliminado !!");'
    . ' window.location="ConsultarReserva.php" </script>';
}
?>