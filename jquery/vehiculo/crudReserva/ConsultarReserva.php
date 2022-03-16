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
require_once '../recursos/funcionesReserva.php';
require_once '../recursos/funcionesPersona.php';
require_once '../recursos/funcionesVuelo.php';




?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Consultar Reserva</title>
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
            <h3>Consulta Reservas</h3>
            <section class="user">
                <h4 >Bienvenid@ <?= $_SESSION['nombreU'] . " " . $_SESSION['apellidoU'] ?></h4><br>
            </section>

        </section>
        <div style="height:50px"></div>

        <?php
            //Paginacion de las tablas
            $por_pagina = 3;
            if(isset($_GET['pagina'])){
                $pagina = $_GET['pagina'];
            }else{
                $pagina = 1;
            }

            $empieza = ($pagina-1) * $por_pagina;

            //Seleccionar la tabla con LIMIT
            //$consulta = "SELECT * FROM reserva LIMIT $empieza, $por_pagina";
            //$resultado = $con->query($consulta);
            
            ?>

        <section class="row justify-content-center">
            <section class="col-dm-12">
            <div align="center">
            <table border="1" class="table table-sm table-dark" >
                <tr>
                    <!-- <th>Id Reserva</th> -->
                    <th>Id Vuelo</th>


                    <th>Nombre Aerolinea</th>
                    <th>Categoria</th>
                    <th>Horarios</th>
                    <th>Precio</th>
                    <th>Impuesto</th>
                    <th>Precio Reserva</th>

                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>

                    <!--

                   <th>Cantidad de Asientos</th>

                   <th>Fecha Reserva</th>
                   <th>Fecha Vuelo</th>
                    -->
                    <?php if ($_SESSION['idRol'] == 1) { ?>
                        <th>Eliminar</th>
                        <th>Editar</th>
                    <?php } ?>
                </tr>
                <?php
                $cedula = NULL;
                if($_SESSION['idRol'] != 1){
                    $cedula = $_SESSION['idUser'];
                    $resultado = consultarReserva($con, $cedula, $empieza, $por_pagina);
                    $test = "usr";
                }else{
                    $resultado = consultarReservaAdmin($con, $cedula,$empieza, $por_pagina);
                    $test = "admin";
                }
                //$resultado = consultarReserva($con, $cedula);
                while ($row = mysqli_fetch_assoc($resultado)) {
                    ?>
                    <tr>
                        <td style="display: none;"> <?php echo $row['id_reserva'] ?> </td>
                        <td> <?php echo $row['id_vuelo_r'] ?> </td>

                        <?php
                        if ($row3 = mysqli_fetch_assoc(consultarVuelo($con, $row['id_vuelo_r']))) {
                            ?>
                            <td><?php echo $row3['aerolinea'] ?>    </td>
                            <td><?php echo $row3['categoria'] ?>    </td>
                            <td><?php echo $row3['horarios'] ?>    </td>
                            <td>$<?php echo $row3['precio'] ?>    </td>
                            <td><?php echo $row3['impuesto'] ?>    </td>
                            <?php
                        }
                        ?>
                        <td> $ <?php echo $row['precio_reserva'] ?> </td>
                        <td> <?php echo $row['cedula_r'] ?> </td>
                        <?php
                        if ($row2 = mysqli_fetch_assoc(consultarPersona($con, $row['cedula_r']))) {
                            ?>
                            <td><?php echo $row2['nombres'] ?>    </td>
                            <td><?php echo $row2['apellidos'] ?>    </td>

                            <?php
                        }
                        ?>
                        <td style="display: none;"> <?php echo $row['can_asientos'] ?> </td>

                        <td style="display: none;" > <?php echo $row['fecha_reserva'] ?> </td>
                        <td style="display: none;" > <?php echo $row['fecha_vuelo'] ?> </td>

                        <?php if ($_SESSION['idRol'] == 1) { ?>
                        <td> <a class="btn btn-danger" href = "EliminarReserva.php?idPerR=<?php echo $row['id_reserva'] ?>" onclick="return confirm('Seguro Eliminar !!')" >Eliminar </a> </td>
                        <td> <a class="btn btn-warning" href = "EditarReserva.php?idPerRe=<?php echo $row['cedula_r'] ?>">Editar </a> </td>
                    
                        
                        <?php } ?>
                    </tr>
                    <?php
                }
                ?>
            </table>

                <?php

                    if($test=="usr"){
                        
                        $resultado = consultarReservaPag($con, $cedula);

                        //Contar el total de registros
                        //para versiones posteriores a php 5 usar mysql_num_rows
                        $total_registro = mysqli_num_rows($resultado);
                        
                        //Dividir el total de registros
                        $total_paginas = ceil($total_registro/$por_pagina);
                    }else{
                        //Seleccionar todo la tabla
                        $resultado = consultarReservaPagAdmin($con, $cedula);

                        //Contar el total de registros
                        //para versiones posteriores a php 5 usar mysql_num_rows
                        $total_registro = mysqli_num_rows($resultado);
                        
                        //Dividir el total de registros
                        $total_paginas = ceil($total_registro/$por_pagina);
                    }
                    
                ?>
                
                <!--Paginacion-->
                <nav aria-label="Page navigation example">

                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="ConsultarReserva.php?pagina=1">Primera</a></li>
                        <?php
                            for($i=1;$i<=$total_paginas;$i++){
                        ?>
                                <li class="page-item"><a class="page-link" href="ConsultarReserva.php?pagina=<?php echo $i ?>"><?php echo $i ?></a></li>
                            <?php } ?>
                        <li class="page-item"><a class="page-link" href="ConsultarReserva.php?pagina=<?php echo $total_paginas ?>">Ultima</a></li>
        
                    </ul>
                </nav>

                <?php if ($_SESSION['idRol'] == 1) { ?>
                    <a class="btn btn-info" href="../reportes/ReporteReservas.php" > Generar todas las reservas </a> <br>
                <?php } ?>

                <br>
                <a class="btn btn-success" href="IngresarReserva.php" > Ingreso reserva </a> <br> <br>
                
                <a class="btn btn-info" href="../reportes/ReporteUsr.php?ced=<?php 
                //$cedula = $_SESSION['idUser'];
                //$row = mysqli_fetch_assoc($resultado);
                $cedula = $_SESSION['idUser'];
                 echo $cedula ?>" > Generar reporte solo usuario </a> <br> <br>
                <a class="btn btn-info" href="../Menu.php"> Menu principal </a>

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
