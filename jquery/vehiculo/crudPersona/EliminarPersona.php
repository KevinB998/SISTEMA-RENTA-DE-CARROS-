<?php

require_once '../recursos/conexion.php';
require_once '../recursos/funcionesPersona.php';
$idTabla = $_GET['codPer']; //OBLIGATORIAMENTE GET

if (eliminarPersonaTest($con, $idTabla) && eliminarPersona($con, $idTabla)) {
    header("location:ConsultarPersona.php");
} else {
     echo '<script language="javascript"> alert("Registro no pudo ser eliminado !!\nReservas de vuelo encontradas");'
      . ' window.location="ConsultarPersona.php" </script>';

     
}
?>