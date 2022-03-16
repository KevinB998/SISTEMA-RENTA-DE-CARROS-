<?php

require_once '../recursos/conexion.php';
require_once '../recursos/funcionesVehiculo.php';
$idTabla = $_GET['codVue']; //OBLIGATORIAMENTE GET

if (eliminarVehiculoConUsr($con, $idTabla)) {
    if(eliminarVehiculo($con, $idTabla)){
        header("location:ConsultarVehiculo.php");
    }{
        echo '<script language="javascript"> alert("error");'
      . ' window.location="ConsultarVehiculo.php" </script>';
    }
    
} else {
     echo '<script language="javascript"> alert("Registro no pudo ser eliminado !!\nReservas de vuelo encontradas");'
      . ' window.location="ConsultarVuelo.php" </script>';

     
}
?>