<?php

require_once '../recursos/conexion.php';
require_once '../recursos/funcionesPerfil.php';
$codigo = $_GET['codPer'];  
if (eliminarPerfil($con, $codigo)) {
    header("location:ConsultarPerfil.php");
} else {
    echo '<script languaje = "javascript"> '
    . 'alert("No es posible eliminar !!");'
    . 'window.location= "ConsultarPerfil.php" </script>';
}
?>
