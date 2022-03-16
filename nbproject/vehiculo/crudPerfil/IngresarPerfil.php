
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
            <h3>Ingreso Datos Perfil</h3>     
            <section class="user">
                <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
            </section>

        </section>
        <div style="height:50px"></div>

        <div class="container" style=" max-width: 400px">
            <div class="col-lg-12">    


                <form  action="" method="POST" onsubmit="return validar();" >            
                    <table  border="2" align="center" class="table table-sm table-dark"> 
                        <tr style="">
                            <td>Id Perfil</td>
                            <td><input type="number" name="id" value="" id="id_perfil"/></td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td><input type="text" name="nombre" value="" id="nombre" /></td>
                        </tr>
                        <tr>
                            <td>Descripcion</td>
                            <td><input type="text" name="descripcion" value="" id="descripcion" /></td>
                        </tr>

                    </table>           
                    <div align="center">
                        <br><input class="btn btn-success" type="submit" value="Guardar" name="guardo" >
                        <br><br><a class="btn btn-info" href="ConsultarPerfil.php" > Regreso a consulta </a>
                        <p class="warnings" id="warnings" style="color: red;"></p>
                    </div>
                </form>
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

