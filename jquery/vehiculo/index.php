
<?php
require 'recursos/conexion.php';
require 'recursos/funcionesPersona.php';

//MANEJO DE SESION 

session_start();
if (isset($_SESSION['cedula'])) {
    header("location:Menu.php");
}

if (!empty($_POST)) {
    $usuario = $_REQUEST['usuario'];
    $password = $_REQUEST['password'];
    $error = '';
    $md5_pass = md5($password);

    $resultado = traerUsuario($con, $usuario, $md5_pass);
    $cont = $resultado->num_rows;

    if ($cont > 0) {
        $row = mysqli_fetch_assoc($resultado);
        //COLOCA LA VARIABLE A LA BASE DE DATOS 
        $_SESSION['idUser'] = $row['cedula'];
        $_SESSION['user'] = $row['usuario'];
        $_SESSION['nombreU'] = $row['nombres'];
        $_SESSION['apellidoU'] = $row['apellidos'];
        $_SESSION['idRol'] = $row['id_perfil_p'];
        $_SESSION["autentificado"] = "SI";
        $_SESSION["ultimoAcceso"] = date("Y-n-j H:i:s");
        header("location:Menu.php");
    } else {
        $error = "El nombre o contraseña son incorrectos";
    }
}


?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
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

 
 
    <body class = "bg-success row  justify-content-center vh-100" >

    <section class="container-fluid bg">
            <header >
                <h2 class="text-center text-light">Bienvenid@</h2>     
            </header>
       
        <div class = "col-sm-12 bg-white txt-center">
        
            <form action="" method="POST" class="form-container">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" id="usuario" name="usuario" value="" class="form-control"  /> 
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" id="clave" name="password" value="" class="form-control" /> <br>
                <input type="submit" value="Login" name="login"  class="btn btn-primary btn-block "/>
                <br>
                <div style="font-size: 16px; color: red;"> <?php echo isset($error) ? $error : '' ?></div>
                <hr><p>No tienes accesso<br><a href="crudPersona/IngresoPersona.php" title="Cree una cuenta"/>Crear una cuenta </p>   

            </form>
        
        </div>
   
        </section>

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
