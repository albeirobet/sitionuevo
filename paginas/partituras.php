<?php
session_start();
if (isset($_SESSION['Tipo_Usuario']) && isset($_SESSION['Nombre_Usuario'])) {
    $nombreUsuario = $_SESSION["Nombre_Usuario"];
    // include '../funciones/evitarCache.php';
    ?> 
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <title>Partituras</title>
            <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Bootstrap -->
            <link href="../css/bootstrap.css" rel="stylesheet" media="screen">
            <link href="../css/bootstrap-responsive.css" rel="stylesheet">
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
                                <li class="active dropdown activo_partituras">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i  id="activo_partituras" class="icon-music"></i> Partituras <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="partituras.php">Todas</a></li>
                                        <li class="divider"></li>
                                        <li class="nav-header">Generos</li>
                                        <li><a href="partiturasGenero.php?g=s">Salsa</a></li>
                                        <li><a href="partiturasGenero.php?g=m">Merengue</a></li>
                                        <li><a href="partiturasGenero.php?g=c">Cumbia</a></li>
                                        <li><a href="partiturasGenero.php?g=mx">Mexicana</a></li>
                                        <li><a href="partiturasGenero.php?g=v">Varios</a></li>
                                    </ul>
                                </li>
                                <li class="activo_quienes_somos">
                                    <a href="quiensomos.php"><i id="activo_quienes_somos" class="icon-question-sign"></i> &#191;Quienes Somos?</a>
                                </li>
                                <li class="activo_comentario">
                                    <a href="#comentarios"><i id="activo_comentario" class="icon-comment"></i> Comentarios</a>
                                </li>           


                                <?php
                                session_start();
                                if (isset($_SESSION['Tipo_Usuario']) && isset($_SESSION['Nombre_Usuario'])) {
                                    $nombreUsuario = $_SESSION["Nombre_Usuario"];
                                    ?>
                                    <li class="active dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $nombreUsuario; ?> <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#"><i class="icon-share"></i> Donar Partitura</a></li>
                                            <li><a href="perfil_usuario.php"><i class="icon-edit"></i> Editar Perfil</a></li>
                                            <li><a style="cursor: pointer;" onclick="cerrarSesionResto()"><i class="icon-off"></i> Cerrar Sesi&oacute;n</a></li>
                                            <?php
                                            if ($_SESSION['Tipo_Usuario'] == 'Administrador') {
                                                ?>  
                                                <li class="divider"></li>
                                                <li class="nav-header">Administradores</li>
                                                <li><a href="#"><i class="icon-wrench"></i> Gestionar Web</a></li>
                                                <?php
                                            }
                                            ?> 
                                        </ul>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="activo_login_registro">
                                        <a id="abrir_modal" href="#modal_login_registro"  data-toggle="modal"><i id="activo_login_registro" class="icon-plus-sign"></i> Log In / Registro</a>
                                    </li> 
                                    <?php
                                }
                                ?>


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
                            <!--                        <div class="span3">
                                                        <form class="navbar-search pull-left" action="">
                                                            <input type="text" class="search-query span2" placeholder="Buscar Partitura">
                                                        </form>
                                                    </div>-->

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
                    <div class="span10 well well-large" > 
                        <div class="span4">
                            <img src="../img/generos/genero_salsa_w.png">
                        </div> 
                        <div class="span5">
                            <dl>
                                <dd>En esta secci&oacute;n encontraras Partituras del genero de la Salsa. </dd>
                            </dl>
                            <ul style="font-size: 12px;">
                                <li id="partSalsa1"></li>
                                <li id="partSalsa2"></li>
                                <li id="partSalsa3"></li>
                                <li id="partSalsa4"></li>
                                <li id="partSalsa5"></li>
                                <li id="partSalsa6"></li>
                                <li id="partSalsa7"></li>
                                <li id="partSalsa8"></li>
                                <li id="partSalsa9"></li>
                                <li id="partSalsa10"></li>
                            </ul>
                            <a href="partiturasGenero.php?g=s"><button class="btn-mini btn-inverse" type="button">Ver Mass &raquo;</button></a>    
                        </div> 
                    </div>           
                </div>
                <div class="row" >               
                    <div class="span10 well well-large" > 
                        <div class="span4">
                            <img src="../img/generos/genero_merengue_w.png" >
                        </div> 
                        <div class="span5">
                            <dl>

                                <dd>En esta secci&oacute;n encontraras Partituras del genero Merengue. </dd>
                            </dl>
                            <ul style="font-size: 12px;">
                                <li id="partMerengue1"></li>
                                <li id="partMerengue2"></li>
                                <li id="partMerengue3"></li>
                                <li id="partMerengue4"></li>
                                <li id="partMerengue5"></li>
                                <li id="partMerengue6"></li>
                                <li id="partMerengue7"></li>
                                <li id="partMerengue8"></li>
                                <li id="partMerengue9"></li>
                                <li id="partMerengue10"></li>

                            </ul>
                            <a href="partiturasGenero.php?g=m"><button class="btn-mini btn-inverse" type="button">Ver Mass &raquo;</button></a>    
                        </div> 
                    </div>           
                </div>
                <div class="row" >               
                    <div class="span10 well well-large" > 
                        <div class="span4">
                            <img src="../img/generos/genero_cumbia_w.png">
                        </div> 
                        <div class="span5">
                            <dl>

                                <dd>En esta secci&oacute;n encontraras Partituras del genero de la Cumbia. </dd>
                            </dl>
                            <ul style="font-size: 12px;">
                                <li id="partCumbia1"></li>
                                <li id="partCumbia2"></li>
                                <li id="partCumbia3"></li>
                                <li id="partCumbia4"></li>
                                <li id="partCumbia5"></li>
                                <li id="partCumbia6"></li>
                                <li id="partCumbia7"></li>
                                <li id="partCumbia8"></li>
                                <li id="partCumbia9"></li>
                                <li id="partCumbia10"></li>

                            </ul>
                            <a href="partiturasGenero.php?g=c"><button class="btn-mini btn-inverse" type="button">Ver Mass &raquo;</button></a>  
                        </div> 
                    </div>           
                </div>
                <div class="row" >               
                    <div class="span10 well well-large" > 
                        <div class="span4">
                            <img src="../img/generos/genero_mexicana_w.png">
                        </div> 
                        <div class="span5">
                            <dl>

                                <dd>En esta secci&oacute;n encontraras Partituras de Musica Mexicana. </dd>
                            </dl>
                            <ul style="font-size: 12px;">
                                <li><a href="#" target="_blank">Valio la Pena - Marc Anthony</a></li>
                                <li><a href="#" target="_blank">Valio la Pena - Marc Anthony</a></li>
                                <li><a href="#" target="_blank">Valio la Pena - Marc Anthony</a></li>
                                <li><a href="#" target="_blank">Valio la Pena - Marc Anthony</a></li>
                                <li><a href="#" target="_blank">Valio la Pena - Marc Anthony</a></li>
                                <li><a href="#" target="_blank">Valio la Pena - Marc Anthony</a></li>
                                <li><a href="#" target="_blank">Valio la Pena - Marc Anthony</a></li>
                                <li><a href="#" target="_blank">Valio la Pena - Marc Anthony</a></li>

                            </ul>
                            <a href="partiturasGenero.php?g=mx"><button class="btn-mini btn-inverse" type="button">Ver Mass &raquo;</button></a>     
                        </div> 
                    </div>           
                </div>
                <div class="row" >               
                    <div class="span10 well well-large" > 
                        <div class="span4">
                            <img src="../img/generos/genero_varios_w.png">
                        </div> 
                        <div class="span5">
                            <dl>

                                <dd>En esta secci&oacute;n encontraras Partituras de Varios Generos. </dd>
                            </dl>
                            <ul style="font-size: 12px;">
                                <li id="partVarios1"></li>
                                <li id="partVarios2"></li>
                                <li id="partVarios3"></li>
                                <li id="partVarios4"></li>
                                <li id="partVarios5"></li>
                                <li id="partVarios6"></li>
                                <li id="partVarios7"></li>
                                <li id="partVarios8"></li>
                                <li id="partVarios9"></li>
                                <li id="partVarios10"></li>

                            </ul>
                            <a href="partiturasGenero.php?g=v"><button class="btn-mini btn-inverse" type="button">Ver Mass &raquo;</button></a>    
                        </div> 
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
            <script src="../js/bootstrap.js"></script>
            <script src="../js/cargasDinamicas/cerrarSesion.js"></script>
            <script src="../js/script_menu_activos.js"></script>
            <script src="../js/cargasDinamicas/cargarGeneros.js"></script>
            <script type="text/javascript" src="../js/eventosGenericos.js"></script>
            <!--Fin Carga de Scripts-->        
            <div id="ajaxModal" class="modal hide fade" tabindex="-1" data-keyboard="false" data-backdrop="static" style="height: 35px;">
                <div class="progress progress-striped active">
                    <div class="bar" style="width: 100%;"></div>
                </div>
                <p class="text-center" style="margin-top: -23px">Espere por favor.</p>
            </div>
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php?ventanaModal=true");
    exit();
}
?>