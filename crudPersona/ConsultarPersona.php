<?php
require_once '../recursos/conexion.php';
require_once '../recursos/funcionesPersona.php';

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

$var = (!empty($_GET['id'])) ? $_GET['id'] : 0;
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Consultar persona</title>   
        <!-- Bootstrap CSS -->
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- CSS personalizado --> 



        <!--font awesome con CDN-->  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
        <link href="../bootstrap/css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <style type="text/css">
            .topcorner{
                position: absolute;
                top: 1;
                right:1;
                text-shadow: 1px 1px;
                font-size: 25px;
                text-align: justify;
            }
        </style>
        <div class="topcorner"> <a href="../crudPersona/Logout.php" >Logout</a> </div>
          <div class="card-body">
        <div class="container mb-5">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
           
                <h3 class="text-center">Consultar Persona</h3> <br>
               
                            </div>
                    <div class="card-body " >  
                        <div class="container mb-5">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white"> 
                <h4 class="text-center"  >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
                            </div>

        <?php
        //Paginacion de las tablas
        $por_pagina = 3;
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina = 1;
        }

        $empieza = ($pagina - 1) * $por_pagina;

        //Seleccionar la tabla con LIMIT
        //$consulta = "SELECT * FROM perfil_persona "."inner join perfil on id_perfil_p = id_perfil "."LIMIT $empieza, $por_pagina";
        //$resultado = $con->query($consulta);
        ?>


        <section class="row justify-content-center"> 
            <section class="col-md-12">
                <div align="center">
                    <form name="GET" class="formulario">
                        <table class="table table-bordered table-responsive" class="table">
                            <thead class="thead-dark">
                            <th scope="">Cédula</th>
                            <th scope="col">Id_Perfil</th>
                            <th scope="row">Nombres</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Teféfono</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Imagen</th>

                            <th scope="col">Editar </th>
                            <!-- comment -->

                            <?php if ($_SESSION['idRol'] == 1) { ?>    
                                <th scope="col">Eliminar </th>
                            <?php } ?>
                            </tr> 
                            </thead>
                            <?php
                            $idUsuario = null;
                            if ($_SESSION['idRol'] != 1) {
                                $idUsuario = $_SESSION['idUser'];
                                $resultado = consultarPersona($con, $idUsuario);
                                $test = "usr";
                            } else {
                                $resultado = consultarUsuario($con, $idUsuario, $empieza, $por_pagina);
                                $test = "admin";
                            }
                            //$resultado = consultarPersona($con, $idUsuario);
                            //Me va a permitir recorrer el contenido de la consulta SQL
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                ?>
                                <tr>
                                    <td> <?php echo $fila['cedula'] ?></td>
                                    <td> <?php echo $fila['id_perfil_p'] ?> </td>
                                    <td> <?php echo $fila['nombres'] ?> </td>
                                    <td> <?php echo $fila['apellidos'] ?></td>
                                    <td> <?php echo $fila['direccion'] ?> </td>
                                    <td> <?php echo $fila['telefono'] ?></td>
                                    <td> <?php echo $fila['email'] ?></td>
                                    <td> <?php echo $fila['usuario'] ?></td>
                                    <td> <img src="data:image/jpg;base64,<?php echo base64_encode($fila['imagen']); ?>" width="50px" height="50px"> </td>


                                    <?php if ($_SESSION['idRol'] == 1) { ?>    
                                        <td><a class="btn btn-danger" href="EliminarPersona.php?codPer=<?php echo $fila['cedula'] ?>"
                                               onclick="return confirm('Seguro Eliminar !!')"> Eliminar</a></td>
                                        <?php } ?>
                                    <td><a class="btn btn-warning" href="EditarPersona.php?cod=<?php echo $fila['cedula'] ?>"> Editar</a></td>      

                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </form>

                    <?php
                    if ($test == "usr") {
                        $total_paginas = 1;
                        $empieza = 1;
                    } else {

                        $resultado = consultarUsuarioAdmin($con);

                        //Contar el total de registros
                        //para versiones posteriores a php 5 usar mysql_num_rows
                        $total_registro = mysqli_num_rows($resultado);

                        //Dividir el total de registros
                        $total_paginas = ceil($total_registro / $por_pagina);
                    }
                    ?>


                    <nav aria-label="Page navigation example">

                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="ConsultarPersona.php?pagina=1">Primera</a></li>
                            <?php
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                ?>
                                <li class="page-item"><a class="page-link" href="ConsultarPersona.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                            <?php } ?>
                            <li class="page-item"><a class="page-link" href="ConsultarPersona.php?pagina=<?php echo $total_paginas ?>">Ultima</a></li>

                        </ul>
                    </nav>

                    <?php if ($_SESSION['idRol'] == 1) { ?>
                        <div class="col-12 mt-2 text-center">
                            <a class="btn btn-success" href="IngresoPersona.php" class="glyphicon glyphicon-search"> Ingreso Persona </a>
                            <a class="btn btn-info" href="../reportes/ReportePersonas.php" > Generar reporte </a>
                        </div>
                    <?php } ?>
                    <div class="col-12 mt-2 text-center">
                        <div class="col-12 mt-2 text-center">
                            <a class="btn btn-primary" href="../Menu.php" > Regreso al menu </a>
                        </div>



                    </div>
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
