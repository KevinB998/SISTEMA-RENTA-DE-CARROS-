<?php
session_start();
if (!isset($_SESSION['idUser'])) {
    header("location:index.php");
} else {
    //sino, calculamos el tiempo transcurrido
    $fechaGuardada = $_SESSION["ultimoAcceso"];
    $ahora = date("Y-n-j H:i:s");
    $tiempo_transcurrido = (strtotime($ahora) - strtotime($fechaGuardada));
    //comparamos el tiempo transcurrido
    if ($tiempo_transcurrido >= 300) {
        //si pasaron 5 segunfos o más
        session_destroy(); // destruyo la sesión
        header("Location:CerrarSesion.php"); //envío al usuario a la pag. de autenticación
        //sino, actualizo la fecha de la sesión
    } else {
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
    

  <div class="card-body">
        <div class="container mb-5">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
           
                <h3 class="text-center">RENTA VEHICULOS BDK</h3> <br>
                            </div>
        <div class="container mb-5">
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                <h4  class="text-center">Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
                        </div>




        <nav class="navbar navbar-expand-lg navbar-dark <?php
        if ($archivo_actual != 'Menu.php') {
            echo 'bg-dark';
        } else {
            echo ' fixed-top';
        }
        ?> scrolling-navbar">

            <?php if ($_SESSION['idRol'] == 1) { ?>
                <div class="container">
                    <a class="navbar-brand" href="#"><img src="bootstrap/images/auto.png"  width="170" height="80"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                

                    <div class="collapse navbar-collapse main-menu-option" id="navbarNav">
                        <div class="mx-auto"></div>
                        <ul class="navbar-nav">
                           

                            <li class="nav-item">
                                <a class="nav-link text-white " href="crudPerfil/ConsultarPerfil.php"><h5> Gestión Perfiles</h5></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white " href="crudPersona/ConsultarPersona.php" ><h5> Gestión Persona </h5></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white " href="crudVehiculo/ConsultarVehiculo.php"><h5> Gestión Vehiculo</h5></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white " href="crudReserva/ConsultarReserva.php" ><h5>Gestión Reserva</h5></a>
                            </li>

                            <div class="topcorner"> <a href="crudPersona/Logout.php" >Logout</a> </div>
                        <?php } else { ?>
                         
                              <div class="container">
                    <a class="navbar-brand" href="#"><img src="bootstrap/images/auto.png"  width="170" height="80"></a>
                            
                            <li class="nav-item">
                              <a class="nav-link text-white " href="crudPersona/ConsultarPersona.php" /> Gestión Persona </td>
                            </li>
                       <li class="nav-item">
                          <a class="nav-link text-white " href="crudVehiculo/ConsultarVehiculo.php" /> Gestión Vehiculo </td>
                            </li>
                       <li class="nav-item">
                            <a class="nav-link text-white " href="crudReserva/ConsultarReserva.php" />Gestión Reserva </td>
  </li>
  
                            <div class="topcorner"> <a href="crudPersona/Logout.php" >Logout</a> </div>
                              </div>
                        <?php } ?>  
                     
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
