<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("location:index.php");
}else{
    //sino, calculamos el tiempo transcurrido
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
    //comparamos el tiempo transcurrido
     if($tiempo_transcurrido >= 300) {
     //si pasaron 5 segunfos o más
      session_destroy(); // destruyo la sesión
      header("Location:CerrarSesion.php"); //envío al usuario a la pag. de autenticación
      //sino, actualizo la fecha de la sesión
    }else {
    $_SESSION["ultimoAcceso"] = $ahora;
   }
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Menu del sistema</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- CSS personalizado --> 
        <link rel="stylesheet" href="main.css">  

        <!--datables CSS básico-->
        <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css"/>
        <!--datables estilo bootstrap 4 CSS-->  
        <link rel="stylesheet"  type="text/css" href="datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">

        <!--font awesome con CDN-->  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
        <link href="bootstrap/css/global.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <style type="text/css">
            .topcorner{
                position: absolute; top:0; right:0;
                text-shadow: 1px 1px;
                font-size: 25px;

            }
        </style>

        <div class="topcorner"> <a href="crudPersona/Logout.php" >Logout</a> </div>
        
        <section class="header">
            <h3>Menu Principal</h3>     
            <section class="user">
                <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
            </section>

        </section>


        <div style="height:50px"></div>
        
        <div class="container" style=" max-width: 400px">
            <div class="col-lg-12">
                <table border="1" align = "center" class="table table-dark">
                    <?php if ($_SESSION['idRol'] == 1) { ?>
                        <tr>
                            <td>  <a href="crudPerfil/ConsultarPerfil.php"/> Gestión Perfiles </td>
                        </tr>
                        <tr>
                            <td> <a href="crudPersona/ConsultarPersona.php" /> Gestión Persona </td>
                        </tr>
                        <tr>
                            <td> <a href="crudVuelo/ConsultarVehiculoo.php" /> Gestión Vehiculo </td>
                        </tr>
                        <tr>
                            <td> <a href="crudReserva/ConsultarReserva.php" />Gestión Reserva </td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td> <a href="crudPersona/ConsultarPersona.php" /> Gestión Persona </td>
                        </tr>
                        <tr>
                            <td> <a href="crudVuelo/ConsultarVehiculo.php" /> Gestión Vehiculo </td>
                        </tr>
                        <tr>
                            <td> <a href="crudReserva/ConsultarReserva.php" />Gestión Reserva </td>
                        </tr>

                    <?php } ?>  
                </table>
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
    <script src="datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
    <script src="datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

    <!-- código JS propìo-->    
    <script type="text/javascript" src="main.js"></script> 
</html>
