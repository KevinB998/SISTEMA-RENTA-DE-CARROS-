
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
$codP = null;
$idV = null;
$resultadoPer = consultarPersona($con, $codP);
$resultadoVue = consultarVuelo($con, $idV);
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
            <h3>Ingreso Reservas</h3>     
            <section class="user">
                <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
            </section>

        </section>
        <div style="height:50px"></div>

        <section class="row justify-content-center"> 
            <section class="col-12 col-sm-6 col-sm-3">
                <div align="center">

                    <form action="" method="POST" onsubmit="return validar();">           
                        <table  border="2" class="table table-sm table-dark" style="max-width: 300px" > 
                            <?php if ($_SESSION['idRol'] == 1) { ?>
                                <tr>
                                    <td>Persona</td>
                                    <td><select name="cedula" id="persona"  size="1">
                                            <option value="" selected="selected">-- Escoja una opción </option> 
                                            <?php while ($filaPer = mysqli_fetch_assoc($resultadoPer)) { ?>
                                                <option value="<?= $filaPer['cedula'] ?>"> <?= $filaPer['nombres'] . " " . $filaPer['apellidos'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td>Cedula</td>
                                    <td> <input type="text" readonly name="cedula" id="persona" value="<?php echo $_SESSION['idUser'] ?>" /> </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>Vuelo</td>
                                <td><select name="vuelo" id="vuelo" >
                                        <option value="" selected="selected"> -- Escoja una opción </option>                           
                                        <?php while ($filaVue = mysqli_fetch_assoc($resultadoVue)) { ?>
                                            <option value="<?= $filaVue['id_vuelo'] ?>"> <?= "Aerolinea: " . $filaVue['aerolinea'] . " - " . $filaVue['categoria'] ?>   </option>

                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Cantidad Asientos</td>
                                <td> <input type="number" min="1" name="can_asientos" id="can_asientos" value="" /></td>
                            </tr>
                            <tr>
                                <td>Precio Reserva</td>
                                <td>$: <input type="number" min="1" name="precio_reserva" value="" readonly="" style="width: 90px" /></td>
                            </tr>
                            <tr>
                                <td>Fecha Reserva</td>
                                <td><input type="date" name="fecha_reserva" id="fecha_reserva" value="" /></td>
                            </tr>
                            <tr>
                                <td>Fecha Vuelo</td>
                                <td><input type="date" name="fecha_vuelo" value="" id="fecha_vuelo" /></td>
                            </tr>
                        </table>

                        <br><input class="btn btn-success" type="submit" value="Guardar" name="guardar" />
                        <p class="warnings" id="warnings" style="color: red;"></p>
                        <br><a class="btn btn-info" href='ConsultarReserva.php'> Regresar </a>
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
if (isset($_POST['guardar'])) {
    $persona = $_REQUEST['cedula'];

    $vuelo = $_REQUEST['vuelo'];
    $can_asientos = $_REQUEST['can_asientos'];

    $fecha_reserva = $_REQUEST['fecha_reserva'];
    $fecha_vuelo = $_REQUEST['fecha_vuelo'];

    $resultadoVue = consultarVuelo($con, $vuelo);
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
    if (insertarReserva($con, $vuelo, $persona, $can_asientos, $precio_reserva, $fecha_reserva, $fecha_vuelo)) {
        if (actualizarRegistro($con, $vuelo, $res)) {
            ("location:ConsultarReserva.php");
        }
    } else {
        echo '<script language="javascript"> alert("No se ingreso correctamente la información !!"); </script>';
    }
}
?>