<?php
require_once '../recursos/conexion.php';
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
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Consultar Vehiculo</title>     
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Consultar perfil</title>  
        <!-- Bootstrap CSS -->
        <!-- Bootstrap CSS -->
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- CSS personalizado --> 



        <!--font awesome con CDN-->  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
        <link href="../bootstrap/css/estilos.css" rel="stylesheet" type="text/css"/>
   
        <script src="../validaciones/scriptVehiculo.js" type="text/javascript"></script>
    </head>
    <body <img src="../bootstrap/images/3.jpg" alt=""/>
   
            
        </style>

        <div class="form-control"> <a href="../crudPersona/Logout.php" ></a> </div>
        <div class="card-body">
        <div class="container mb-5">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
           
                <h3 class="text-center">Consultar Vehiculo</h3> <br>
                
                            </div>
                    <div class="card-body " >  
                        <div class="container mb-5">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white"> 
                    <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
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
                $consulta = "SELECT * FROM vehiculo LIMIT $empieza, $por_pagina";
                $resultado = $con->query($consulta);
                ?>
                    <form name="" class="formulario">
                        <div class="col-20">
                            <table class="table table-bordered table-responsive" class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Id Vehiculo</th>
                                        <th scope="col">Vehiculo </th>
                                        <th scope="col">Categoria</th>
                                        <th scope="col">Cantidad Disponible </th>
                                        <th scope="col">Horarios</th>
                                        <th scope="col">Dias</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">mpuesto</th>
                                        <?php if ($_SESSION['idRol'] == 1) { ?>
                                            <th scope="col">Eliminar</th>
                                            <th scope="col">Editar</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <?php
                                //require_once '../recursos/conexion.php';
                                //require_once '../recursos/funcionesvehiculo.php';
                                $codVue = null;
                                //$resultado = consultarVehiculo($con, $codVue);
                                while ($fila = mysqli_fetch_assoc($resultado)) {
                                    ?>
                                    <tr>
                                        <td> <?php echo $fila['id_vehiculo'] ?></td>
                                        <td> <?php echo $fila['marca'] ?> </td>
                                        <td> <?php echo $fila['categoria'] ?> </td>
                                        <td> <?php echo $fila['can_disponible'] ?> </td>
                                        <td> <?php echo $fila['horarios'] ?> </td>
                                        <td> <?php echo $fila['dias'] ?> </td>
                                        <td> <?php echo $fila['precio'] ?> </td>
                                        <td> <?php echo $fila['impuesto'] ?>  </td>
                                        <?php if ($_SESSION['idRol'] == 1) { ?>
                                            <td><a class="btn btn-danger" href="EliminarVehiculo.php?codVue=<?php echo $fila['id_vehiculo'] ?>"
                                                   onclick="return confirm('Seguro Eliminar !!')"> Eliminar</a></td>
                                            <td><a class="btn btn-warning" href="EditarVehiculo.php?codVu=<?php echo $fila['id_vehiculo'] ?>"> Editar</a></td>           
                                        <?php } ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                    </form>

                    <?php
                    //Seleccionar todo la tabla
                    $consulta = "SELECT * FROM vehiculo";
                    $resultado = $con->query($consulta);

                    //Contar el total de registros
                    //para versiones posteriores a php 5 usar mysql_num_rows
                    $total_registro = mysqli_num_rows($resultado);

                    //Dividir el total de registros
                    $total_paginas = ceil($total_registro / $por_pagina);
                    ?>

                    <!--Paginacion-->
                    <nav aria-label="Page navigation example">

                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="ConsultarVehiculo.php?pagina=1">Primera</a></li>
                            <?php
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                ?>
                                <li class="page-item"><a class="page-link" href="ConsultarVehiculo.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                            <?php } ?>
                            <li class="page-item"><a class="page-link" href="ConsultarVehiculo.php?pagina=<?php echo $total_paginas ?>">Ultima</a></li>

                        </ul>
                    </nav>

                    <?php if ($_SESSION['idRol'] == 1) { ?>
                        <div class="col-12 mt-2 text-center">
                            <a class="btn btn-success" href="IngresarVehiculo.php" class="glyphicon glyphicon-search"> Ingreso Vehiculo </a>
                            <a class="btn btn-info" href="../reportes/ReporteVehiculo.php" > Generar reporte </a>
                        </div>
                    <?php } ?>
                    <div class="col-12 mt-2 text-center">           

                        <a class="btn btn-info" href="../Menu.php" >Regreso al menu </a>     
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