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
require_once '../recursos/funcionesVehiculo.php';




?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Consultar Reserva</title>
        <!-- Bootstrap CSS -->
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- CSS personalizado --> 



        <!--font awesome con CDN-->  
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
        <link href="../bootstrap/css/estilos.css" rel="stylesheet" type="text/css"/>

        <script src="../validaciones/scriptReserva.js" type="text/javascript"></script>
    </head>

    <body>
      
        <div class="topcorner"> <a href="../crudPersona/Logout.php" >Logout</a> </div>
        <div class="card-body">
        <div class="container mb-5">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
           
                <h3 class="text-center">Consultar Reserva</h3> <br>
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
  
        <div class="container mb-10">
                <div class="row mt-10">
                    <div class="col-14">
       
                   
                    <!-- <th>Id Reserva</th> -->
                    <table class="table table-bordered table-responsive" class="table">
                            <thead class="thead-dark">
                    <th scope="col">Id Vehiculo</th>
                    <th scope="col">Nombre de la Marca </th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Horarios</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Impuesto</th>
                    <th scope="col">Precio Reserva</th>
                    <th scope="col">Cédula</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
     
               
                    <!--

                   <th>Cantidad de Asientos</th>

                   <th>Fecha Reserva</th>
                   <th>Fecha Vuelo</th>
                    -->
                    <?php if ($_SESSION['idRol'] == 1) { ?>
                        <th scope="col">Eliminar</th>
                        <th scope="col">Editar</th>
                    </thead>
                    </div>
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
                        <td> <?php echo $row['id_vehiculo_r'] ?> </td>

                        <?php
                        if ($row3 = mysqli_fetch_assoc(consultarVehiculo($con, $row['id_vehiculo_r']))) {
                            ?>
                            <td><?php echo $row3['marca'] ?>    </td>
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
                        <td style="display: none;" > <?php echo $row['fecha_entrega'] ?> </td>

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
                 <div class="col-12 mt-2 text-left">
                    <a class="btn btn-info" href="../reportes/ReporteReservas.php" > Generar todas las reservas </a> 
                 </div>
                <?php } ?>

                <div class="col-12 mt-2 text-center">
                    <a class="btn btn-success" href="IngresarReserva.php" class="glyphicon glyphicon-search"> Ingreso Reserva </a>
                </div><!-- comment -->
                 <div class="col-12 mt-2 text-center">
                <a class="btn btn-secondary" href="../reportes/ReporteUsr.php?ced=<?php 
                //$cedula = $_SESSION['idUser'];
                //$row = mysqli_fetch_assoc($resultado);
                $cedula = $_SESSION['idUser'];
                 echo $cedula ?>" > Generar reporte solo usuario </a> 
                 </div>
               <div class="col-12 mt-2 text-center">
                 <a class="btn btn-warning" href="../Menu.php"> Menu principal </a>
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
