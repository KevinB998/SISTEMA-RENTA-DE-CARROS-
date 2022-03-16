<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("location:../index.php");
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
require_once '../recursos/funcionesVehiculo.php';
require_once '../recursos/funcionesReserva.php';

$idPV = $_GET['idPerRe']; //VARIABLE DEL BOTTON 
$resultado = consultarReservaPag($con, $idPV);

if ($row = mysqli_fetch_assoc($resultado)) {
    $cod_persona = null;
    $id_vehiculo = null;
    // VARIABLE DE LOS COMBO BOX
    $cmb_persona = consultarPersona($con, $cod_persona);
    $cmb_vuelo = consultarVehiculo($con, $id_vehiculo);

    $resultadoPersona = consultarPersona($con, $row['cedula']);
    $personaEditar = mysqli_fetch_assoc($resultadoPersona);

    $resultadovuelo = consultarVehiculo($con, $row['id_vehiculo']);
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



            <!--font awesome con CDN-->  
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
            <link href="../bootstrap/css/global.css" rel="stylesheet" type="text/css"/>
       
            <script src="../validaciones/scriptReserva.js" type="text/javascript"></script>
        
        </head>
    </head>
    <body>
        <style type="text/css">
            .topcorner{
                position: absolute;
                top:0;
                right:0;
                text-shadow: 1px 1px;
                font-size: 25px;
            }
        </style>
        <div class="topcorner"> <a href="../crudPersona/Logout.php" >Logout</a> </div>
        <div class="container mb-5">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="text-center">Editar Datos Reserva</h3>
                        </div>
                        <div class="card-body">


                            <form   class="row mb-n1" action="" method="POST" onsubmit="return validar();">
                                <input  class="form-control" type="hidden" name="id" value="<?php $row['id_reserva'] ?>" />

                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="marca" class="form-label">Persona</label>
                                    <select name="persona" id="persona" class="form-select" required>
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
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="marca" class="form-label">Vehiculo</label>
                                    <select name="vehiculo" id="vehiculo" class="form-select" required>
                                        <option value=""> -- Escoja una opción --</option>                               
                                        <?php while ($rowV = mysqli_fetch_assoc($cmb_vuelo)) { ?>
                                            <option <?php
                                            echo "value='" . $rowV['id_vehiculo'] . "'";
                                            if ($rowV['id_vehiculo'] == $vueloEditar['id_vehiculo']) {
                                                echo " selected ='selected'";
                                            }
                                            ?> > <?= $rowV['marca'] . ' ' . $rowV['categoria'] ?> </option>    
                                                <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="asientos" class="form-label"> Cantidad Asientos</label>
                                    <input type="number" class="form-control" min="1" name="can_asientos" value="<?php echo $row['can_asientos'] ?>" id="can_asientos" />
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="precio_reserva" class="form-label">Precio Reserva</label>
                                    <input type="number" class="form-control" name="precio_reserva" value="<?php echo $row['precio_reserva'] ?>" readonly="" style="width: 90px" />
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="fecha_reserva" class="form-label">Fecha Reserva</label>
                                    <input type="date" class="form-control" name="fecha_reserva" value="<?php echo $row['fecha_reserva'] ?>" id="fecha_reserva" />
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="fecha_entrega" class="form-label">Fecha Entrega</label>
                                    <input type="date" name="fecha_entrega" value="<?php echo $row['fecha_entrega'] ?>" id="fecha_entrega" />
                                </div>



                                <div class="col-12 mt-4  text-center">
                                    <a class="btn btn-primary" href="ConsultarReserva.php" > Regresar </a>
                                    <input type="submit" class="btn btn-success" value="Actualizar" onclick="return confirm('Desea ir a actualizar!!')" name="actualiza" />
                                </div>
                        </div><!-- comment -->
                    </div><!-- comment -->
                </div><!-- comment -->
            </div>

        </div>



    </div>
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
    $vehiculo = $_REQUEST['vehiculo'];
    $can_asientos = $_REQUEST['can_asientos'];
    $precio_reserva = $_REQUEST['precio_reserva'];
    $fecha_reserva = $_REQUEST['fecha_reserva'];
    $fecha_entrega = $_REQUEST['fecha_entrega'];

    if (actualizarReserva($con, $vehiculo, $cliente, $can_asientos, $precio_reserva, $fecha_reserva, $fecha_entrega, $idPV)) {
        echo '<script languaje = "javascript"> '
        . 'alert("Información Actualizada Exitosamente !!");'
        . 'window.location= "ConsultarReserva.php" </script>';
    } else {
        echo "Error al actualizar !!";
    }
}
?>    

