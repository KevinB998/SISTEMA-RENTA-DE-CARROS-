
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
        <link href="../bootstrap/css/global.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>  
        <section class="header">
        <h3 align="center">Ingreso datos persona</h3>    
        </section>
        <div class="container" style=" max-width: 400px">
            <div class="col-lg-12">   
                <form  action="" method="POST" enctype ="multipart/form-data" onsubmit="return validar();" >            
                    <table  border="2" align="center" class="table table-sm table-dark"> 
                        <tr>
                            <td>Cédula</td>
                            <td><input type="text"  name="cedula" value="" id="cedula"/></td>

                        </tr>
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
                        <tr>
                            <td>Nombres</td>
                            <td><input type="text" name="nombres" value="" id="nombres" /></td>
                        </tr>
                        <tr>
                            <td>Apellidos</td>
                            <td><input type="text" name="apellidos" value="" id="apellidos" /></td>
                        </tr>
                        <tr>
                            <td>Dirección</td>
                            <td><p> <textarea name="direccion" rows="3" cols="20" id="direccion" >  </textarea> </p> </td>    

                        </tr>
                        <tr>
                            <td>Teléfono</td>
                            <td><input type="text" name="telefono" value="" id="telefono" /></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><input type="text" name="correo" value="" id="email" /></td>
                        </tr>
                        <tr>
                            <td>Usuario</td>                        
                            <td><input type="text" name="usuario" value="" id="usuario" /></td>
                        </tr>
                        <tr>
                            <td>Clave</td>                        
                            <td><input type="password" name="clave" value="" id="clave" /></td>
                        </tr>
                        <tr>  
                            <td>
                                <input type="file" name="imagen" id="imagen" size="25" required/>
                                <div id="muestraImg"></div>
                            </td>

                        </tr>

                    </table>           
                    <div align="center">
                        <br><input class="btn btn-success" type="submit" value="Guardar" name="guardo" >
                        <br><br><a class="btn btn-info" href="ConsultarPersona.php" > Regresar </a>   
                        <p class="warnings" id="warnings" style="color: red;"></p>
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

    /*$nombreImagen = $_FILES['imagen']['name'];
    $tmpImagen = $_FILES['imagen']['tmp_name'];
    $urlNueva = "imagen/foto" . $cedulA . ".jpg";*/

    $img = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

    /*if (is_uploaded_file($img)) {
        copy($tmpImagen, $urlNueva);
        echo "imagen cargada con exito";
    } else {
        echo "error al cargar";
    }*/

    if ($contarCodigo != 0) {
        echo '<script language="javascript"> alert("Cedula ya registrada\nIngrese otra !!"); </script>';
    } else if ($contarUsuario != 0) {
        echo '<script language="javascript"> alert("Usuario ya registrado\nIngrese otro !!"); </script>';
    } else if (insertarPersona($con, $cedulA, $idPerfil, $nombreS, $apellidoS, $direccioN, $telefonO, $correO, $usuariO, $md5_clave, $img)) {
        //header("location:ConsultarPersona.php");
        echo '<script language="javascript"> alert("Usuario registrado con exito !!"); </script>';
    }else {
        echo '<script language="javascript"> alert("No se ingreso correctamente la información !!"); </script>';
    }
}
?>

