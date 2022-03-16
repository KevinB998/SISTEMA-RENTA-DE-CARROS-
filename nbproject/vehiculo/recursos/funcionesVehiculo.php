<?php
function consultarVehiculo($con, $id_vehiculo) {
    $consulta = "SELECT * FROM vehiculo";
    if ($id_vehiculo != null) {
        $consulta .= " WHERE id_vehiculo = '$id_vehiculo'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}


function insertarVehiculo($con, $id, $marca, $categoria, $can_disponible, $horarios, $dias, $precio, $impuesto ) {
    $insertar = $con->query("INSERT INTO vehiculo(id_vehiculo, aerolinea, categoria, can_disponible, horarios, dias, precio, impuesto )"
            . "VALUES ('$id','$aerolinea','$categoria', '$can_disponible', '$horarios', '$dias', '$precio', '$impuesto')");
    return $insertar;
}

function actualizarVehiculo($con, $id, $marca, $categoria, $can_disponible, $horarios, $dias, $precio, $impuesto  ) {
    
    $actualizar = $con->query("UPDATE vehiculo SET marca = '$marca', categoria = '$categoria', can_disponible = '$can_disponible', horarios = '$horarios', dias = '$dias', precio = '$precio', impuesto = '$impuesto'  WHERE id_vehiculo = '$id'");
    return $actualizar;
}

function eliminarVehiculo($con, $id) {
    $eliminar = $con->query("DELETE FROM vehiculo WHERE id_vehiculo = '$id'");
    return $eliminar;
}

function eliminarVehiculoloConUsr($con, $id) {
    $eliminar = $con->query("DELETE FROM reserva  
    WHERE id_vehiculo_r IN (SELECT id_vuelo FROM vehiculo WHERE id_vehiculo = '$id')");
    return $eliminar;

    //$eliminar = $con->query("DELETE FROM vuelo   
    //WHERE id_vuelo IN (SELECT id_vuelo_r FROM reserva WHERE id_vuelo_r = '$id')");
    //return $eliminar;
    
    //DELETE FROM reserva WHERE `cedula_r` IN (SELECT `cedula_r` FROM perfil_persona WHERE `cedula` = 2222222222)
    //DELETE FROM reserva WHERE `id_vuelo_r`IN (SELECT `id_vuelo` FROM vuelo WHERE `id_vuelo` = 11)
}


?>