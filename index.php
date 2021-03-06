<?
session_start();
include 'funciones/evitarCache.php';
?> 
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Partituras Musicales Gratis</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Bootstrap -->
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <!--Fin Bootstrap-->
        <link href="css/estilosPersonalizados.css" rel="stylesheet">

        <link rel="apple-touch-icon" href="img/apple-touch-icon-iphone.png" /> 
        <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png" /> 
        <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone4.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad3.png" />
        <link rel="shortcut icon" href="img/clave.png">

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
                        <img src="img/clave.png" class="img-rounded" style="width: 25px;">
                        Partituras Musicales Gratis

                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="active activo_inicio">
                                <a href="#">
                                    <i id="activo_inicio" class="icon-home"></i> Inicio </a>
                            </li>
                            <li class="dropdown activo_partituras">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i  id="activo_partituras" class="icon-music"></i> Partituras <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="paginas/partituras.php">Todas</a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Generos</li>
                                    <li><a href="paginas/partiturasGenero.php?g=s">Salsa</a></li>
                                    <li><a href="paginas/partiturasGenero.php?g=m">Merengue</a></li>
                                    <li><a href="paginas/partiturasGenero.php?g=c">Cumbia</a></li>
                                    <li><a href="paginas/partiturasGenero.php?g=mx">Mexicana</a></li>
                                    <li><a href="paginas/partiturasGenero.php?g=v">Varios</a></li>
                                </ul>
                            </li>
                            <li class="activo_quienes_somos">
                                <a href="paginas/quiensomos.php"><i id="activo_quienes_somos" class="icon-question-sign"></i> &#191;Quienes Somos?</a>
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
                                        <li><a href="paginas/perfil_usuario.php"><i class="icon-edit"></i> Editar Perfil</a></li>
                                        <li><a style="cursor: pointer;" onclick="cerrarSesionIndex()"><i class="icon-off"></i> Cerrar Sesi&oacute;n</a></li>
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

        </div>

        <!-- Ventana Modal Login / Registro -->

        <div id="modal_login_registro" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <div id="titulo_iniciar_sesion">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 id="myModalLabel" class="text-center">Iniciar Sesi&oacute;n </h3>   
                </div>
                <div id="titulo_recuperar_datos" style="display: none">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 id="myModalLabel" class="text-center">Recuperar Datos </h3>   
                </div>
                <div id="titulo_registro_usuario" style="display: none">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 id="myModalLabel" class="text-center">Registro Usuario Nuevo</h3>   
                </div>
                <div id="titulo_confirmar_cuenta" style="display: none">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 id="myModalLabel" class="text-center">Verificar Correo Electronico</h3>   
                </div>


            </div>
            <div class="modal-body">

                <div id="formularioIngreso">
                    <form style="text-align: center" id="formularioLogin" name="formularioLogin">
                        <input type="hidden" name="funcion" id="funcion" value="loginUsuarios">
                        <div class="control-group">
                            <label class="control-label" for="inputUsername"><strong>Nombre de Usuario</strong></label>
                            <div class="controls">
                                <input type="text" required="" id="username_login"  class="user_login" name="username_login" placeholder="Nombre de Usuario">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label " for="inputPassword"><strong>Contrase&#241;a</strong></label>
                            <div class="controls">
                                <input type="password" required="" id="password_login" class="pass_login" name="password_login" placeholder="Contrase&#241;a">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <div>
                                    <span id="infor_entrando" class="text-warning ocultar" >Entrando al Sistema</span>
                                    <span id="infor_confirmacion" class="text-success ocultar" >Datos Confirmados</span>
                                    <span id="infor_error" class="text-error ocultar" >Datos Incorrectos, Verifique</span>
                                </div>
                                <button type="submit" class="btn btn-primary botonLogin" accesskey="enter">Ingresar</button>
                                <button  class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>

                            </div>
                        </div>
                    </form>
                    <p class="text-center">&#191;Olvid&oacute; sus Datos? <a style="cursor: pointer;" ><span id="recuperar_datos" class="text-info">Recup&eacute;relos.</span></a></p>
                    <p class="text-center"> &#191;No tiene una Cuenta?  <a  style="cursor: pointer;" id="registro_usuario"><span class="text-info">Reg&iacute;strese.</span></a></p>
                    <p class="text-center">  <strong><span>Nota: </span></strong> <span>Solo Usuarios Registrados acceden a la Secci&oacute;n de Descargas.</span></p>
                </div>


                <div id="recuperarDatos" style="display: none">
                    <p>Ingrese la Direcci&oacute;n de Correo Electronico con la cual se registro y en instantes le enviaremos sus Datos.</p>
                    <form id="formularioRecovery" name="formularioRecovery">
                        <input type="hidden" name="funcion" id="funcion" value="recuperarDatos">                        
                        <div class="control-group">
                            <label class="control-label" for="inputRecuperarDatos">Correo Electronico</label>
                            <div class="controls">
                                <input type="email" id="email_recovery" name="email_recovery" class="caja_recuperar_datos" placeholder="Correo Electronico">
                                <span id="esperandoConfirmacion" style="display: none" class="text-success">Comprobando Correo Electronico.</span>
                                <span id="sinConfirmacion" style="display: none" class="text-error">No existe un Usuario Registrado con este Correo Electronico.</span>
                                <span id="Confirmacionhecha" style="display: none" class="text-success">Datos Enviados a su Bandeja de Entrada.</span>
                            </div>
                        </div>
                        <div class="controls">
                            <button type="submit" class="btn btn-primary recuperar_datos">Enviar</button>
                            <button  class="btn" data-dismiss="modal" aria-hidden="true" >Cancelar</button>
                        </div>
                    </form> 
                </div>


                <div id="frmRegistroUsuario" style="display: none; text-align: center">
                    <form class='contacto' id="formularioRegistro" name="formularioRegistro">
                        <input type="hidden" name="funcion" id="funcion" value="registroUsuarios">
                        <div>
                            <label ><strong>Nombre y Apellido:</strong></label>
                            <input type='text' class='code' value='' id="nombres" name="nombres"  placeholder="Nombre y Apellido" required="required">
                        </div>
                        <div>
                            <label ><strong>Nombre de Usuario:</strong></label>
                            <input type='text' class='user' value=''  id="username"  name="username"  placeholder="Nombre de Usuario" required="required">
                        </div>
                        <div>
                            <label ><strong>Contraseña:</strong></label>
                            <input type='password' class='pass' value=''  id="password" name="password"  placeholder="Contraseña" required="required">
                        </div>
                        <div>
                            <label ><strong>Confirmar Contraseña:</strong></label>
                            <input type='password' class='confirm_pass' value=''  id="comfirm_password" name="comfirm_password"  placeholder="Confirmar Contraseña" required="required">
                        </div>
                        <div>
                            <label ><strong>Correo Electronico:</strong></label>
                            <input type='email' class='email_register' value=''  id="email_register" name="email_register"  placeholder="Correo Electronico" required="required">
                        </div>
                        <div class="row-fluid">
                            <input id="terminosCondiciones" type="checkbox" >   
                            <span class="terminosCondiciones">Acepto los  <span><a href="#">Terminos y Condiciones</a></span></span>
                        </div>
                        <div>
                            <input type="submit" value="Registrarse" class="boton btn btn-primary" style="margin-top: 6px;">
                            <button  class="btn" data-dismiss="modal" aria-hidden="true" style="margin-top: 6px;">Cancelar</button>
                            <br>
                            <span id="informacionRegistro" ></span>
                        </div>
                    </form>
                    <br><br>
                </div>

                <div id="confirmarCuenta" style="display: none">
                    <p><strong>¡Hola!</strong><br><br>
                    Hemos enviado un correo a <strong><span id="cuentaCorreo" class="text-info"></span></strong> con 
                    las instrucciones para activar tu cuenta. Si en los pr&oacute;ximos minutos no lo encuentras en la bandeja de entrada,
                    por favor revisa tu carpeta de <strong><span id="cuentaCorreo" class="text-info">correo no deseado</span></strong>, es posible
                    que este ah&iacute;.<br><br>

                    <strong>¡Muchas gracias!</strong>
                    </p>
                    <p>
                        <a href="#" id="logindesdeConfirmarCorreo">Iniciar Sesi&oacute;n</a><strong>,</strong>  <a href=""><strong>Reenviar</strong> Correo de Verificaci&oacute;n.</a>  
                    </p>
                </div>
            </div>
        </div>




        <!-- Fin Ventana Modal Login / Registro -->
        <!--Fin Navbar Estatico-->
        <div id="imgHeader"  class="espacioHeader">
            <div class="container">
                <div class="row">
                    <div class="span5">
                        <img src="img/nota_presentacion.png" style="margin-top: 20px;" class="imagenHeader">
                    </div>
                    <div class="span5 anuncio" style="margin-top: 40px">

                        <p class="anuncio1">Comunidad Virtual De Musicos</p>
                        <p class="anuncio2">Bienvenidos!</p>
                    </div>
                </div>
            </div>
        </div>
        <!--inicio del Contenedor Principal-->

        <div class="container">         
            <!--            Inicio Logo Logo
                        <div style="text-align: center; margin: 65px 0;">                
                            <p> <img src="img/logo.png"></p>
                        </div>
                        Fin Logo Presentacion  -->

            <h4 >Partituras Disponibles: <strong class="text-info" id="CantidadPartituras">4.500</strong></h4>

            <p class="tamventana" id="tamventana" style="font-size: 16px"></p>
            <hr>
            <h4>Partituras Nuevas</h4>
            <div class="row">
                <div class="span2 well well-large">                   
                    <dl>
                        <dt id="titulo_partitura_reciente_1"></dt>
                        <dd>Canci&oacute;n</dd>
                    </dl>
                    <img src="img/clave_reciente.png" class="img-circle">
                    <dl>
                        <dt id="artista_partitura_reciente_1"></dt>
                        <dd>Artista</dd>
                    </dl>
                    <p >Partitura donada por: <br>
                        <strong id="donante_partitura_reciente_1"></strong><br>
                        Pais:<br>
                        <strong id="pais_donante_partitura_reciente_1"></strong>
                    </p>
                    <p><a class="btn btn-mini btn-primary contadorDescargas" id="link_partitura_reciente_1" href="" target="_blank">Descargar &raquo;</a>
                </div>
                <div class="span2 well well-large">                   
                    <dl>
                        <dt id="titulo_partitura_reciente_2"></dt>
                        <dd>Canci&oacute;n</dd>
                    </dl>
                    <img src="img/clave_reciente.png" class="img-circle">
                    <dl>
                        <dt id="artista_partitura_reciente_2"></dt>
                        <dd>Artista</dd>
                    </dl>
                    <p >Partitura donada por: <br>
                        <strong id="donante_partitura_reciente_2"></strong><br>
                        Pais:<br>
                        <strong id="pais_donante_partitura_reciente_2"></strong>
                    </p>
                    <p><a class="btn btn-mini btn-primary contadorDescargas" id="link_partitura_reciente_2" href="" target="_blank">Descargar &raquo;</a>
                </div>

                <div class="span2 well well-large">                   
                    <dl>
                        <dt id="titulo_partitura_reciente_3"></dt>
                        <dd>Canci&oacute;n</dd>
                    </dl>
                    <img src="img/clave_reciente.png" class="img-circle">
                    <dl>
                        <dt id="artista_partitura_reciente_3"></dt>
                        <dd>Artista</dd>
                    </dl>
                    <p >Partitura donada por: <br>
                        <strong id="donante_partitura_reciente_3"></strong><br>
                        Pais:<br>
                        <strong id="pais_donante_partitura_reciente_3"></strong>
                    </p>
                    <p><a class="btn btn-mini btn-primary contadorDescargas" id="link_partitura_reciente_3" href="" target="_blank">Descargar &raquo;</a>
                </div>

                <div class="span2 well well-large">                   
                    <dl>
                        <dt id="titulo_partitura_reciente_4"></dt>
                        <dd>Canci&oacute;n</dd>
                    </dl>
                    <img src="img/clave_reciente.png" class="img-circle">
                    <dl>
                        <dt id="artista_partitura_reciente_4"></dt>
                        <dd>Artista</dd>
                    </dl>
                    <p >Partitura donada por: <br>
                        <strong id="donante_partitura_reciente_4"></strong><br>
                        Pais:<br>
                        <strong id="pais_donante_partitura_reciente_4"></strong>
                    </p>
                    <p><a class="btn btn-mini btn-primary contadorDescargas" id="link_partitura_reciente_4" href="" target="_blank">Descargar &raquo;</a>
                </div>
            </div>
            <div style="text-align: center;">                
                <a href="paginas/partituras.php"> <button class="btn btn-inverse" type="button">Ver Mass &raquo;</button></a>
            </div>
            <hr>
            <!--Fin Sección Partituras Nuevas-->


            <!--Inicio Partituras Mas Descargadas-->
            <h4>Partituras M&aacute;s Descargadas</h4>
            <hr>
            <div class="row" id="masDescargadas">   
                <div class="span2 well well-large">    
                    <dl>
                        <dt id="titulo_partitura_mas_descargada_1"></dt>
                        <dd>Canci&oacute;n</dd>
                    </dl>
                    <img src="img/clave_mas_descargada.png" class="img-circle">
                    <dl>
                        <dt id="artista_partitura_mas_descargada_1"></dt>
                        <dd>Artista</dd>
                    </dl>
                    <p>Partitura donada por: <br>
                        <strong id="donante_partitura_mas_descargada_1"></strong><br>
                        Pais:<br>
                        <strong id="pais_donante_partitura_mas_descargada_1"></strong><br>
                        Numero Descargas:<br>                       
                        <span class="badge badge-info" id="cantidad_descargas_partitura_mas_descargada_1"></span>
                    </p>
                    <p><a class="btn btn-mini btn-primary contadorDescargas" id="link_partitura_mas_descargada_1" href="" target="_blank" >Descargar &raquo;</a>
                </div>

                <div class="span2 well well-large">    
                    <dl>
                        <dt id="titulo_partitura_mas_descargada_2"></dt>
                        <dd>Canci&oacute;n</dd>
                    </dl>
                    <img src="img/clave_mas_descargada.png" class="img-circle">
                    <dl>
                        <dt id="artista_partitura_mas_descargada_2"></dt>
                        <dd>Artista</dd>
                    </dl>
                    <p>Partitura donada por: <br>
                        <strong id="donante_partitura_mas_descargada_2"></strong><br>
                        Pais:<br>
                        <strong id="pais_donante_partitura_mas_descargada_2"></strong><br>
                        Numero Descargas:<br>                       
                        <span class="badge badge-info" id="cantidad_descargas_partitura_mas_descargada_2"></span>
                    </p>
                    <p><a class="btn btn-mini btn-primary contadorDescargas" id="link_partitura_mas_descargada_2" href="" target="_blank">Descargar &raquo;</a>
                </div>

                <div class="span2 well well-large">    
                    <dl>
                        <dt id="titulo_partitura_mas_descargada_3"></dt>
                        <dd>Canci&oacute;n</dd>
                    </dl>
                    <img src="img/clave_mas_descargada.png" class="img-circle">
                    <dl>
                        <dt id="artista_partitura_mas_descargada_3"></dt>
                        <dd>Artista</dd>
                    </dl>
                    <p>Partitura donada por: <br>
                        <strong id="donante_partitura_mas_descargada_3"></strong><br>
                        Pais:<br>
                        <strong id="pais_donante_partitura_mas_descargada_3"></strong><br>
                        Numero Descargas:<br>                       
                        <span class="badge badge-info" id="cantidad_descargas_partitura_mas_descargada_3"></span>
                    </p>
                    <p><a class="btn btn-mini btn-primary contadorDescargas" id="link_partitura_mas_descargada_3"  href="" target="_blank">Descargar &raquo;</a>
                </div>

                <div class="span2 well well-large">    
                    <dl>
                        <dt id="titulo_partitura_mas_descargada_4"></dt>
                        <dd>Canci&oacute;n</dd>
                    </dl>
                    <img src="img/clave_mas_descargada.png" class="img-circle">
                    <dl>
                        <dt id="artista_partitura_mas_descargada_4"></dt>
                        <dd>Artista</dd>
                    </dl>
                    <p>Partitura donada por: <br>
                        <strong id="donante_partitura_mas_descargada_4"></strong><br>
                        Pais:<br>
                        <strong id="pais_donante_partitura_mas_descargada_4"></strong><br>
                        Numero Descargas:<br>                       
                        <span class="badge badge-info" id="cantidad_descargas_partitura_mas_descargada_4"></span>
                    </p>
                    <p><a class="btn btn-mini btn-primary contadorDescargas" id="link_partitura_mas_descargada_4" href="" target="_blank">Descargar &raquo;</a>
                </div>


            </div>
            <div style="text-align: center;">                
                <a href="paginas/partituras.php"> <button class="btn btn-inverse" type="button">Ver Mass &raquo;</button></a>
            </div>  
            <hr>
            <!--Fin Partituras Mas Descargadas-->
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
                        <a href="#"><img src="img/social/facebook.png" style="width: 40px;"></a> 
                        <a href="#"><img src="img/social/twitter.png" style="width: 40px;"></a> 
                        <a href="#"><img src="img/social/youtube.png" style="width: 40px;"></a> 
                    </div>

                    <div class="span2"  style="color: #999999; padding-top: 20px;">
                        <a href="#">  <p> <img src="img/logo_black.png"></p>  </a>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin Footer-->




        <!--Carga de Scripts-->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/script_menu_activos.js"></script>
        <script src="js/cargasDinamicas/login.js"></script>
        <script src="js/cargasDinamicas/cerrarSesion.js"></script>
        <script src="js/tamanioVentana.js"></script>
        <script type="text/javascript" src="js/cargasDinamicas/funciones.js"></script>
        <script type="text/javascript" src="js/eventosGenericos.js"></script>

        <!--Fin Carga de Scripts-->        
        <script language="javascript">


        </script>

        <?php
        if (isset($_GET['ventanaModal'])) {
            ?>
            <script language="javascript">
                $(document).ready(function() {
                    $('#modal_login_registro').modal('show');
                });
            </script>
            <?php
        }
        ?>
        <div id="ajaxModal" class="modal hide fade" tabindex="-1" data-keyboard="false" data-backdrop="static" style="height: 35px;">
            <div class="progress progress-striped active">
                <div class="bar" style="width: 100%;"></div>
            </div>
            <p class="text-center" style="margin-top: -23px">Espere por favor. </p>
        </div>
    </body>
</html>
