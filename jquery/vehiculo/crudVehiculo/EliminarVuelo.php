<?php

require_once '../recursos/conexion.php';
require_once '../recursos/funcionesVuelo.php';
$idTabla = $_GET['codVue']; //OBLIGATORIAMENTE GET

if (eliminarVueloConUsr($con, $idTabla)) {
    if(eliminarVuelo($con, $idTabla)){
        header("location:ConsultarVuelo.php");
    }{
        echo '<script language="javascript"> alert("error");'
      . ' window.location="ConsultarVuelo.php" </script>';
    }
    
} else {
     echo '<script language="javascript"> alert("Registro no pudo ser eliminado !!\nReservas de vuelo encontradas");'
      . ' window.location="ConsultarVuelo.php" </script>';

     
}
?>