<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("location:../index.php");
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
require_once '../recursos/funcionesVuelo.php';
require_once '../recursos/funcionesReserva.php';

$idPV = $_GET['idPerRe']; //VARIABLE DEL BOTTON 
$resultado = consultarReservaPag($con, $idPV);

if ($row = mysqli_fetch_assoc($resultado)) {
    $cod_persona = null;
    $id_vuelo = null;
    // VARIABLE DE LOS COMBO BOX
    $cmb_persona = consultarPersona($con, $cod_persona);
    $cmb_vuelo = consultarVuelo($con, $id_vuelo);

    $resultadoPersona = consultarPersona($con, $row['cedula']);
    $personaEditar = mysqli_fetch_assoc($resultadoPersona);

    $resultadovuelo = consultarVuelo($con, $row['id_vuelo']);
    $vueloEditar = mysqli_fetch_assoc($resultadovuelo);
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
            <script src="../validaciones/scriptReserva.js" type="text/javascript"></script>
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
            <h3>Editar Reservas</h3>
            <section class="user">
                <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
            </section>

        </section>
        <div style="height:50px"></div>

        <section class="row justify-content-center">
            <section class="col-12 col-sm-6 col-sm-3">
                <div align="center">


                    <form  action="" method="POST" onsubmit="return validar();">
                        <table border="1" class="table table-dark" style="max-width: 300px">
                            <input type="hidden" name="id" value="<?php $row['id_reserva'] ?>" />
                            <tr>
                                <td>Persona</td>
                                <td>
                                    <select name="persona" id="persona" >
                                        <option value=""> -- Escoja una opción --</option>                               
                                        <?php while ($rowP = mysqli_fetch_assoc($cmb_persona)) { ?>
                                            <option <?php
                                            echo "value='" . $rowP['cedula'] . "'";
                                            if ($rowP['cedula'] == $personaEditar['cedula']) {
                                                echo " selected ='selected'";
                                            }
                                            ?> > <?= $rowP['nombres'] . ' ' . $rowP['apellidos'] ?> </option>    
                                                <?php
                                            }
                                            ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Vuelo</td>
                                <td>
                                    <select name="vuelo" id="vuelo" >
                                        <option value=""> -- Escoja una opción --</option>                               
                                        <?php while ($rowV = mysqli_fetch_assoc($cmb_vuelo)) { ?>
                                            <option <?php
                                            echo "value='" . $rowV['id_vuelo'] . "'";
                                            if ($rowV['id_vuelo'] == $vueloEditar['id_vuelo']) {
                                                echo " selected ='selected'";
                                            }
                                            ?> > <?= $rowV['aerolinea'] . ' ' . $rowV['categoria'] ?> </option>    
                                                <?php
                                            }
                                            ?>
                                    </select>
                                </td>

                            </tr>
                            <tr>
                                <td>Cantidad Asientos</td>
                                <td><input type="number" min="1" name="can_asientos" value="<?php echo $row['can_asientos'] ?>" id="can_asientos" /></td>
                            </tr>
                            <tr>
                                <td>Precio Reserva</td>
                                <td><input type="number" name="precio_reserva" value="<?php echo $row['precio_reserva'] ?>" readonly="" style="width: 90px" /></td>
                            </tr>
                            <tr>
                                <td>Fecha Reserva </td>
                                <td><input type="date" name="fecha_reserva" value="<?php echo $row['fecha_reserva'] ?>" id="fecha_reserva" /></td>
                            </tr>
                            <tr>
                                <td>Fecha Vuelo</td>
                                <td><input type="date" name="fecha_vuelo" value="<?php echo $row['fecha_vuelo'] ?>" id="fecha_vuelo" /></td>
                            </tr>
                        </table>
                        <br><input class="btn btn-success" type="submit" value="Actualizar" name="actualiza" onclick="return confirm('Seguro Actualizar !!')" />
                        <p class="warnings" id="warnings" style="color: red;"></p>
                        <br><br><a class="btn btn-info" href="ConsultarReserva.php"> Regresar </a>

                        <?php
                    }
                    ?>
                </form>
            </div>
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
if (isset($_POST['actualiza'])) {
    $idreserva = $_REQUEST['id'];
    $cliente = $_REQUEST['persona'];
    $vuelo = $_REQUEST['vuelo'];
    $can_asientos = $_REQUEST['can_asientos'];
    $precio_reserva = $_REQUEST['precio_reserva'];
    $fecha_reserva = $_REQUEST['fecha_reserva'];
    $fecha_vuelo = $_REQUEST['fecha_vuelo'];

    if (actualizarReserva($con, $vuelo, $cliente, $can_asientos, $precio_reserva, $fecha_reserva, $fecha_vuelo, $idPV)) {
        echo '<script languaje = "javascript"> '
        . 'alert("Información Actualizada Exitosamente !!");'
        . 'window.location= "ConsultarReserva.php" </script>';
    } else {
        echo "Error al actualizar !!";
    }
}
?>    

