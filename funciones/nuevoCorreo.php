<?php

$destinatario = 'eyderbass@gmail.com';
$mensaje = plantillaCorreoElectronico();
$asunto = 'Bienvenido a Partituras Musicales!';
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'To: Usuario Patituras Musicales <' . $destinatario . '>' . "\r\n";
$headers .= 'From: Equipo Partituras Musicales <administrador@partiturasmusicales.site90.com>' . "\r\n";
$headers .= 'Cc: eaar23@gmail.com' . "\r\n";
$headers .= 'Bcc: musical_score@hotmail.com' . "\r\n";
mail($destinatario, $asunto, $mensaje, $headers);

function plantillaCorreoElectronico() {
    $mensaje = '<!DOCTYPE html>
<html>
    <head>
        <title>Partituras Musicales Gratis</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap.css" rel="stylesheet" media="screen">
        <style type="text/css">

            /* Sticky footer styles
            -------------------------------------------------- */

            html,
            body {
                height: 100%;
            }

            #wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                margin: 0 auto -60px;
            }

            #push,
            #footer {
                height: 60px;
            }
            #footer {
                background-color: #f5f5f5;
            }

            @media (max-width: 767px) {
                #footer {
                    margin-left: -20px;
                    margin-right: -20px;
                    padding-left: 20px;
                    padding-right: 20px;
                }
            }



            /* Custom page CSS
            -------------------------------------------------- */
            /* Not required for template or sticky footer method. */

            .container {
                width: auto;
                max-width: 680px;
            }
            .container .credit {
                margin: 20px 0;
            }

        </style>
        <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">
    </head>

    <body>
        <div id="wrap">
            <div class="container">
                <div class="row-fluid">
                    <div class="page-header">
                        <h3>Bienvenido a Partituras Musicales!</h3>
                        <h6 style="margin-top: -20px">Gracias por registrarte y ser parte de esta Comunidad.</h6>
                    </div>   
                </div>
                <p><strong>Hola!</strong>
                <br>
                Hemos construido este sitio para que music@s como usted, Profesionales &oacute; Aficionad@s puedan compartir y adquirir nuevos conocimientos a traves 
                de la musica.
                <br><br>
                <strong>Sus datos de registro son:</strong><br>
                Nombre de Usuario: <strong> nuevoCorreo</strong>  <br>
               Contrase&ntilde;a:  <strong>nuevoCorreo</strong>  
                </p>
                <p>
                    Antes de continuar <strong>Activa tu Cuenta</strong> haciendo clic en el siguiente link: <br>
                    <a href="http://partiturasmusicales.site90.com">Activar Cuenta</a> <br><br>
                    <strong>&iquest;El link Activar Cuenta esta bloqueado?</strong><br>
                    Ingresa el siguiente link en la barra de direcciones de tu navegador <br>
                    <a href="http://partiturasmusicales.site90.com">http://partiturasmusicales.site90.com</a> <br>
                </p>
                <p>
                Gracias por utilizar <strong>PartiturasMusicales.net</strong><br>
                <strong>PD.</strong> No dude en ponerse en cont&aacute;cto con nosotros si tiene algun problema o sugerencia.
                </p>
                <p>
                    <img src="http://partiturasmusicales.site90.com/css/logo.png" alt="Partituras Musicales"> <br>   
                Saludos cordiales,<br>
                <strong>Equipo Partituras Musicales</strong>.
                </p>
            </div>
            <div id="push"></div>
        </div>
        <div id="footer">
            <div class="container">
                <p class="muted credit">&copy; Partituras Musicales Gratis 2013<br>
                    <a href="">Eyder Albeiro Ascuntar Rosales</a> 
                </p>
            </div>
        </div>
    </body>
</html>';
    return $mensaje;
}
?>