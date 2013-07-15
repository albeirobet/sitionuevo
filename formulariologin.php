<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>


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

        <div class="container">
            <div id="frmRegistroUsuario">
                <form class='contacto' id="formularioRegistro" name="formularioRegistro" style="text-align: left; position: relative;margin-top: 10px; margin-left: -67px;">
                    <input type="hidden" name="funcion" id="funcion" value="registroUsuarios">
                    <div><label >Nombre y Apellido:</label><input type='text' class='code' value='' id="nombres" name="nombres" ></div>
                    <div><label >Nombre de Usuario:</label><input type='text' class='user' value=''  id="username"  name="username" ></div>
                    <div><label >Contraseña:</label><input type='password' class='pass' value=''  id="password" name="password" ></div>
                    <div><label >Confirmar Contraseña:</label><input type='password' class='confirm_pass' value=''  id="comfirm_password" name="comfirm_password" ></div>
                    <div><label >Email:</label><input type='text' class='email_register' value=''  id="email_register" name="email_register" ></div>
                    <div>
                        <input type="submit" value="Registrarse" class="boton btn btn-small btn-primary" style="margin-top: 6px;">
                        <input type="submit" value="Cancelar" class="boton btn btn-small btn-danger cancelarRegistro" style="margin-top: 6px;">
                        <br>
                        <span id="informacionRegistro" style="margin-left: 2px;font-size:12px;"></span>

                    </div>
                </form>
                <br><br>
            </div>
        </div>
        <!--Carga de Scripts-->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/script_menu_activos.js"></script>
        <script src="js/cargasDinamicas/login.js"></script>
        <script src="js/cargasDinamicas/cerrarSesion.js"></script>
        <script type="text/javascript" src="js/cargasDinamicas/funciones.js"></script>
        <script src="../js/login.js" type="text/javascript"></script> 

        <!--Fin Carga de Scripts-->      
    </body>
</html>
