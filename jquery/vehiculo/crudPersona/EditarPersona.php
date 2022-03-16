<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("location:../Index.php");
}else{
       //sino, calculamos el tiempo transcurrido
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));

    //comparamos el tiempo transcurrido
     if($tiempo_transcurrido >= 300) {
     //si pasaron 10 minutos o más
      session_destroy(); // destruyo la sesión
      header("Location:../index.php"); //envío al usuario a la pag. de autenticación
      //sino, actualizo la fecha de la sesión
    }else {
    $_SESSION["ultimoAcceso"] = $ahora;
   }
}
require_once '../recursos/conexion.php';

require_once '../recursos/funcionesPersona.php';
require_once '../recursos/funcionesPerfil.php';

$codigo = $_GET['cod']; //codigo de consulta persona

$resultado = consultarPersona($con, $codigo);
if ($fila = mysqli_fetch_assoc($resultado)) {
    $id_perfil = null;

    $cmb_perfil = consultarPerfil($con, $id_perfil);
    $resultado_perfil = consultarPerfil($con, $fila['id_perfil']);
    $perfilEditar = mysqli_fetch_assoc($resultado_perfil);
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Actualizar datos</title>
            <link href="../estilos/css/bootstrap.css" rel="stylesheet">
            <title>Consultar persona</title>   
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
            <!-- CSS personalizado --> 
            <link rel="stylesheet" href="../main.css">  

            <!--datables CSS básico-->
            <link rel="stylesheet" type="text/css" href="../datatables/datatables.min.css"/>
            <!--datables estilo bootstrap 4 CSS-->  
            <link rel="stylesheet"  type="text/css" href="../datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">

            <!--font awesome con CDN-->  
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
            <link href="../bootstrap/css/global.css" rel="stylesheet" type="text/css"/>
        </head>
        <body>
             <style type="text/css">
            .topcorner{
                position: absolute; top:0; right:0;
                text-shadow: 1px 1px;
                font-size: 25px;
            }
        </style>
        <div class="topcorner"> <a href="../crudPersona/Logout.php" >Logout</a> </div>
        
        <section class="header">
            <h3>Consulta Perfil</h3>     
            <section class="user">
                <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
            </section>

        </section>
        <div style="height:50px"></div>
        
            <section class="row justify-content-center"> 
                <section class="col-12 col-sm-6 col-sm-3">
                    <form method="POST" id="actalizarConfirmacion">
                        <table border="2" class="table table-sm table-dark" style="max-width: 400px" >
                            <tr>
                                <td>Cédula</td>
                                <td><input type="text" name="cedula" value="<?php echo $fila['cedula'] ?>" id="cedula" readonly /> </td>
                            </tr>
                            <?php if ($_SESSION['idRol'] == 1) { ?>
                                <tr>
                                    <td>Id Perfil</td>
                                    <td> 
                                        <select name="idPerfil" required >
                                        
                                        <option value=""> -- Escoja una opción --</option>                               
                                            <?php while ($rowP = mysqli_fetch_assoc($cmb_perfil)) { ?>
                                                <option <?php
                                                echo "value='" . $rowP['id_perfil'] . "'";
                                                if ($rowP['id_perfil'] == $perfilEditar['id_perfil']) {
                                                    echo " selected ='selected'";
                                                }
                                                ?> > <?= $rowP['id_perfil'] . ' ' . $rowP['nombre_perfil'] ?> </option>    
                                                    <?php
                                                }
                                                ?>
                                            
                                        </select>

                                    </td>
                                </tr>
                            <?php } ?>

                            <input type="hidden" name="id_perfil" value="<?php echo $fila['id_perfil_p'] ?>" id="nombres"  />

                            <tr>
                                <td>Nombres</td>
                                <td><input type="text" name="nombres" value="<?php echo $fila['nombres'] ?>" id="nombres"  /></td>
                            </tr>
                            <tr>
                                <td>Apellidos</td>
                                <td><input type="text" name="apellidos" value="<?php echo $fila['apellidos'] ?>" id="apellidos" /></td>
                            </tr>
                            <tr>
                                <td>Dirección</td>
                                <td> <textarea name="direccion" rows="4" cols="23" id="direccion"> <?php echo $fila['direccion'] ?> </textarea></td> 
                            </tr>
                            <tr>
                                <td>Teléfono</td>
                                <td><input type="text" name="telf" value="<?php echo $fila['telefono'] ?>" id="telefono" /></td>
                            </tr> 
                            <tr>
                                <td>Correo</td>
                                <td><input type="text" name="correo" value="<?php echo $fila['email'] ?>" id="email"/></td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td><input type="text" name="usuario" value="<?php echo $fila['usuario'] ?>" id="usuario" /></td>
                            </tr>

                            <input type="hidden" name="clave" value="<?php echo $fila['clave'] ?>" id="usuario" />
                            
                            <tr>
                                <td> Desea Cambiar Contraseña</td>
                                <td>Si<input type="checkbox" name="pass" value="1" id="pass" /> </td>
                            </tr>

                            <tr>
                                <td>Ingrese Clave Anterior</td>
                                <td><input type="password" name="claveAnt" value="" id="claveAnt"  /></td>
                            </tr>
                            <tr>
                                <td>Ingrese Nueva Clave</td>
                                <td><input type="password" name="claveNue" value="" id="clave"  /></td>

                            </tr> 

                        </table>

                        <div align="center">
                            <br><input class="btn btn-success" type="submit" value="Actualizar" name="actualiza"/>
                            
                            <br><br><a class="btn btn-info" href="ConsultarPersona.php" > Regresar </a>

                        </div>
                        <?php
                    }
                    ?>
                </form>
            </section>
        </section>
    </body>
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="../jquery/jquery-3.3.1.min.js"></script>
    <script src="../popper/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <!-- datatables JS -->
    <script type="text/javascript" src="../datatables/datatables.min.js"></script>    

    <!-- para usar botones en datatables JS -->  
    <script src="../datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
    <script src="../datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="../datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="../datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="../datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

    <!-- código JS propìo-->    
    <script type="text/javascript" src="../main.js"></script> 
