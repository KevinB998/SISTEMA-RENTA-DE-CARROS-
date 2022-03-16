<?php
function consultarPerfil($con, $idPerfil) {
    $consulta = "SELECT * FROM perfil";
    if ($idPerfil != null) {
        $consulta .= " WHERE id_perfil = '$idPerfil'";
    }
    $resultado = $con->query($consulta);
    return $resultado;
}


function insertarPerfil($con, $id, $nombre, $descripcion ) {
    $insertar = $con->query("INSERT INTO perfil(id_perfil, nombre_perfil, descripcion_perfil )"
            . "VALUES ('$id','$nombre','$descripcion')");
    return $insertar;
}

function actualizarPerfil($con, $id, $nombre, $descripcion ) {
    
    $actualizar = $con->query("UPDATE perfil SET nombre_perfil = '$nombre', descripcion_perfil = '$descripcion'  WHERE id_perfil = '$id'");
    return $actualizar;
}

function eliminarPerfil($con, $id) {
    $eliminar = $con->query("DELETE FROM perfil WHERE id_perfil = '$id'");
    return $eliminar;
}
?>