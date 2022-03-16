
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
require '../recursos/funcionesVuelo.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Ingresar vuelo</title>   
        <script src="../validaciones/scriptVuelo.js" type="text/javascript"></script>
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
            <h3>Ingresar Vuelo</h3>     
            <section class="user">
                <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
            </section>

        </section>
        <div style="height:50px"></div>

        <section class="row justify-content-center"> 
            <section class="col-12 col-sm-6 col-sm-3">    
                <form  action="" method="POST" onsubmit="return validar();"  >            
                    <table  border="2" align="center" class="table table-sm table-dark"> 

                        <tr>
                            <td>Aerolinea</td>
                            <td>
                                <select name="aerolinea" id="aerolinea">
                                    <option value="">-- seleccione -- </option>
                                    <option value="TAME">TAME</option>
                                    <option value="LAN">LAN</option>
                                    <option value="LATAM">LATAM</option>
                                    <option value="Avianca">Avianca</option>
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td>Categoria</td>
                            <td>
                                <input type="radio" name="categoria" value="Económica" />Económica
                                <input type="radio" name="categoria" value="Media" checked />Media
                                <input type="radio" name="categoria" value="Primera" />Primera
                            </td>
                        </tr>
                        <tr>
                            <td>Cantidad Disponible</td>
                            <td><input type="number" min="1" name="can_disponible" value="" id="can_disponible" /></td>
                        </tr>
                        <tr>
                            <td>Horarios</td>
                            <td>
                                <select name="horarios" id="horarios">
                                    <option value="">-- seleccione --</option>
                                    <option value="06:00 AM">06:00 AM</option>
                                    <option value="09:00 AM">09:00 AM</option>
                                    <option value="12:00 PM">12:00 PM</option>
                                    <option value="03:00 PM">03:00 PM</option>
                                    <option value="06:00 PM">06:00 PM</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Dias</td>
                            <td><input type="text" name="dias" value="" id="dias" /></td>
                        </tr>
                        <tr>
                            <td>Precio</td>
                            <td>$: <input type="number" min= "1" name="precio" step="any" value="" id="precio" /></td>
                        </tr>
                        <tr>
                            <td>Impuesto</td>
                            <td> <input type="number" name="impuesto" value="" readonly="" style="width: 30px"/>%</td>
                        </tr>
                    </table>           
                    <div align="center">
                        <br><input class="btn btn-success" type="submit" value="Guardar" name="guardo" >
                        <br><br><a class="btn btn-info" href="ConsultarVuelo.php" > Regreso a consulta </a> 
                        <p class="warnings" id="warnings" style="color: red;"></p>
                    </div>
                </form>
            </section>
        </section>
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
    $idvuelo = null;
    $aerolinea = $_REQUEST['aerolinea'];
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

    if (insertarVuelo($con, $idvuelo, $aerolinea, $categoria, $can_disponible, $horarios, $dias, $precio, $impuesto)) {
        
    } else {
        
    }
}
?>

