<?php

$con = new mysqli("localhost","root","","bdd_vehiculos");
if ($con->connect_error) {
    echo "ERROR EN LA CONEXION :N° ".$con->connect_errno."<br> Detalle:".$con->connect_error;
    
}else{
   // echo "CONEXION EXITOSA !!!";
}


?>

