<?php

require_once('geoplugin.class.php');
require_once './conexionPDO.php';

$metodo = $_POST['funcion'];
if ($metodo == "cargarGeneros" || $metodo == "cargarPorGenero") {
    $genero = $_POST['genero'];
    $metodo($genero);
} else {
    $metodo();
}

function ObtenerDatosGeolocalizacion() {
    $geoplugin = new geoPlugin();
    $geoplugin->locate();
    $ip = $geoplugin->ip;
    $ciudad = $geoplugin->city;
    $region = $geoplugin->region;
    $pais = $geoplugin->countryName;
    $arregloDatos = array('ip' => $ip, 'ciudad' => $ciudad, 'region' => $region, 'pais' => $pais);
    return $arregloDatos;
}

function getCantidadPartituras() {
    $cantidad = getCantidadRegistros('partituras_subidas');
    $arr = array('Cantidad' => $cantidad);
    echo '[' . json_encode($arr) . ']';
}

function cargarRecientes() {
    $arreglo = getElementosPorLimiteTabla('partituras_subidas', 'id', 'DESC', '4');
    $contador = 0;
    foreach ($arreglo as $row) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga']);
        $contador++;
    }
    echo '' . json_encode($arr) . '';
}

function topDescargas() {
    $arreglo = getElementosPorLimiteTabla('partituras_subidas', 'contador_descargas', 'DESC', '0 , 4');
    $contador = 0;
    foreach ($arreglo as $row) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga'],
                    'Contador' => $row['contador_descargas']);
        $contador++;
    }
    echo '' . json_encode($arr) . '';
}

function cargarGeneros($genero) {
    if ($genero) {
        $arreglo = getElementosEspecificosPorLimite('partituras_subidas', 'genero', $genero, 'string', 'ORDER BY id DESC LIMIT 10');
        $contador = 0;
        foreach ($arreglo as $row) {
            $arr[$contador] =
                    array('Titulo' => $row['titulo'],
                        'Autor' => $row['autor'],
                        'Id' => $row['id'],
                        'Link' => $row['link_descarga']);
            $contador++;
        }
        echo '' . json_encode($arr) . '';
    }
}

function cargarPorGenero($genero) {
    if ($genero) {
        $limite = $_POST['limite'];
        $filtro = $_POST['filtro'];
        $palabra = $_POST['palabra'];
        $arreglo = getPartiturasPorGenero('partituras_subidas', $genero, $limite, $filtro, $palabra);
        $contador = 0;
        foreach ($arreglo as $row) {
            $arr[$contador] = array('Titulo' => $row['titulo'],
                'Autor' => $row['autor'],
                'Id' => $row['id'],
                'Link' => $row['link_descarga'],
                'Fecha' => $row['fecha_publicacion'],
                'PuntosPositivos' => $row['puntos_positivos'],
                'PuntosNegativos' => $row['puntos_negativos'],
                'Donador' => $row['donada_por'],
                'Contador' => $row['contador_descargas']);
            $contador++;
        }
        echo '' . json_encode($arr) . '';
    }
}

function contadorPartiturasPorGenero() {
    $genero = $_POST['genero'];
    if ($genero) {
        $palabra = $_POST['palabra'];
        $total = getCantidadPartiturasPorGenero('partituras_subidas', $genero, $palabra);
        $totalPaginas = ceil($total / 5);
        echo $totalPaginas . "%" . $total;
        include 'desconectar.php';
    }
}

function actualizarContadorDescargas() {
    $id = $_POST['id'];
    if ($id) {
        $contador = updateContadorDescargasPartitura('partituras_subidas', 'contador_descargas', $id);
        echo $contador;
    }
}

