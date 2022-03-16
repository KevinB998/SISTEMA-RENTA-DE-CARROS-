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
require '../recursos/conexion.php';
require '../recursos/funcionesVehiculo.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Ingresar vehiculo</title>   
        <script src="../validaciones/scriptVehiculo.js" type="text/javascript"></script>
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
        <script src="../validar.js" type="text/javascript"></script>
        
        <style>
            body{
                background-color: #f3f4f7 !important;
            }
        </style>
    </head>
    <body>  
      
     
        <div class="topcorner"> <a href="../crudPersona/Logout.php" >Logout</a> </div>
          <div class="container mb-5">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h3 class="text-center">Ingreso Datos Vehiculo</h3>
                        </div>

        <div class="card-body">  
                <form  action="" method="POST" onsubmit="return validar();"  >            
                    
                                <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="marca" class="form-label">Marcas Disponibles</label>
                                <select name="marca" id="marca" class="form-select" required>>
                                    <option value="">-- Seleccione la Marca de Carro -- </option>
                                    <option value="Chevrolet">CHEVROLET</option>
                                    <option value="Nissan">NISSAN</option>
                                    <option value="Mercedez">MERCEDEZ BENZ</option>
                                    <option value="Renault">RENAULT</option>
                                    <option value="Kia">KIA</option>
                                    <option value="Toyota">TOYOTA</option>
                                </select> 
                                </div>
                        </tr>
                          <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label class="form-label">Categoría</label>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="categoria" id="categoria1" value="Economica">
                                            <label class="form-check-label" for="categoria1">
                                                Automatico
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="categoria" id="categoria2" value="Media" checked>
                                            <label class="form-check-label" for="categoria2">
                                                Semiautomatico
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="categoria" id="categoria3" value="Primera">
                                            <label class="form-check-label" for="categoria3">
                                                Manual
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="cant" class="form-label">Cantidad de Asientos de 2 a 8</label>
                         <input type="number" class="form-control" min="1" name="can_disponible"  id="can_disponible" maxlength="8" value="" placeholder="Cantidad a Reservar" onkeypress="return SoloNumeros(event)" required/>
                            </div>
                            
                           <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="horario" class="form-label">Horario</label>
                                <select name="horarios" id="horarios" class="form-select">
                                    <option value="">-- seleccione --</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="03:00 PM">03:00 PM</option>
                                    <option value="06:00 PM">06:00 PM</option>
                                </select>
                           </div>
                        </tr>
                         <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="dias" class="form-label">Días</label>
                        <input type="text" class="form-control" name="dias" value="" id="dias" maxlength="25" placeholder="Numero de dias" onkeypress="return SoloNumeros(event)" required/>
                         </div>
                           <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="precio" class="form-label">Precio</label>
                          <input type="number" class="form-control" min= "1" name="precio" step="any" value="" id="precio" value="" onkeypress="return validarDecimales(event,this);" />
                           </div>
                           
                          <div class="col-12 col-md-6 col-lg-4 mt-3">
                                    <label for="impuesto" class="form-label">Impuesto</label>
                          <input type="number" class="form-control"  name="impuesto" value="" readonly="" style="width: 30px"/>%</td>
                          </div>
                    <div class="col-12 mt-4 text-center">
                                    <a class="btn btn-primary" href="consultarVehiculo.php" > Regreso a consulta </a>  
                                    <input class="btn btn-success" type="submit" value="Guardar"  onclick="return confirm('¿Los Datos ifueron guardados')" name="guardo">
                                </div> 
                   
               
                </form>
       
    </body>
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
    $idvehiculo = null;
    $marca = $_REQUEST['marca'];
    $categoria = $_REQUEST['categoria'];
    $can_disponible = $_REQUEST['can_disponible'];
    $horarios = $_REQUEST['horarios'];
    $dias = $_REQUEST['dias'];
    $precio = $_REQUEST['precio'];

    if ($categoria == "Económica") {
        $impuesto = 0.05;
    } else if ($categoria == "Media") {
        $impuesto = 0.10;
    } else if ($categoria == "Primera") {
        $impuesto = 0.15;
    }

    if (insertarVehiculo($con, $idvehiculo, $marca, $categoria, $can_disponible, $horarios, $dias, $precio, $impuesto)) {
        
    } else {
        
    }
}
?>