</html>

<?php
if (isset($_POST['actualiza'])) { // Name del botón
    $cedulA = $_POST['cedula'];
    $idPerfil = $_POST['id_perfil'];
    $nombrE = $_POST['nombres'];
    $apellidO = $_POST['apellidos'];
    $direccioN = $_POST['direccion'];
    $telefonO = $_POST['telf'];
    $correO = $_POST['correo'];
    $usuariO = $_POST['usuario'];
    $check = $_POST['pass'];
    $claveAnt = $_POST['claveAnt'];
    $claveNue = $_POST['claveNue'];
    $md5_pass = md5($claveAnt);
    $resultado = traerUsuario($con, $usuariO, $md5_pass);
    $cont = $resultado->num_rows;

    $contarUsuario = mysqli_num_rows(consultarUsuarioTest($con, $usuariO));

    if ($contarUsuario > 1) {
        echo '<script language="javascript"> alert("Usuario ya registrado\nIngrese otro !!");'
        . ' window.location="ConsultarPersona.php" </script>';
        
    } else {
        if ($check == 1) {
            if ($cont > 0) {
                $md5_passNue = md5($claveNue);
                if (actualizarPersona($con, $idPerfil, $nombrE, $apellidO, $direccioN, $telefonO, $correO, $usuariO, $md5_passNue, $cedulA)) {
                    echo '<script language="javascript"> alert("Se actualizó con exitó la contraseña !!");'
                    . ' window.location="ConsultarPersona.php" </script>';
                    
                } else {
                    echo '<script language="javascript"> alert("No se actualizó correctamente la información !!");'
                    . ' window.location="ConsultarPersona.php" </script>';
                    
                }
            } else {
                echo '<script language="javascript"> alert("Contraseña anterior incorrecta\nEvite cambiar el usuario\nPrueve de nuevo !!");'
                . ' window.location="ConsultarPersona.php" </script>';
                
            }
        } else {
            if (actualizarPersonaSin($con, $idPerfil, $nombrE, $apellidO, $direccioN, $telefonO, $correO, $usuariO, $cedulA)) {
                echo '<script language="javascript"> alert("Se actualizó correctamente la información !!");'
                . ' window.location="ConsultarPersona.php" </script>';
                
            } else {
                echo '<script language="javascript"> alert("No se actualizó correctamente la información !!");'
                . ' window.location="ConsultarPersona.php" </script>';
                
            }
        }
    }
}
?>