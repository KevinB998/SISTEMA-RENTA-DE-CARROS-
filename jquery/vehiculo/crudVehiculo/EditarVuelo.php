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
require_once '../recursos/funcionesVuelo.php';

$codigo = $_GET['codVu'];

$resultado = consultarVuelo($con, $codigo);
if ($fila = mysqli_fetch_assoc($resultado)) {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Actualizar vuelo</title>
            <link href="../estilos/css/bootstrap.css" rel="stylesheet">  
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
            <h3>Consulta Persona</h3>     
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
                            <td>Id</td>
                            <td><input type="text" name="id" value="<?php echo $fila['id_vuelo'] ?>" readonly /> </td>
                        </tr>
                        <tr>
                            <td>Aerolinea</td>
                            <td>
                                <select name="aerolinea" required >
                                    <option value="" >-- seleccione -- </option>
                                    <option value="TAME" <?php if ($fila['aerolinea'] == 'TAME'): echo " selected = 'selected'"; endif; ?> >TAME</option>
                                    <option value="LAN" <?php if ($fila['aerolinea'] == 'LAN'): echo " selected = 'selected'"; endif; ?> >LAN</option>
                                    <option value="LATAM" <?php if ($fila['aerolinea'] == 'LATAM'): echo " selected = 'selected'"; endif; ?> >LATAM</option>
                                    <option value="Avianca" <?php if ($fila['aerolinea'] == 'Avianca'): echo " selected = 'selected'";endif; ?> >Avianca</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Categoria</td>
                            <td>
                         <input type="radio" name="categoria" value="Económica" <?php if ($fila['categoria'] == 'Económica'): echo " checked"; endif; ?>  />Económica
                         <input type="radio" name="categoria" value="Media" <?php if ($fila['categoria'] == 'Media'): echo " checked"; endif; ?>  />Media
                         <input type="radio" name="categoria" value="Primera" <?php if ($fila['categoria'] == 'Primera'): echo " checked"; endif; ?> />Primera
                    </td>       
                        </tr>

                        <tr>
                            <td>Cantidad Disponible</td>
                            <td><input type="number" min="1" name="can_disponible" required="" value="<?php echo $fila['can_disponible'] ?>" /></td>
                        </tr>

                        <tr>
                            <td>Horarios</td>
                            <td>
                                 <select name="horarios" required >
                                    <option value="" >-- seleccione -- </option>
                                    <option value="06:00 AM" <?php if ($fila['horarios'] == '06:00 AM'): echo " selected = 'selected'"; endif; ?> >06:00 AM</option>
                                    <option value="09:00 AM" <?php if ($fila['horarios'] == '09:00 AM'): echo " selected = 'selected'"; endif; ?> >09:00 AM</option>
                                    <option value="12:00 PM" <?php if ($fila['horarios'] == '12:00 PM'): echo " selected = 'selected'"; endif; ?> >12:00 PM</option>
                                    <option value="03:00 PM" <?php if ($fila['horarios'] == '03:00 PM'): echo " selected = 'selected'"; endif; ?> >03:00 PM</option>
                                    <option value="06:00 PM" <?php if ($fila['horarios'] == '06:00 PM'): echo " selected = 'selected'";endif; ?> >06:00 PM</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Dias</td>
                            <td><input type="text" name="dias" required="" value="<?php echo $fila['dias'] ?>" /></td>
                        </tr>

                        <tr>
                            <td>Precio</td>
                            <td>$: <input type="number" min="1" name="precio" required="" step="any"  value="<?php echo $fila['precio'] ?>" /></td>
                        </tr>

                        <tr>
                            <td>Impuesto</td>
                            <td><input type="number" min="1" name="impuesto" style="width: 60px" value="<?php echo $fila['impuesto']?>" readonly="" />%</td>
                        </tr>

                    </table>
            </div>
            <div align="center">
                <br><input class="btn btn-success" type="submit" value="Actualizar" name="actualiza" onclick="return confirm('Desea actualizar !!')"/>

                <br><br><a class="btn btn-info" href="ConsultarVuelo.php" > Regresar </a>
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
    $id = $_POST['id'];
    $aerolinea = $_POST['aerolinea'];
    $categoria = $_POST['categoria'];
    $can_disponible = $_POST['can_disponible'];
    $horarios = $_POST['horarios'];
    $dias = $_POST['dias'];
    $precio = $_POST['precio'];
    $impuesto = $_POST['impuesto'];
    
    if ($categoria == "Económica") {
        $impuesto = 0.05;
    } else if ($categoria == "Media") {
        $impuesto = 0.10;
    } else if ($categoria == "Primera") {
        $impuesto = 0.15;
    } 


    if (actualizarVuelo($con, $id, $aerolinea, $categoria, $can_disponible, $horarios, $dias, $precio, $impuesto)) {
        //header("ConsultarVuelo.php");
        echo '<script languaje = "javascript"> '
        . 'window.location= "ConsultarVuelo.php" </script>'
        . 'alert("Vuelo actualizado!!!");';
        
    } else {
        echo '<script languaje = "javascript"> '
        . 'alert("No se pudo editar !!!");'
        . 'window.location= "EditarVuelo.php" </script>';
    }
}
?>