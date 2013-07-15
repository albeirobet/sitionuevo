<?php
/*
  session_start();
  if ($_SESSION["Administrador"] == "Si" || $_SESSION["Usuario"] == "Si") {
  $nombreUsuario = $_SESSION["Nombre_Usuario"];
  include '../funciones/evitarCache.php';

 */
?> 
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Partituras</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="../css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="../css/bootstrap-responsive.css" rel="stylesheet">
<!--        <link href="../css/docs.css" rel="stylesheet">-->
        <!--Fin Bootstrap-->
        <link href="../css/estilosPersonalizados.css" rel="stylesheet">

        <link rel="apple-touch-icon" href="../img/apple-touch-icon-iphone.png" /> 
        <link rel="apple-touch-icon" sizes="72x72" href="../img/apple-touch-icon-ipad.png" /> 
        <link rel="apple-touch-icon" sizes="114x114" href="../img/apple-touch-icon-iphone4.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="../img/apple-touch-icon-ipad3.png" />
        <link rel="shortcut icon" href="../img/clave.png">




    </head>
    <body>

        <!--Inicio Navbar Estatico-->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="#">
                        <img src="../img/clave.png" class="img-rounded" style="width: 25px;">
                        Partituras Musicales Gratis

                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="activo_inicio">
                                <a href="../index.php">
                                    <i id="activo_inicio" class="icon-home"></i> Inicio </a>
                            </li>
                            <li class="active activo_partituras">
                                <a href="#"><i  id="activo_partituras" class="icon-music"></i> Partituras</a>
                            </li>
                            <li class="activo_quienes_somos">
                                <a href="quiensomos.php"><i id="activo_quienes_somos" class="icon-question-sign"></i> &#191;Quienes Somos?</a>
                            </li>
                            <li class="activo_comentario">
                                <a href="#comentarios"><i id="activo_comentario" class="icon-comment"></i> Comentarios</a>
                            </li>           


                            <li>
                                <div class="btn-group">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $nombreUsuario; ?> <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#"><i class="icon-share"></i> Donar Partitura</a></li>
                                        <li><a href="#"><i class="icon-edit"></i> Editar Perfil</a></li>
                                        <li class="divider"></li>
                                        <li><a style="cursor: pointer;" onclick="cerrarSesionResto()"><i class="icon-off"></i> Cerrar Sesi&oacute;n</a></li>
                                    </ul>
                                </div>
                            </li>


                        </ul>
                    </div> 
                </div>
            </div>
            <div id="imgHeader" style="height: 40px; color: #ffffff" >
                <div class="container" >
                    <div class="row" style="max-width: 1000px;">
                        <div class="span1">
                            <h5 style="margin-left: 10px;">Partituras</h5>
                        </div>
                        <div class="span3">
                            <form class="navbar-search pull-left" action="">
                                <input type="text" class="search-query span2" placeholder="Buscar Partitura">
                            </form>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <!--Fin Navbar Estatico-->


        <!--inicio del Contenedor Principal-->
        <div class="container">         
            <!--Inicio Logo Logo-->
            <div style="text-align: center; margin: 65px 0;">                
                <p> <img src="../img/logo.png"></p>

            </div>
            <!--Fin Logo Presentacion-->  
            <!--            <h4 style="margin-top: -60px;">Categorias Disponibles:</h4>-->


            <div class="row" style="margin-top: -60px;"> 
                <div class="bs-docs-example">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td colspan="2">Larry the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>         
            </div>



        </div>
        <!--Fin del Contenedor Principal-->

        <!--Inicio Footer-->
        <div  style="background-color: #1A1A1A"  id="footer">
            <div class="container">
                <div class="row" style="padding-top: 20px; padding-left: 15px; padding-right: 15px;  ">
                    <div class="span4" style="color: #999999; padding-top: 20px;">
                        <p>&copy; Partituras Musicales Gratis 2013<br>
                            Desarrollado por:<br>                            
                            <a href="mailto:#">Eyder Albeiro</a>
                        </p>
                    </div>

                    <div class="span1 personalizado1"  style="color: #999999; padding-top: 20px;">
                        <h4 style="color: #999999">S&iacute;guenos</h4>
                    </div>
                    <div class="span3 "  style="color: #999999; padding-top: 20px;">                        
                        <a href="#"><img src="../img/social/facebook.png" style="width: 40px;"></a> 
                        <a href="#"><img src="../img/social/twitter.png" style="width: 40px;"></a> 
                        <a href="#"><img src="../img/social/youtube.png" style="width: 40px;"></a> 
                    </div>

                    <div class="span2"  style="color: #999999; padding-top: 20px;">
                        <a href="#">  <p> <img src="../img/logo_black.png"></p>  </a>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin Footer-->




        <!--Carga de Scripts-->
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/cargasDinamicas/cerrarSesion.js"></script>
        <script src="../js/script_menu_activos.js"></script>
        <script src="../js/tamanioVentana.js"></script>
        <!--Fin Carga de Scripts-->        
    </body>
</html>
<?php
/* } else {
  header("Location: ../index.php?ventanaModal=true");
  exit();
  } */
?> 