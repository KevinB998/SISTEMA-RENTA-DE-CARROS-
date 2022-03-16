<?php


function consultarPersona($con, $id) {
    $consulta = "SELECT * FROM perfil_persona "."inner join perfil on id_perfil_p = id_perfil";
    if ($id != null) {
        $consulta .= " WHERE cedula = '$id'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}


function consultarUsuario($con, $usuario, $empieza, $por_pagina) {
    $consulta = "SELECT * FROM perfil_persona LIMIT $empieza, $por_pagina";
    if ($usuario != null) {
        $consulta .= " WHERE usuario = '$usuario'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function consultarUsuarioTest($con, $usuario) {
    $consulta = "SELECT * FROM perfil_persona";
    if ($usuario != null) {
        $consulta .= " WHERE usuario = '$usuario'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function consultarUsuarioAdmin($con) {
    $consulta = "SELECT * FROM perfil_persona";
    $resultado = $con->query($consulta);
    return $resultado;
}


function traerUsuario($con, $user, $clave) {
    $consulta = "SELECT * FROM perfil_persona WHERE usuario = '$user'";
    if ($clave != null) {
        $consulta .= " AND clave = '$clave'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}

function insertarPersona($con, $cedula, $idPerfil, $nombres, $apellidos, $direccion, $telefono, $correo, $usuario, $clave, $img) {
    $insertar = $con->query("INSERT INTO perfil_persona "
            . "(cedula, id_perfil_p, nombres, apellidos, direccion, telefono, email, usuario, clave, imagen) "
            . "VALUES('$cedula', '$idPerfil', '$nombres', '$apellidos', '$direccion', '$telefono', '$correo', '$usuario', '$clave', '$img')");
    return $insertar;
}

function actualizarPersona($con, $idPerfil, $nombres, $apellidos, $direccion, $telefono, $correo, $usuario, $clave, $cedula) {
    $actualizar = $con->query("UPDATE perfil_persona SET "
            . "id_perfil_p ='$idPerfil', "
            . "nombres = '$nombres', "
            . "apellidos = '$apellidos', "
            . "direccion = '$direccion', "
            . "telefono = '$telefono', "
            . "email = '$correo', "
            . "usuario = '$usuario', "
            . "clave = '$clave' WHERE cedula ='$cedula'");
    return $actualizar;
}
function actualizarPersonaSin($con, $idPerfil, $nombres, $apellidos, $direccion, $telefono, $correo, $usuario, $cedula) {
    $actualizar = $con->query("UPDATE perfil_persona SET "
            . "id_perfil_p ='$idPerfil', "
            . "nombres = '$nombres', "
            . "apellidos = '$apellidos', "
            . "direccion = '$direccion', "
            . "telefono = '$telefono', "
            . "email = '$correo', "
            . "usuario = '$usuario' WHERE cedula ='$cedula'");
    return $actualizar;
}

function eliminarPersona($con, $cedula) {
    $eliminar = $con->query("DELETE FROM perfil_persona WHERE cedula = '$cedula'");
    return $eliminar;
}

function eliminarPersonaTest($con, $cedula) {
    $eliminar = $con->query("DELETE FROM reserva 
    WHERE cedula_r IN (SELECT cedula FROM perfil_persona WHERE cedula = '$cedula')");
    return $eliminar;
    //DELETE FROM reserva WHERE `cedula_r` IN (SELECT `cedula_r` FROM perfil_persona WHERE `cedula` = 2222222222)
    //SELECT * FROM perfil_persona WHERE `cedula` IN (SELECT `cedula_r` FROM reserva WHERE `cedula_r` = 2222222222)
}


?>