function loginUsuarios() {
    $username = $_POST["username_login"];
    $password = $_POST["password_login"];
    $arr[0] = array('estado' => '0');
    if (!empty($username) && !empty($password)) {
        $arreglo = loginUsers('tbl_users', 'user', $username, 'pass', $password);
        if (!$arreglo == false) {
            foreach ($arreglo as $fila) {
                $tipoUsuario = $fila['tipo_usuario'];
                $email = $fila['email'];
            }
            session_start();
            $_SESSION["Nombre_Usuario"] = $username;
            $_SESSION["Correo_Usuario"] = $email;
            $_SESSION["Tipo_Usuario"] = $tipoUsuario;
            $datosLocalizacion = ObtenerDatosGeolocalizacion();
            $ip = $datosLocalizacion['ip'];
            $ciudad = $datosLocalizacion['ciudad'];
            $region = $datosLocalizacion['region'];
            $pais = $datosLocalizacion['pais'];
            updateDatosLocalizacionUsuario('tbl_users', $ip, $ciudad, $region, $pais, $username);
            $arr[0] = array('estado' => '2');
        } else {
            $arr[0] = array('estado' => '0');
        }
    }
    echo '' . json_encode($arr) . '';
}


function registroUsuarios() {
    $username = $_POST['username'];
    $email = $_POST['email_register'];
    $nombres = $_POST['nombres'];
    $password = $_POST['password'];
    if (!empty($username) && !empty($email) && !empty($nombres) && !empty($password)) {
        $fechaRegistro = date("y-m-d");
        $datosLocalizacion = ObtenerDatosGeolocalizacion();
        $ip = $datosLocalizacion['ip'];
        $ciudad = $datosLocalizacion['ciudad'];
        $region = $datosLocalizacion['region'];
        $pais = $datosLocalizacion['pais'];
        $codigoverificacion = rand(0000000000, 9999999999);
        $ingreso = registerUsers('tbl_users', $username, $email, $nombres, $password, $fechaRegistro, $ip, $ciudad, $region, $pais, $codigoverificacion);
        if ($ingreso == 1) {
            enviarCorreo($email, $username, $password, $codigoverificacion, 1);
            $arr[0] = array('estado' => '1');
            echo '' . json_encode($arr) . '';
        } else {
            $arr[0] = array('estado' => '0');
            echo '' . json_encode($arr) . '';
        }
    } else {
        $arr[0] = array('estado' => '0');
        echo '' . json_encode($arr) . '';
    }
}

function  getInformacionPerfilUsuario(){
    $username = $_POST['username'];
    if(!empty($username)){
    $arreglo = getElementosEspecificos('tbl_users', 'user', $username, 'string');
    $contador = 0;
        foreach ($arreglo as $row) {
            $arr[$contador] =
                    array('Nombres' => $row['nombres'],
                        'NomUsuario' => $row['user'],
                        'Correo' => $row['email'],
                        'Id' => $row['id']);
            $contador++;
        }
        echo '' . json_encode($arr) . '';
    }
    echo '';
}

function enviarCorreo($destinatario, $username, $password, $codigoverificacion, $tipoCorreo) {

    $mensaje = plantillaCorreoElectronico($username, $password, $codigoverificacion, $tipoCorreo);
    if ($tipoCorreo == 1) {
        $asunto = 'Bienvenido a Partituras Musicales!';
    }
    if ($tipoCorreo == 2) {
        $asunto = 'Recuperar Datos de Ingreso!';
    }
    if ($tipoCorreo == 3) {
        $asunto = 'Reenvio Correo Activar Cuenta!';
    }
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'To: Usuario Patituras Musicales <' . $destinatario . '>' . "\r\n";
    $headers .= 'From: Equipo Partituras Musicales <administrador@partiturasmusicales.site90.com>' . "\r\n";
    $headers .= 'Cc: eaar23@gmail.com' . "\r\n";
    $headers .= 'Bcc: musical_score@hotmail.com' . "\r\n";
    mail($destinatario, $asunto, $mensaje, $headers);
}

function recuperarDatos() {
    $email = $_POST['email_recovery'];
    $arr[0] = array('estado' => '0');
    if($email){
       $arreglo = recuperarDatosCuenta('tbl_users', $email);
       if (!$arreglo == false) {
            foreach ($arreglo as $fila) {
                $usuario = $fila['user'];
                $password = $fila['pass'];
            }
            enviarCorreo($email, $usuario, $password, null, 2);
            $arr[0] = array('estado' => '1');
        }
    }
    echo '' . json_encode($arr) . '';
}

