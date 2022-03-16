
<?php
require '../recursos/conexion.php';
require '../recursos/funcionesPersona.php';
require '../recursos/funcionesPerfil.php';
session_start();
$ses = (!empty($_GET['id'])) ? $_GET['id'] : 0;
if (!isset($_SESSION['idUser']) and $ses != null) {
    header("location:../index.php");
}

$codP = null;
$resultadoPer = consultarPerfil($con, $codP);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Ingresar persona</title>    
        <script src="../validaciones/scriptPersona.js" type="text/javascript"></script>
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
        <style>
            body{
                background-color: #f3f4f7 !important;
            }
        </style>
        <script src="../validar.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container mb-5">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="text-center">Ingreso Datos Persona</h3>
                        </div>
                        <div class="card-body">
                        </div>
                        <div class="card-body">
                            <form class="row mb-n1" action="" method="POST" enctype ="multipart/form-data" onsubmit="return validar();" >            
                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="nombre" class="form-label">Cedula</label>   
                                    <input type="text"  class="form-control" name="cedula"  id="cedula" value="" onkeypress="return SoloNumeros(event)" maxlength="10" required />

                                </div>
                                <!--
                                <tr>
                                    <td>Id Perfil</td>
                                    <td><select name="id" size="1">
                                            <option value="" selected="selected">-- Escoja una opción </option> 
                                
                                <?php while ($filaPer = mysqli_fetch_assoc($resultadoPer)) { ?>
                                                                <option value="<?= $filaPer['id_perfil'] ?>"> <?= $filaPer['nombre_perfil'] . ":" . $filaPer['descripcion_perfil'] ?></option>
                                    <?php
                                }
                                ?>
                                
                                        </select>
                                    </td>
                                </tr>
                                -->
                                <div class="col-12 col-md-6 mt-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombres" value="" id="nombres" value="" placeholder="Ingrese el nombre" onkeypress="return SoloLetras(event);" maxlength="50" required/>
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label for="nombre" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" name="apellidos"  id="apellidos" value="" placeholder="Ingrese el apellido" onkeypress="return SoloLetras(event);" maxlength="50" required/>
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label for="nombre" class="form-label">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" value="" maxlength="50" required />
                                </div>

                                <div class="col-12 col-md-6 mt-3">
                                    <label for="nombre" class="form-label">Telefono</label>
                                    <input type="text"  class="form-control" name="telefono" value="" id="telefono"  value="" onkeypress="return SoloNumeros(event)" maxlength="10" required />
                                </div>

                                <div class="col-12 col-md-6 mt-3">
                                    <label for="nombre" class="form-label">Email</label>

                                    <input type="text" class="form-control" name="correo" value="" id="email" maxlength="30" />
                                </div>


                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="usuario" class="form-label">Usuario</label>                    
                                    <input type="text" class="form-control" name="usuario" value="" id="usuario" maxlength="20"/>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="clave" class="form-label">Contraseña</label>

                                    <input type="password" class="form-control" name="clave" value="" id="clave" maxlength="50" />
                                </div>
                                <div class="col-12 mt-3">
                                    <label for="foto" class="form-label">Foto</label>

                                    <input type="file" class="form-control" name="imagen" id="imagen" size="25" required/>
                                </div>




                                <div class="col-12 mt-4 text-center">
                                    <a class="btn btn-primary" href="consultarPersona.php" > Regreso a consulta </a>  
                                    <input class="btn btn-success" type="submit" value="Guardar"  onclick="return confirm('¿Los Datos ingresados estan correctos?')" name="guardo">
                                </div>  
                        </div>
                        </form>
                    </div>
                </div>
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
                if (isset($_POST['guardo'])) {
                    $cedulA = $_REQUEST['cedula'];
                    $idPerfil = 2;
                    $nombreS = $_REQUEST['nombres'];
                    $apellidoS = $_REQUEST['apellidos'];
                    $direccioN = $_REQUEST['direccion'];
                    $telefonO = $_REQUEST['telefono'];
                    $correO = $_REQUEST['correo'];
                    $usuariO = $_REQUEST['usuario'];
                    $clavE = $_REQUEST['clave'];
                    //$img = $_REQUEST['imagen'];

                    $md5_clave = md5($clavE);
                    $contarCodigo = mysqli_num_rows(consultarPersona($con, $cedulA));
                    $contarUsuario = mysqli_num_rows(consultarUsuarioTest($con, $usuariO));

                    /* $nombreImagen = $_FILES['imagen']['name'];
                      $tmpImagen = $_FILES['imagen']['tmp_name'];
                      $urlNueva = "imagen/foto" . $cedulA . ".jpg"; */

                    $img = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

                    /* if (is_uploaded_file($img)) {
                      copy($tmpImagen, $urlNueva);
                      echo "imagen cargada con exito";
                      } else {
                      echo "error al cargar";
                      } */

                    if ($contarCodigo != 0) {
                        echo '<script language="javascript"> alert("Cedula ya registrada\nIngrese otra !!"); </script>';
                    } else if ($contarUsuario != 0) {
                        echo '<script language="javascript"> alert("Usuario ya registrado\nIngrese otro !!"); </script>';
                    } else if (insertarPersona($con, $cedulA, $idPerfil, $nombreS, $apellidoS, $direccioN, $telefonO, $correO, $usuariO, $md5_clave, $img)) {
                        //header("location:ConsultarPersona.php");
                        echo '<script language="javascript"> alert("Usuario registrado con exito !!"); </script>';
                    } else {
                        echo '<script language="javascript"> alert("No se ingreso correctamente la información !!"); </script>';
                    }
                }
                ?>

