
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
require '../recursos/conexion.php';
require '../recursos/funcionesPerfil.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Ingresar perfil</title> 
        <script src="../validaciones/scriptPerfil.js" type="text/javascript"></script>
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
        <script src="../validaciones/scriptPerfil.js" type="text/javascript"></script>
       
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
                            <h3 class="text-center">Ingreso Datos Perfil</h3>
                        </div>    
                        <section class="user">
                            <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
                        </section>
                        <div class="card-body">


                            <form class="row mb-n1" action="" method="POST" onsubmit="return validar();" >            
                                <div class="col-12 col-md-6 mt-3">
                                    <label for="nombre" class="form-label">Id Perfil</label>
                                    <input type="number" class="form-control" name="id" value="" id="id_perfil"/></td>
                                </div>
                                <div class="col-12 col-md-6 mt-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" value="" placeholder="Ingrese el nombre" onkeypress="return SoloLetras(event);" maxlength="50" required/>
                                </div>

                                <div class="col-12 col-md-6 mt-3">
                                    <label for="nombre" class="form-label">Descripcion</label>
                                    <input type="text" class="form-control" name="descripcion" value="" id="descripcion" required /> 
                                </div>



                                <div class="col-12 mt-4 text-center">
                                    <a class="btn btn-primary" href="ConsultarPerfil.php" > Regreso a consulta </a>  
                                    <input class="btn btn-success" type="submit" value="Guardar" onclick="return confirm('¿Los Datos ingresados estan correctos?')" name="guardo">
                                </div>


                        </div>
                        </form>
                    </div>
                </div>
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
    $iD = $_REQUEST['id'];
    $nombrE = $_REQUEST['nombre'];
    $descripcioN = $_REQUEST['descripcion'];

    if (insertarPerfil($con, $iD, $nombrE, $descripcioN)) {
        header("location:ConsultarPerfil.php");
    } else {
        
    }
}
?>

