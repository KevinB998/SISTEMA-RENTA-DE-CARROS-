<?php

function consultarReserva($con, $id, $empieza, $por_pagina) {
    $consulta = "SELECT * FROM reserva "
            . "inner join vehiculo on id_vehiculo_r = id_vehiculo "
            . "inner join perfil_persona on cedula_r = cedula";
    if ($id != null) {
        $consulta .= " WHERE cedula_r = '$id' LIMIT $empieza, $por_pagina ";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}


function consultarReservaPag($con, $id) {
    $consulta = "SELECT * FROM reserva "
            . "inner join vehiculo on id_vehiculo_r = id_vehiculo "
            . "inner join perfil_persona on cedula_r = cedula";
    if ($id != null) {
        $consulta .= " WHERE cedula_r = '$id'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function consultarReservaAdmin($con, $id, $empieza, $por_pagina) {
    $consulta = "SELECT * FROM reserva LIMIT $empieza, $por_pagina";
    if ($id != null) {
        $consulta .= " WHERE cedula_r = '$id'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function consultarReservaPagAdmin($con, $id) {
    $consulta = "SELECT * FROM reserva";
    if ($id != null) {
        $consulta .= " WHERE cedula_r = '$id'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}


function insertarReserva($con, $id_vehiculo, $cedula, $can_asientos, $precio_reserva, $fecha_reserva, $fecha_entrega) {
    $insertar = $con->query("INSERT INTO reserva "
            ."(id_vehiculo_r, cedula_r, can_asientos, precio_reserva, fecha_reserva, fecha_entrega ) "
            . "VALUES('$id_vehiculo', '$cedula', '$can_asientos', '$precio_reserva', '$fecha_reserva', '$fecha_entrega')");
    return $insertar;
}

function actualizarReserva($con, $id_vehiculo, $id_cedula, $can_asientos, $precio_reserva, $fecha_reserva, $fecha_entrega, $idcedula) {
    $actualizar = $con->query("UPDATE reserva SET "
            . "id_vehiculo_r ='$id_vehiculo', "
            . "cedula_r = '$id_cedula', "
            . "can_asientos = '$can_asientos', "
            . "precio_reserva = '$precio_reserva', "
            . "fecha_reserva = '$fecha_reserva', "
            . "fecha_entrega =  '$fecha_entrega' WHERE cedula_r = '$idcedula'");
    return $actualizar;
}

function eliminarReserva($con, $idReserva) {
    $eliminar = $con->query("DELETE FROM reserva WHERE id_reserva = '$idReserva'");
    return $eliminar;
}

function actualizarRegistro($con,$id_vehiculo,$res){
      $actualizar = $con->query("UPDATE vehiculo SET "
            . "can_disponible = '$res' WHERE id_vehiculo = '$id_vehiculo'");
    return $actualizar;
}