function plantillaCorreoElectronico($username, $password, $codigoverificacion, $tipoCorreo) {
    $estilos = '<style type="text/css">

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

        </style>';
    if($tipoCorreo==1){
    $divBienvenidos = '<div class="page-header">
                        <h3>Bienvenido a Partituras Musicales!</h3>
                        <h6 style="margin-top: -20px">Gracias por registrarte y ser parte de esta Comunidad.</h6>
                       </div>';
    $mensajeBienvenida = 'Hemos construido este sitio para que music@s como usted, Profesionales &oacute; Aficionad@s puedan compartir y adquirir nuevos conocimientos a traves 
                          de la musica.';
    
    $parrafoDatosRegistro = '<p>
                             <strong>Sus datos de registro son:</strong><br>
                             Nombre de Usuario: <strong>' . $username . '</strong>  <br>
                             Contrase&ntilde;a:  <strong>' . $password . '</strong>  
                             </p> ';
    $parrafoActivacionCuenta = '<p>
                                Antes de continuar <strong>Activa tu Cuenta</strong> haciendo clic en el siguiente link: <br>
                                <a href="http://partiturasmusicales.vacau.com/funciones/confirmarCorreo.php?codigo=' . $codigoverificacion . '">Activar Cuenta</a> <br><br>
                                <strong>&iquest;El link Activar Cuenta esta bloqueado?</strong><br>
                                Ingresa el siguiente link en la barra de direcciones de tu navegador <br>
                                <a href="http://partiturasmusicales.vacau.com/funciones/confirmarCorreo.php?codigo=' . $codigoverificacion . '">http://www.partiturasmusicales.site90.com/funciones/confirmarCorreo.php?codigo=' . $codigoverificacion . '</a> <br>
                                </p>';
    }
    if($tipoCorreo==2){
       $divBienvenidos = '<div class="page-header">
                        <h3>Bienvenido de vuelta a Partituras Musicales!</h3>
                        <h6 style="margin-top: -20px">Gracias por ser parte de esta Comunidad.</h6>
                       </div>'; 
       
       $mensajeBienvenida = 'Hemos recibido una petici&oacute;n para recuperar los Datos con los cuales se ha registrado en <strong> Partituras Musicales </strong>.';
       $parrafoDatosRegistro = '<p>
                             <strong>Sus datos de registro son:</strong><br>
                             Nombre de Usuario: <strong>' . $username . '</strong>  <br>
                             Contrase&ntilde;a:  <strong>' . $password . '</strong>  
                             </p> ';
       $parrafoActivacionCuenta = '';
    }
    
    
    /*
     * Sección Armar el Mensaje de Correo Electronico
     */
    $mensaje = '<!DOCTYPE html>
    <html>
    <head>
        <title>Partituras Musicales Gratis</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">';
    $mensaje.=$estilos;
    $mensaje.='</head>
    <body>
        <div id="wrap">
            <div class="container">
                <div class="row-fluid">';
//                    <div class="page-header">
//                        <h3>Bienvenido a Partituras Musicales!</h3>
//                        <h6 style="margin-top: -20px">Gracias por registrarte y ser parte de esta Comunidad.</h6>
//                    </div>
    $mensaje.=$divBienvenidos;
    $mensaje.='</div>
                <p><strong>Hola!</strong>
                <br>';
    $mensaje.=$mensajeBienvenida;
    $mensaje.= '<br><br>';
//                <p>
//                <strong>Sus datos de registro son:</strong><br>
//                Nombre de Usuario: <strong>' . $username . '</strong>  <br>
//                Contrase&ntilde;a:  <strong>' . $password . '</strong>  
//                </p>
    $mensaje.= $parrafoDatosRegistro;
    $mensaje.='</p>';
    $mensaje.= $parrafoActivacionCuenta;
//                <p>
//                    Antes de continuar <strong>Activa tu Cuenta</strong> haciendo clic en el siguiente link: <br>
//                    <a href="http://partiturasmusicales.vacau.com/funciones/confirmarCorreo.php?codigo=' . $codigoverificacion . '">Activar Cuenta</a> <br><br>
//                    <strong>&iquest;El link Activar Cuenta esta bloqueado?</strong><br>
//                    Ingresa el siguiente link en la barra de direcciones de tu navegador <br>
//                    <a href="http://partiturasmusicales.vacau.com/funciones/confirmarCorreo.php?codigo=' . $codigoverificacion . '">http://www.partiturasmusicales.site90.com/funciones/confirmarCorreo.php?codigo=' . $codigoverificacion . '</a> <br>
//                </p>
     $mensaje.='<p>
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


function cerrarSesion() {
    session_start();
    session_destroy() or die("Error");
    $arr[0] = array('estado' => 'No');
    echo '' . json_encode($arr) . '';
}

////SE PUEDE BORRAR CUANDO SUBA SITIO NUEVO
//function cargarGeneroSalsa() {
//    include 'conectar.php';
//    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero =  'Salsa'ORDER BY id DESC LIMIT 10";
//    $result = mysql_query($sqlConsultar, $conexion);
//    $contador = 0;
//    while ($row = @mysql_fetch_array($result)) {
//        $arr[$contador] =
//                array('Titulo' => $row['titulo'],
//                    'Autor' => $row['autor'],
//                    'Id' => $row['id'],
//                    'Link' => $row['link_descarga']);
//        $contador++;
//    }
//    include 'desconectar.php';
//    echo '' . json_encode($arr) . '';
//}
//
//function cargarGeneroMerengue() {
//    include 'conectar.php';
//    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero =  'Merengue' ORDER BY id DESC LIMIT 10";
//    $result = mysql_query($sqlConsultar, $conexion);
//    $contador = 0;
//    while ($row = @mysql_fetch_array($result)) {
//        $arr[$contador] =
//                array('Titulo' => $row['titulo'],
//                    'Autor' => $row['autor'],
//                    'Id' => $row['id'],
//                    'Link' => $row['link_descarga']);
//        $contador++;
//    }
//    include 'desconectar.php';
//    echo '' . json_encode($arr) . '';
//}
//
//function cargarGeneroVariado() {
//    include 'conectar.php';
//    $sqlConsultar = "SELECT * FROM  `partituras_subidas` WHERE genero <>  'Salsa' AND genero <>  'Merengue' ORDER BY id DESC LIMIT 10";
//    $result = mysql_query($sqlConsultar, $conexion);
//    $contador = 0;
//    while ($row = @mysql_fetch_array($result)) {
//        $arr[$contador] =
//                array('Titulo' => $row['titulo'],
//                    'Autor' => $row['autor'],
//                    'Id' => $row['id'],
//                    'Link' => $row['link_descarga']);
//        $contador++;
//    }
//    include 'desconectar.php';
//    echo '' . json_encode($arr) . '';
//}
//
////FIN SE PUEDE BORRAR CUANDO SUBA SITIO NUEVO
//
//
//function cargarTodasSalsa() {
//    include 'conectar.php';
//    $sqlConsultar1 = "SELECT genero, COUNT( * ) AS contador FROM partituras_subidas WHERE genero =  'Salsa' GROUP BY genero";
//    $resultado = mysql_query($sqlConsultar1, $conexion);
//
//    $temporal;
//    while ($row = @mysql_fetch_array($resultado)) {
//        $temporal = $row['contador'];
//    }
//    $vaciarTablaTemporal = "DELETE FROM temporal_salsa";
//    mysql_query($vaciarTablaTemporal, $conexion);
//    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero =  'Salsa' ORDER BY autor ASC ";
//    $result = mysql_query($sqlConsultar, $conexion);
//    $contador = 0;
//    while ($row = @mysql_fetch_array($result)) {
//        $arr[$contador] =
//                array('Titulo' => $row['titulo'],
//                    'Autor' => $row['autor'],
//                    'Id' => $row['id'],
//                    'Link' => $row['link_descarga'],
//                    'Cantidad' => $temporal);
//        $contador++;
//        $id = $row['id'];
//        $genero = $row['genero'];
//        $titulo = $row['titulo'];
//        $autor = $row['autor'];
//        $link_descarga = $row['link_descarga'];
//        $insercionTemporal = "INSERT INTO temporal_salsa (id, genero, titulo, autor, link_descarga) values($id,'$genero','$titulo', '$autor', '$link_descarga')";
//        mysql_query($insercionTemporal, $conexion);
//    }
//    include 'desconectar.php';
//    echo '' . json_encode($arr) . '';
//}
//
//function cargarTodasMerengue() {
//    include 'conectar.php';
//    $sqlConsultar1 = "SELECT genero, COUNT( * ) AS contador FROM partituras_subidas WHERE genero =  'Merengue' GROUP BY genero";
//    $resultado = mysql_query($sqlConsultar1, $conexion);
//    echo $resultado['Salsa'];
//    $temporal;
//    while ($row = @mysql_fetch_array($resultado)) {
//        $temporal = $row['contador'];
//    }
//    $vaciarTablaTemporal = "DELETE FROM temporal_merengue";
//    mysql_query($vaciarTablaTemporal, $conexion);
//    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero =  'Merengue' ORDER BY autor ASC ";
//    $result = mysql_query($sqlConsultar, $conexion);
//    $contador = 0;
//    while ($row = @mysql_fetch_array($result)) {
//        $arr[$contador] =
//                array('Titulo' => $row['titulo'],
//                    'Autor' => $row['autor'],
//                    'Id' => $row['id'],
//                    'Link' => $row['link_descarga'],
//                    'Cantidad' => $temporal);
//        $contador++;
//        $id = $row['id'];
//        $genero = $row['genero'];
//        $titulo = $row['titulo'];
//        $autor = $row['autor'];
//        $link_descarga = $row['link_descarga'];
//        $insercionTemporal = "INSERT INTO temporal_merengue (id, genero, titulo, autor, link_descarga) values($id,'$genero','$titulo', '$autor', '$link_descarga')";
//        mysql_query($insercionTemporal, $conexion);
//    }
//    include 'desconectar.php';
//    echo '' . json_encode($arr) . '';
//}
//
//function cargarTodasVarios() {
//    include 'conectar.php';
//    $sqlConsultar1 = "SELECT genero, COUNT( * ) AS contador FROM partituras_subidas WHERE genero <>  'Salsa' AND genero <>  'Merengue'";
//    $resultado = mysql_query($sqlConsultar1, $conexion);
//
//    $temporal;
//    while ($row = @mysql_fetch_array($resultado)) {
//        $temporal = $row['contador'];
//    }
//    $vaciarTablaTemporal = "DELETE FROM temporal_varios";
//    mysql_query($vaciarTablaTemporal, $conexion);
//    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero <>  'Salsa' AND genero <>  'Merengue'  ORDER BY autor ASC ";
//    $result = mysql_query($sqlConsultar, $conexion);
//    $contador = 0;
//    while ($row = @mysql_fetch_array($result)) {
//        $arr[$contador] =
//                array('Titulo' => $row['titulo'],
//                    'Autor' => $row['autor'],
//                    'Id' => $row['id'],
//                    'Link' => $row['link_descarga'],
//                    'Cantidad' => $temporal);
//        $contador++;
//        $id = $row['id'];
//        $genero = $row['genero'];
//        $titulo = $row['titulo'];
//        $autor = $row['autor'];
//        $link_descarga = $row['link_descarga'];
//        $insercionTemporal = "INSERT INTO temporal_varios (id, genero, titulo, autor, link_descarga) values($id,'$genero','$titulo', '$autor', '$link_descarga')";
//        mysql_query($insercionTemporal, $conexion);
//    }
//    include 'desconectar.php';
//    echo '' . json_encode($arr) . '';
//}
//
//function buscarDatosTablaSalsa() {
//    $buscando = $_POST['buscando'];
//    include 'conectar.php';
//    $sql = "SELECT * FROM  `temporal_salsa` WHERE titulo LIKE  '%$buscando%' OR autor LIKE  '%$buscando%' ORDER BY autor ASC";
//    $result = mysql_query($sql, $conexion);
//    $contador = 0;
//    while ($row = @mysql_fetch_array($result)) {
//        $arr[$contador] =
//                array('Titulo' => $row['titulo'],
//                    'Autor' => $row['autor'],
//                    'Id' => $row['id'],
//                    'Link' => $row['link_descarga']);
//        $contador++;
//    }
//    include 'desconectar.php';
//    echo '' . json_encode($arr) . '';
//}
//
//function buscarDatosTablaMerengue() {
//    $buscando = $_POST['buscando'];
//    include 'conectar.php';
//    $sql = "SELECT * FROM  `temporal_merengue` WHERE titulo LIKE  '%$buscando%' OR autor LIKE  '%$buscando%' ORDER BY autor ASC";
//    $result = mysql_query($sql, $conexion);
//    $contador = 0;
//    while ($row = @mysql_fetch_array($result)) {
//        $arr[$contador] =
//                array('Titulo' => $row['titulo'],
//                    'Autor' => $row['autor'],
//                    'Id' => $row['id'],
//                    'Link' => $row['link_descarga']);
//        $contador++;
//    }
//    include 'desconectar.php';
//    echo '' . json_encode($arr) . '';
//}
//
//function buscarDatosTablaVarios() {
//    $buscando = $_POST['buscando'];
//    include 'conectar.php';
//    $sql = "SELECT * FROM  `temporal_varios` WHERE titulo LIKE  '%$buscando%' OR autor LIKE  '%$buscando%' ORDER BY autor ASC";
//    $result = mysql_query($sql, $conexion);
//    $contador = 0;
//    while ($row = @mysql_fetch_array($result)) {
//        $arr[$contador] =
//                array('Titulo' => $row['titulo'],
//                    'Autor' => $row['autor'],
//                    'Id' => $row['id'],
//                    'Link' => $row['link_descarga']);
//        $contador++;
//    }
//    include 'desconectar.php';
//    echo '' . json_encode($arr) . '';
//}

/*
 * Zona de Administracion
 */

function cargarTablaPartituras() {
    include 'conectar.php';
    $sqlConsultar = "SELECT * FROM  `partituras_subidas` ORDER BY autor ASC";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] = array
            ('Id' => $row['id'],
            'Genero' => $row['genero'],
            'Titulo' => $row['titulo'],
            'Autor' => $row['autor'],
            'Link' => $row['link_descarga'],
        );
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function borrarRegistroTablaPartituras() {
    if ($_POST['id']) {
        include 'conectar.php';
        $id = mysql_escape_String($_POST['id']);
        $sql = "DELETE FROM partituras_subidas where id='$id'";
        mysql_query($sql, $conexion);
        include 'desconectar.php';
    }
}

function buscarDatosTablaAdministracion() {
    $buscando = $_POST['buscando'];
    include 'conectar.php';
    $sql = "SELECT * FROM  `partituras_subidas` WHERE titulo LIKE  '%$buscando%' OR autor LIKE  '%$buscando%' OR genero LIKE  '%$buscando%' OR link_descarga LIKE  '%$buscando%' ORDER BY autor ASC";
    $result = mysql_query($sql, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] = array
            ('Id' => $row['id'],
            'Genero' => $row['genero'],
            'Titulo' => $row['titulo'],
            'Autor' => $row['autor'],
            'Link' => $row['link_descarga'],
        );
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function actualizarTablaPartituras() {
    if ($_POST['id']) {
        include 'conectar.php';
        $id = $_POST['id'];
        $genero = $_POST['genero'];
        $titulo = $_POST['titulo'];
        $autor = $_POST['autor'];
        $link = $_POST['link'];
        $sql = "update partituras_subidas set genero='$genero',titulo='$titulo', autor ='$autor', link_descarga='$link' where id='$id'";
        mysql_query($sql, $conexion);
        include 'desconectar.php';
    }
}

function cargarComboArtistas() {
    include 'conectar.php';

    $sqlConsultar = "SELECT distinct autor FROM partituras_subidas ORDER BY autor ASC";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;

    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] = array('Autor' => $row['autor']);
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function ingresoNuevaPartitura() {
    include 'conectar.php';
    $genero = $_POST['genero'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $link = $_POST['link'];
    $fecha = date("d-m-Y");
    $insertar = "INSERT INTO partituras_subidas (genero, titulo, autor, link_descarga, fecha_publicacion) VALUES ('$genero', '$titulo', '$autor','$link','$fecha') ";
    mysql_query($insertar, $conexion);
    include 'desconectar.php';
    echo 'Registro Ingresado Correctamente';
}

function comprobar() {
    include 'conectar.php';
    $sqlConsultar = "SELECT * FROM tbl_users where tipo_usuario='Administrador'";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    $arr;
    while ($row = @mysql_fetch_array($result)) {
        if ($row['user'] == $_POST["user"] && $row['pass'] == $_POST["pass"]) {
            session_start();
            $_SESSION["Administrador"] = "SI";
            $arr[0] = array('estado' => 'Si');
            break;
        } else {
            $arr[0] = array('estado' => 'No');
        }
    }
    echo '' . json_encode($arr) . '';
    include 'desconectar.php';
}

function comentarioNuevo() {

    include 'conectar.php';
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $fecha = $_POST['fecha'];
    $comentario = $_POST['comentario'];
    $insertar = "INSERT INTO tbl_comentarios (fecha, nombre, email, mensaje) VALUES ('$fecha', '$nombre', '$email','$comentario') ";
    mysql_query($insertar, $conexion);

    $destinatario = "eaar23@gmail.com";
    $asunto = "Comentario de Usuarios partiturasmusicales.com";
    $mensaje = "---------------------------------- \n";
    $mensaje.= "            Comentario acerca de partiturasmusicales.com               \n";
    $mensaje.= "---------------------------------- \n";
    $mensaje.= "NOMBRE:   " . $_POST['nombre'] . "\n";
    $mensaje.= "MAIL:   " . $_POST['email'] . "\n";
    $mensaje.= "FECHA:    " . date("d/m/Y") . "\n";
    $mensaje.= "HORA:     " . date("h:i:s a") . "\n";
    $mensaje.= "IP:       " . $_SERVER['REMOTE_ADDR'] . "\n\n";
    $mensaje.= "---------------------------------- \n\n";
    $mensaje.= $_POST['comentario'] . "\n\n";
    $mensaje.= "---------------------------------- \n";
    $mensaje.= "Enviado desde http://www.partiturasmusicales.site90.com \n";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

//direcci�n del remitente
//    $headers .= "From: '$nombre' <'+$email+'>\r\n";
    $correoOrigen = 'administrador@partiturasmusicales.site90.com';
    $headers = "From: " . $correoOrigen . "\r\n";
////direcci�n de respuesta, si queremos que sea distinta que la del remitente
//   $headers .= "Reply-To:  administrador@partiturasmusicales.site90.com\r\n";
//direcciones que recibi�n copia
    $headers .= "Cc: administrador@partiturasmusicales.site90.com\r\n";
    $headers .= "Cc: musical_score@hotmail.com\r\n";
    mail($destinatario, $asunto, $mensaje, $headers);
    include 'desconectar.php';
}

function cargarComentarios() {
    include 'conectar.php';
    $activa = 0;
    session_start();
    if (isset($_SESSION['Administrador']) && isset($_SESSION['Usuario'])) {
        if ($_SESSION["Administrador"] == "Si" || $_SESSION["Usuario"] == "Si") {
            $activa = 1;
        }
    }
    $nombreUsuario = "";
    $correoUsuario = "";
    $tipoUsuario = "";
    $numComentarios = 0;
    $sqlConsultar2 = "SELECT  COUNT( * ) AS numero from tbl_comentarios";
    $resultado2 = mysql_query($sqlConsultar2, $conexion);
    while ($row3 = @mysql_fetch_array($resultado2)) {
        $numComentarios = $row3['numero'];
    }
    $sqlConsultar = "SELECT * from tbl_comentarios";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $idReferencia = $row['id'];
        $sqlConsultar1 = "SELECT  COUNT( * ) AS contador FROM tbl_respuestas_comentarios WHERE referencia =  $idReferencia";
        $resultado = mysql_query($sqlConsultar1, $conexion);
        $temporal = 0;

        while ($row2 = @mysql_fetch_array($resultado)) {
            $temporal = $row2['contador'];
        }
        if ($activa == 1) {
            $nombreUsuario = $_SESSION["Nombre_Usuario"];
            $correoUsuario = $_SESSION["Correo_Usuario"];
            $tipoUsuario = $_SESSION["Tipo_Usuario"];
        }
        $arr[$contador] = array(
            'Fecha' => $row['fecha'],
            'Id' => $row['id'],
            'Nombre' => $row['nombre'],
            'Email' => $row['email'],
            'Numero' => $numComentarios,
            'NumRespuestas' => $temporal,
            'Activa' => $activa,
            'Nombre_Usuario' => $nombreUsuario,
            'Correo_Usuario' => $correoUsuario,
            'Tipo_Usuario' => $tipoUsuario,
            'Comentario' => $row['mensaje']);
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function cargarRespuestas() {
    include 'conectar.php';
    $id = $_POST['id'];
    $sqlConsultar = "SELECT * from tbl_respuestas_comentarios WHERE referencia =  $id";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] = array(
            'Fecha' => $row['fecha'],
            'Referencia' => $row['referencia'],
            'Id' => $row['id'],
            'Nombre' => $row['nombre'],
            'Email' => $row['email'],
            'Comentario' => $row['mensaje']);
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function contadorVisitas() {
    include 'conectar.php';
    $sqlConsultar = "SELECT *  from tbl_contador_visitas";
    $result = mysql_query($sqlConsultar, $conexion);
    $visitas = 0;
    while ($row = @mysql_fetch_array($result)) {
        $visitas = $row['visitas'];
    }
    $visitas++;
    $insertar = "UPDATE tbl_contador_visitas SET visitas =$visitas ";
    mysql_query($insertar, $conexion);
    include 'desconectar.php';
    $arr[0] = array(
        'visitas' => $visitas,);

    echo '' . json_encode($arr) . '';
    include 'desconectar.php';
}

function respuestaComentario() {
    include 'conectar.php';
    $id = $_POST['id'];
    $emailDestino = $_POST['emailDestino'];
    $nombreRespuesta = $_POST['nombreRespuesta'];
    $emailRespuesta = $_POST['emailRespuesta'];
    $fecha = $_POST['fecha'];
    $respuesta = $_POST['respuesta'];
    $insertar = "INSERT INTO tbl_respuestas_comentarios (referencia, fecha, nombre, email, mensaje) VALUES ($id,'$fecha', '$nombreRespuesta', '$emailRespuesta','$respuesta') ";
    mysql_query($insertar, $conexion);

    $destinatario = "eaar23@gmail.com";
    $asunto = "Respuesta a Comentario de Usuario en partiturasmusicales.site90.com";
    $mensaje = "---------------------------------- \n";
    $mensaje.= "        Respuesta a Comentario hecho en partiturasmusicales.site90.com     \n";
    $mensaje.= "---------------------------------- \n";
    $mensaje.= "NOMBRE REMITENTE:   " . $_POST['nombreRespuesta'] . "\n";
    $mensaje.= "MAIL REMITENTE:   " . $_POST['emailRespuesta'] . "\n";
    $mensaje.= "---------------------------------- \n\n";
    $mensaje.= $_POST['respuesta'] . "\n\n";
    $mensaje.= "---------------------------------- \n";
    $mensaje.= "Enviado desde http://www.partiturasmusicales.site90.com \n";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $correoOrigen = 'administrador@partiturasmusicales.site90.com';
    $headers = "From: " . $correoOrigen . "\r\n";
    $headers .= "Cc: administrador@partiturasmusicales.site90.com\r\n";
    $headers .= "Cc: musical_score@hotmail.com\r\n";
    $correoDestino = $_POST['emailDestino'];
    $headers .= "Cc: " . $correoDestino . "\r\n";
    mail($destinatario, $asunto, $mensaje, $headers);
    include 'desconectar.php';
}



?>