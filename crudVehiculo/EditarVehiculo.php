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
require_once '../recursos/funcionesVehiculo.php';

$codigo = $_GET['codVu'];

$resultado = consultarVehiculo($con, $codigo);
if ($fila = mysqli_fetch_assoc($resultado)) {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Actualizar vehiculo</title>
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
       
        <script src="../validaciones/scriptVehiculo.js" type="text/javascript"></script>
        </head>
        <body> 
          
        <div class="topcorner"> <a href="../crudPersona/Logout.php" >Logout</a> </div>
      <div class="container mb-5">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <h3 class="text-center">Editar Datos Vehiculo: <?= $fila['id_vehiculo']; ?></h3>
                            </div>
                            <div class="card-body">
                <form class="row mb-n1" method="POST" id="actalizarConfirmacion">                
                                
                          <div class="col-12 col-md-6 col-lg-4 mt-3">
                           <label for="marca" class="form-label">Marca del Vehiculo</label>
                                <select name="marca" class="form-select" required>
                                    <option value="" >-- SELECCIONE -- </option>
                                    <option value="CHEVROLET" <?php if ($fila['marca'] == 'CHEVROLET'): echo " selected = 'selected'"; endif; ?> >CHEVROLET</option>
                                    <option value="NISSAN" <?php if ($fila['marca'] == 'NISSAN'): echo " selected = 'selected'"; endif; ?> >NISSAN</option>
                                    <option value="MERCEDEZ" <?php if ($fila['marca'] == 'MERCEDEZ'): echo " selected = 'selected'"; endif; ?> >MERCEDEZ</option>
                                    <option value="RENAULT" <?php if ($fila['marca'] == 'RENAULT'): echo " selected = 'selected'";endif; ?> >RENAULT</option>
                                </select>
                             </div>
                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label class="form-label">Categoría</label>
                                        <div class="d-flex justify-content-between">
                                            <div class="form-check">
                         <input   type="radio" class="form-check-input" name="categoria" value="Automatico" <?php if ($fila['categoria'] == 'Económica'): echo " checked"; endif; ?>  />
                         <label class="form-check-label" for="categoria1">
                                                   Automatico
                                                </label>
                         </div>
                         <div class="form-check">
                         <input type="radio"  class="form-check-input" name="categoria" value="Manual" <?php if ($fila['categoria'] == 'Media'): echo " checked"; endif; ?>  />
                         <label class="form-check-label" for="categoria2">
                                                    Manual
                                                </label>
                         </div>
                                            
                           <div class="form-check">  
                               
                         <input type="radio" class="form-check-input"  name="categoria" value="SemiAutomatico" <?php if ($fila['categoria'] == 'Primera'): echo " checked"; endif; ?> />
                    <label class="form-check-label" for="categoria2">
                                                   Semi Automatico
                                                </label>
                         </div>
                                        </div>
                                        
                                </div>
        
        
                          <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <label for="can_disponible" class="form-label">Cantidad Disponible</label>
                        <input type="number" class="form-control"  min="1" name="can_disponible" required="" value="<?php echo $fila['can_disponible'] ?>" onkeypress="return SoloNumeros(event)" maxlength="50" required/>
                          </div>
                          
                             <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="horario" class="form-label">Horario</label>
                                 <select  class="form-select" name="horarios" required >
                                    <option value="" >-- SELECCIONE -- </option>
                                    <option value="06:00 AM" <?php if ($fila['horarios'] == '06:00 AM'): echo " selected = 'selected'"; endif; ?> >06:00 AM</option>
                                    <option value="09:00 AM" <?php if ($fila['horarios'] == '09:00 AM'): echo " selected = 'selected'"; endif; ?> >09:00 AM</option>
                                    <option value="12:00 PM" <?php if ($fila['horarios'] == '12:00 PM'): echo " selected = 'selected'"; endif; ?> >12:00 PM</option>
                                    <option value="03:00 PM" <?php if ($fila['horarios'] == '03:00 PM'): echo " selected = 'selected'"; endif; ?> >03:00 PM</option>
                                    <option value="06:00 PM" <?php if ($fila['horarios'] == '06:00 PM'): echo " selected = 'selected'";endif; ?> >06:00 PM</option>
                                </select>
                             </div>

                        <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="dias" class="form-label">Días</label>
                        <input type="text" class="form-control" name="dias" required="" value="<?php echo $fila['dias'] ?>" /></td>
                       </div>
                         
                  <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="precio" class="form-label">Precio</label>
                      <input type="number" class="form-control" min="1" name="precio" required="" step="any"  value="<?php echo $fila['precio'] ?>" />
                  </div>
<div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <label for="impuesto" class="form-label">Impuesto</label>
                      <input type="number" min="1" name="impuesto" style="width: 60px" value="<?php echo $fila['impuesto']?>" readonly="" />%
</div>

               
       
                            
                  <div class="col-12 mt-4 text-center">
                                        <a class="btn btn-primary" href="ConsultarVehiculo.php"> Regresar </a>
                                        <input class="btn btn-success" type="submit" value="Actualizar" name="actualiza" onclick="return confirm('¿Esta seguro que desea actualizar el registro?')"/>
                                    </div>
           
                            </div><!-- comment -->
                        </div>
                    </div>
                </div>
      </div>
        
                            
            <?php
        }
        ?>
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
if (isset($_POST['actualiza'])) { // Name del botón
    $id = $_POST['id'];
    $marca = $_POST['marca'];
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


    if (actualizarVehiculo($con, $id, $marca, $categoria, $can_disponible, $horarios, $dias, $precio, $impuesto)) {
        //header("ConsultarVehiculo.php");
        echo '<script languaje = "javascript"> '
        . 'window.location= "ConsultarVehiculo.php" </script>'
        . 'alert("Vehiculo actualizado!!!");';
        
    } else {
        echo '<script languaje = "javascript"> '
        . 'alert("No se pudo editar !!!");'
        . 'window.location= "EditarVehiculo.php" </script>';
    }
}
?>