
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
$codP = null;
$idV = null;
$resultadoPer = consultarPersona($con, $codP);
$resultadoVue = consultarVehiculo($con, $idV);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">      
        <title>Insertar registro reserva</title>
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
        <script src="../validaciones/scriptReserva.js" type="text/javascript"></script>
    </head>
    <body>

        <div class="topcorner"> <a href="../crudPersona/Logout.php" >Logout</a> </div>
        <div class="container mb-5">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">

                            <h4 class="text-center">Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
                        </div>
                        <div class="container mb-5">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-dark text-white">
                                            <h3 class="text-center">Ingreso Datos Reserva</h3>
                                        </div>
                                        <form  class="row mb-n1" action="" method="POST" onsubmit="return validar();">           
                                            <table  border="2" class="table table-sm table-dark" style="max-width: 300px" > 
                                                <?php if ($_SESSION['idRol'] == 1) { ?>
                                                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                                                        <label for="cedula" class="form-label">Persona</label>
                                                        <select name="cedula" id="persona"  size="1" class="form-select" required>
                                                            <option value="" selected="selected">-- Escoja una opción </option> 
                                                            <?php while ($filaPer = mysqli_fetch_assoc($resultadoPer)) { ?>
                                                                <option value="<?= $filaPer['cedula'] ?>"> <?= $filaPer['nombres'] . " " . $filaPer['apellidos'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td>Cedula</td>
                                                        <td> <input type="text" readonly name="cedula" id="persona" value="<?php echo $_SESSION['idUser'] ?>" /> </td>
                                                    </tr>
                                                <?php } ?>
                                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                                    <label for="vehiculo" class="form-label">Vehiculo</label>
                                                    <select name="vehiculo" id="vehiculo" class="form-select" required>
                                                        <option value="" selected="selected"> -- Escoja una opción </option>                           
                                                        <?php while ($filaVue = mysqli_fetch_assoc($resultadoVue)) { ?>
                                                            <option value="<?= $filaVue['id_vehiculo'] ?>"> <?= "Marca: " . $filaVue['marca'] . " - " . $filaVue['categoria'] ?>   </option>

                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="col-12 col-md-6 mt-3">
                                                    <label for="asientos" class="form-label"> Cantidad Asientos</label>
                                                    <input type="number" class="form-control" min="1" name="can_asientos" id="can_asientos" value="" />
                                                </div>

                                                <div class="col-12 col-md-6 mt-3">
                                                    <label for="precio_reserva" class="form-label"> Cantidad Asientos</label>
                                                    <input type="number" min="1" name="precio_reserva" value="" readonly="" style="width: 90px" />
                                                </div>

                                                <div class="col-12 col-md-6 mt-3">
                                                    <label for="fecha_reserva" class="form-label"> Fecha Reserva</label>
                                                    <input type="date" name="fecha_reserva" id="fecha_reserva" value="" />
                                                </div>

                                                <div class="col-12 col-md-6 mt-3">
                                                    <label for="fecha_rntrega" class="form-label"> Fecha Entrega</label>
                                                    <input type="date" name="fecha_entrega" value="" id="fecha_entrega" />
                                                </div>

                                        <div class="col-12 mt-4  text-center">
                                    <a class="btn btn-primary" href="ConsultarReserva.php" > Regresar </a>
                                    <input type="submit" class="btn btn-success" value="Guardar" onclick="return confirm('Los datos se an guardado!!')" name="guardar" />
                                </div>
                                               
                                                    
                                        </form>
                              
                       
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
                                    if (isset($_POST['guardar'])) {
                                        $persona = $_REQUEST['cedula'];

                                        $vehiculo = $_REQUEST['vehiculo'];
                                        $can_asientos = $_REQUEST['can_asientos'];

                                        $fecha_reserva = $_REQUEST['fecha_reserva'];
                                        $fecha_entrega = $_REQUEST['fecha_entrega'];

                                        $resultadoVue = consultarVehiculo($con, $vehiculo);
                                        //Recupera una fila de resultado como una matriz asociativa

                                        while ($filaVue = mysqli_fetch_assoc($resultadoVue)) {
                                            $dis = $filaVue['can_disponible'];
                                            $pre = $filaVue['precio'];
                                            $porce = $filaVue['impuesto'];
                                        }
                                        $res = $dis - $can_asientos;
                                        //calculo del impuesto por cada aciento
                                        $imp = (($pre * $porce) * $can_asientos);
                                        //cálculo del precio final
                                        $precio_reserva = (($can_asientos * $pre) + $imp);
                                        if (insertarReserva($con, $vehiculo, $persona, $can_asientos, $precio_reserva, $fecha_reserva, $fecha_entrega)) {
                                            if (actualizarRegistro($con, $vehiculo, $res)) {
                                                ("location:ConsultarReserva.php");
                                            }
                                        } else {
                                            echo '<script language="javascript"> alert("No se ingreso correctamente la información !!"); </script>';
                                        }
                                    }
                                    ?>