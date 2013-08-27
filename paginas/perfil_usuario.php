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
            <input type="text" hidden="true" style="display: none" value="<?php echo $nombreUsuario; ?>" id="username_perfil">
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
                                <li class="dropdown activo_partituras">
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
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <span id="nombre_usuario"><?php echo $nombreUsuario; ?></span> <b class="caret"></b></a>
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
                            <div class="span3">
                                <h5 style="margin-left: 10px;">Perfil de Usuario</h5>
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



                <div class="row" style="margin-top: -60px;" >               
                    <div class="span10 well well-large" > 
                        <div class="span9">      		

                            <div class="widget stacked ">
                                <div class="widget-header">
                                    <i class="icon-user" style="margin-top:-4px"></i><strong > Detalles de la Cuenta</strong>
                                </div> <!-- /widget-header -->

                                <div class="widget-content">



                                    <div class="tabbable">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#perfil" data-toggle="tab">Perfil</a>
                                            </li>
                                            <li class=""><a href="#settings" data-toggle="tab">Settings</a></li>
                                        </ul>

                                        <br>

                                        <div class="tab-content">
                                            <div class="tab-pane active" id="perfil">
                                                <div id="msg_edicion_perfil" style="display: none">
                                                  
                                                </div>
                                                <form id="edit-perfil" name="edit-perfil" class="form-horizontal">
                                                    <input type="hidden" name="funcion" id="funcion" value="editarPerfilUsuario">
                                                    <input type="hidden" name="bandera" id="bandera" value="">
                                                    <input type="hidden" name="id_usuario" id="id_usuario" value="" >
                                                    <fieldset>
                                                        <div class="control-group">											
                                                            <label class="control-label" for="nom_usuario_edit">Nombre de Usuario: </label>
                                                            <div class="controls">
                                                                <input type="text" class="input-medium" id="nom_usuario_edit" name="nom_usuario_edit" value="" required="required" placeholder="Nombre de Usuario">
                                                            </div> 				
                                                        </div> 
                                                        <div class="control-group">											
                                                            <label class="control-label" for="nom_ape_usuario_edit">Nombre y Apellido: </label>
                                                            <div class="controls">
                                                                <input type="text" class="input-medium" id="nom_ape_usuario_edit" name="nom_ape_usuario_edit" value="" required="required" placeholder="Nombre y Apellido">
                                                            </div> 			
                                                        </div> 

                                                        <div class="control-group">											
                                                            <label class="control-label" for="correo_usuario_edit">Correo Electr&oacute;nico: </label>
                                                            <div class="controls">
                                                                <input type="email" class="input-medium" id="correo_usuario_edit" name="correo_usuario_edit" value="" required="required" placeholder="Correo Electronico">
                                                            </div> 		
                                                        </div> 

                                                        <div class="control-group">
                                                            <a id="edit-claveusuario-mostrar" href="#"> <label class="control-label">Cambiar Contraseña</label></a>
                                                        </div>
                                                        <div class="control-group">
                                                            <a id="edit-claveusuario-cancelar" style="display: none" href="#"><label class="control-label">Cancelar Cambio Contraseña</label></a>
                                                        </div>
                                                        <div id="edit-claveusuario" style="display: none">
                                                            <div class="control-group">											
                                                                <label class="control-label" for="clave_old">Contraseña Anterior: </label>
                                                                <div class="controls">
                                                                    <input type="password" disabled="disabled" class="input-medium" id="clave_old" name="clave_old" value="" placeholder="Contraseña Anterior" required="required">
                                                                </div>			
                                                            </div>
                                                            <div class="control-group">											
                                                                <label class="control-label" for="clave_new">Nueva Contraseña: </label>
                                                                <div class="controls">
                                                                    <input type="password" disabled="disabled" class="input-medium" id="clave_new" name="clave_new" value="" placeholder="Nueva Contraseña" required="required">
                                                                </div> 				
                                                            </div> 
                                                            <div class="control-group">											
                                                                <label class="control-label" for="confirm_clave_new">Confirmar Contraseña: </label>
                                                                <div class="controls">
                                                                    <input type="password" disabled="disabled" class="input-medium" id="confirm_clave_new" name="confirm_clave_new" value="" placeholder="Confirmar Contraseña" required="required">
                                                                </div> 				
                                                            </div> 
                                                        </div>
                                                        <div class="form-actions" style="background-color: white">
                                                            <button type="submit" class="boton btn btn-primary">Guardar</button> 
                                                            <button class="btn">Cancelar</button>
                                                        </div> 
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div class="tab-pane" id="settings">
                                                <form id="edit-perfil2" class="form-horizontal">
                                                    <fieldset>


                                                        <div class="control-group">
                                                            <label class="control-label" for="accounttype">Account Type</label>
                                                            <div class="controls">
                                                                <label class="radio">
                                                                    <input type="radio" name="accounttype" value="option1" checked="checked" id="accounttype">
                                                                    POP3
                                                                </label>
                                                                <label class="radio">
                                                                    <input type="radio" name="accounttype" value="option2">
                                                                    IMAP
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="accountusername">Account Username</label>
                                                            <div class="controls">
                                                                <input type="text" class="input-large" id="accountusername" value="rod.howard@example.com">
                                                                <p class="help-block">Leave blank to use your perfil email address.</p>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="emailserver">Email Server</label>
                                                            <div class="controls">
                                                                <input type="text" class="input-large" id="emailserver" value="mail.example.com">
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label" for="accountpassword">Password</label>
                                                            <div class="controls">
                                                                <input type="text" class="input-large" id="accountpassword" value="password">
                                                            </div>
                                                        </div>




                                                        <div class="control-group">
                                                            <label class="control-label" for="accountadvanced">Advanced Settings</label>
                                                            <div class="controls">
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="accountadvanced" value="option1" checked="checked" id="accountadvanced">
                                                                    User encrypted connection when accessing this server
                                                                </label>
                                                                <label class="checkbox">
                                                                    <input type="checkbox" name="accounttype" value="option2">
                                                                    Download all message on connection
                                                                </label>
                                                            </div>
                                                        </div>


                                                        <br>

                                                        <div class="form-actions">
                                                            <button type="submit" class="btn btn-primary">Save</button> <button class="btn">Cancel</button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>

                                        </div>


                                    </div>





                                </div> <!-- /widget-content -->

                            </div> <!-- /widget -->

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
            <script type="text/javascript" src="../js/eventosGenericos.js"></script>
            <script src="../js/cargasDinamicas/funcionesPerfilUsuario.js"></script>
            <script src="../js/script_menu_activos.js"></script>
            
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