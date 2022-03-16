<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("location:../Index.php");
} else {
    //sino, calculamos el tiempo transcurrido
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora) - strtotime($fechaGuardada));

    //comparamos el tiempo transcurrido
    if ($tiempo_transcurrido >= 300) {
        //si pasaron 10 minutos o más
        session_destroy(); // destruyo la sesión
        header("Location:../index.php"); //envío al usuario a la pag. de autenticación
        //sino, actualizo la fecha de la sesión
    } else {
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
            <script src="../validar.js" type="text/javascript"></script>
        
        </head>
        <body >
            <style type="text/css">
                .topcorner{
                    position: absolute;
                    top:0;
                    right:0;
                    text-shadow: 1px 1px;
                    font-size: 25px;
                    text-align: justify;
                }
            </style>
            <div class="topcorner"> <a href="../crudPersona/Logout.php" >Logout</a> </div>

            <div class="container mb-5">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <h3 class="text-center">Editar Datos Persona</h3>
                            </div>
 <div class="card-body " >  
                        <div class="container mb-5">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white"> 
                            <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>

                            </div>

                            <div class="card-body">
                                <form class="row mb-n1" method="POST" id="actalizarConfirmacion">


                                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="cedula" class="form-label">Cédula</label>
                                        <input type="text" class="form-control" name="cedula" value="<?php echo $fila['cedula'] ?>" id="cedula" readonly  onkeypress="return SoloNumeros(event)" maxlength="10" required />
                                    </div>





                                    <?php if ($_SESSION['idRol'] == 1) { ?>
                                       <div class="col-12 col-md-6 mt-3">
                                           <label ">ID PERFIL</label>
                                                <select class="form-select" name="idPerfil" required >

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

                                        <input type="hidden" class="form-control" name="id_perfil" value="<?php echo $fila['id_perfil_p'] ?>" id="nombres"  />
                                       </div>
                                       <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <td><input type="text" class="form-control" name="nombres" value="<?php echo $fila['nombres'] ?>" id="nombres"  onkeypress="return SoloLetras(event);" maxlength="50" />
                                       </div>
                                       <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" name="apellidos" value="<?php echo $fila['apellidos'] ?>" id="apellidos" onkeypress="return SoloLetras(event);" maxlength="50" />
                                    </div>   
                                        
                                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" id="direccion" value="<?php echo $fila['direccion'] ?>" maxlength="50" />
                                    </div>
                                                                   
                                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" name="telf" value="<?php echo $fila['telefono'] ?>" id="telefono"  maxlength="10" onkeypress="return SoloNumeros(event)" maxlength="10" required />
                                    </div>    
                                 <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="email" class="form-label">Correo</label>
                                     <input type="text" class="form-control" name="correo" value="<?php echo $fila['email'] ?>" id="email" maxlength="30" />
                                    </div>   
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="usuario" class="form-label">Usuario</label>
                              <input type="text" class="form-control" name="usuario" value="<?php echo $fila['usuario'] ?>" id="usuario"  maxlength="20"/>
                            
                                    </div>
                                    
                                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="usuario" class="form-label"></label>
                                    <input type="hidden" class="form-control" name="clave" value="<?php echo $fila['clave'] ?>" id="usuario" />
                                    </div>
                                    
                                     <div class="col-10 col-md-4 ">
                                        <label for="usuario" class="form-label">Desea Cambiar la Contraseña clic en el cuadro blanco</label>
                                   <input type="checkbox"  class="form-control" name="pass" value="1" id="pass" /> </td>
                                     </div>
                                    <br>
                                     <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="usuario" class="form-label">Ingrese su contraseña anterior</label>
                                       <input type="password"  class="form-control" name="claveAnt" value="" id="claveAnt"  /></td>
                                     </div>
                                    
                                       <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="usuario" class="form-label">Nueva contraseña</label>
                                    <input type="password" class="form-control" name="claveNue" value="" id="clave"  /></td>

                                    
                                <div class="col-12 mt-2 text-center">
                                    <a class="btn btn-primary" href="ConsultarPersona.php" > Regresar </a>  
                                    <input class="btn btn-success" type="submit" value="Actualizar" onclick="return confirm('¿Los Datos estan Actualizados')" name="actualiza">
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
