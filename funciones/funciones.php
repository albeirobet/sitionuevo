<?php

//
$metodo = $_POST['funcion'];
if ($metodo == "cargarGeneros"||$metodo == "cargarPorGenero") {
    $genero = $_POST['genero'];
    $metodo($genero);
} else {
    $metodo();
}

function getCantidadPartituras(){
  include 'conectar.php';
    $sqlConsultar = "SELECT COUNT( id ) AS Cantidad FROM partituras_subidas";
    $result = mysql_query($sqlConsultar, $conexion);
    $Cantidad = "";
    while ($row = @mysql_fetch_array($result)) {
        $Cantidad = $row['Cantidad'];
    }
    $arr[0] = array(
        'Cantidad' => $Cantidad,);
    echo '' . json_encode($arr) . '';
    include 'desconectar.php'; 
}

function cargarRecientes() {
    include 'conectar.php';
    $sqlConsultar = "SELECT * FROM partituras_subidas ORDER BY id DESC LIMIT 9";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga']);
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}


function cargarGeneros($genero) {
    include 'conectar.php';
    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero =  '$genero' ORDER BY id DESC LIMIT 10";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga']);
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function cargarPorGenero($genero){
 include 'conectar.php';
 $limite = $_POST['limite'];
 $filtro = $_POST['filtro'];
 $fil='';
 $fil = 'ASC';
 if($filtro=='fecha'||$filtro=='puntos_positivos'||$filtro=='puntos_negativos')
 $fil="DESC";    
    
    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero =   '$genero' ORDER BY $filtro $fil  LIMIT $limite, 5";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] = array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga'],
                    'Fecha' => $row['fecha_publicacion'],
                    'Contador' => $row['contador_descargas']);
        $contador++;
        $id = $row['id'];
        $genero = $row['genero'];
        $titulo = $row['titulo'];
        $autor = $row['autor'];
        $link_descarga = $row['link_descarga'];
        $insercionTemporal = "INSERT INTO temporal_salsa (id, genero, titulo, autor, link_descarga) values($id,'$genero','$titulo', '$autor', '$link_descarga')";
        mysql_query($insercionTemporal, $conexion);
    }
    include 'desconectar.php';
    array_push($arr);
    echo '' . json_encode($arr) . '';   
} 

function contadorPartiturasPorGenero() {
 include 'conectar.php';
  $genero = $_POST['genero'];
 $sqlConsultar = "SELECT count(id) Contador FROM partituras_subidas WHERE genero = '$genero' ORDER BY autor ASC";
 $result = mysql_query($sqlConsultar, $conexion);
 $total;
 while ($row = @mysql_fetch_array($result)) {
        $total = $row['Contador'];
    }
 $totalPaginas = ceil($total/5);   
 echo $totalPaginas."%".$total;
 include 'desconectar.php';
}


function cargarTodasSalsa() {
    include 'conectar.php';
    $sqlConsultar1 = "SELECT genero, COUNT( * ) AS contador FROM partituras_subidas WHERE genero =  'Salsa' GROUP BY genero";
    $resultado = mysql_query($sqlConsultar1, $conexion);

    $temporal;
    while ($row = @mysql_fetch_array($resultado)) {
        $temporal = $row['contador'];
    }
    $vaciarTablaTemporal = "DELETE FROM temporal_salsa";
    mysql_query($vaciarTablaTemporal, $conexion);
    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero =  'Salsa' ORDER BY autor ASC ";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga'],
                    'Cantidad' => $temporal);
        $contador++;
        $id = $row['id'];
        $genero = $row['genero'];
        $titulo = $row['titulo'];
        $autor = $row['autor'];
        $link_descarga = $row['link_descarga'];
        $insercionTemporal = "INSERT INTO temporal_salsa (id, genero, titulo, autor, link_descarga) values($id,'$genero','$titulo', '$autor', '$link_descarga')";
        mysql_query($insercionTemporal, $conexion);
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function cargarTodasMerengue() {
    include 'conectar.php';
    $sqlConsultar1 = "SELECT genero, COUNT( * ) AS contador FROM partituras_subidas WHERE genero =  'Merengue' GROUP BY genero";
    $resultado = mysql_query($sqlConsultar1, $conexion);
    echo $resultado['Salsa'];
    $temporal;
    while ($row = @mysql_fetch_array($resultado)) {
        $temporal = $row['contador'];
    }
    $vaciarTablaTemporal = "DELETE FROM temporal_merengue";
    mysql_query($vaciarTablaTemporal, $conexion);
    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero =  'Merengue' ORDER BY autor ASC ";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga'],
                    'Cantidad' => $temporal);
        $contador++;
        $id = $row['id'];
        $genero = $row['genero'];
        $titulo = $row['titulo'];
        $autor = $row['autor'];
        $link_descarga = $row['link_descarga'];
        $insercionTemporal = "INSERT INTO temporal_merengue (id, genero, titulo, autor, link_descarga) values($id,'$genero','$titulo', '$autor', '$link_descarga')";
        mysql_query($insercionTemporal, $conexion);
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function cargarTodasVarios() {
    include 'conectar.php';
    $sqlConsultar1 = "SELECT genero, COUNT( * ) AS contador FROM partituras_subidas WHERE genero <>  'Salsa' AND genero <>  'Merengue'";
    $resultado = mysql_query($sqlConsultar1, $conexion);

    $temporal;
    while ($row = @mysql_fetch_array($resultado)) {
        $temporal = $row['contador'];
    }
    $vaciarTablaTemporal = "DELETE FROM temporal_varios";
    mysql_query($vaciarTablaTemporal, $conexion);
    $sqlConsultar = "SELECT * FROM partituras_subidas WHERE genero <>  'Salsa' AND genero <>  'Merengue'  ORDER BY autor ASC ";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga'],
                    'Cantidad' => $temporal);
        $contador++;
        $id = $row['id'];
        $genero = $row['genero'];
        $titulo = $row['titulo'];
        $autor = $row['autor'];
        $link_descarga = $row['link_descarga'];
        $insercionTemporal = "INSERT INTO temporal_varios (id, genero, titulo, autor, link_descarga) values($id,'$genero','$titulo', '$autor', '$link_descarga')";
        mysql_query($insercionTemporal, $conexion);
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function buscarDatosTablaSalsa() {
    $buscando = $_POST['buscando'];
    include 'conectar.php';
    $sql = "SELECT * FROM  `temporal_salsa` WHERE titulo LIKE  '%$buscando%' OR autor LIKE  '%$buscando%' ORDER BY autor ASC";
    $result = mysql_query($sql, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga']);
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function buscarDatosTablaMerengue() {
    $buscando = $_POST['buscando'];
    include 'conectar.php';
    $sql = "SELECT * FROM  `temporal_merengue` WHERE titulo LIKE  '%$buscando%' OR autor LIKE  '%$buscando%' ORDER BY autor ASC";
    $result = mysql_query($sql, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga']);
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

function buscarDatosTablaVarios() {
    $buscando = $_POST['buscando'];
    include 'conectar.php';
    $sql = "SELECT * FROM  `temporal_varios` WHERE titulo LIKE  '%$buscando%' OR autor LIKE  '%$buscando%' ORDER BY autor ASC";
    $result = mysql_query($sql, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] =
                array('Titulo' => $row['titulo'],
                    'Autor' => $row['autor'],
                    'Id' => $row['id'],
                    'Link' => $row['link_descarga']);
        $contador++;
    }
    include 'desconectar.php';
    echo '' . json_encode($arr) . '';
}

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

function actualizarContadorDescargas() {
    if ($_POST['id']) {
        include 'conectar.php';
        $id = $_POST['id'];
        $sql = "update partituras_subidas set contador_descargas=contador_descargas+1 where id=$id";
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
    $fecha = date("d-m-Y H:i:s");
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
    $mensaje.= "Enviado desde http://www.partiturasmusicales.capnix.com \n";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

//direcci�n del remitente
//    $headers .= "From: '$nombre' <'+$email+'>\r\n";
    $correoOrigen = 'administrador@partiturasmusicales.capnix.com';
    $headers = "From: " . $correoOrigen . "\r\n";
////direcci�n de respuesta, si queremos que sea distinta que la del remitente
//   $headers .= "Reply-To:  administrador@partiturasmusicales.capnix.com\r\n";
//direcciones que recibi�n copia
    $headers .= "Cc: administrador@partiturasmusicales.capnix.com\r\n";
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
    $asunto = "Respuesta a Comentario de Usuario en partiturasmusicales.capnix.com";
    $mensaje = "---------------------------------- \n";
    $mensaje.= "        Respuesta a Comentario hecho en partiturasmusicales.capnix.com     \n";
    $mensaje.= "---------------------------------- \n";
    $mensaje.= "NOMBRE REMITENTE:   " . $_POST['nombreRespuesta'] . "\n";
    $mensaje.= "MAIL REMITENTE:   " . $_POST['emailRespuesta'] . "\n";
    $mensaje.= "---------------------------------- \n\n";
    $mensaje.= $_POST['respuesta'] . "\n\n";
    $mensaje.= "---------------------------------- \n";
    $mensaje.= "Enviado desde http://www.partiturasmusicales.capnix.com \n";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $correoOrigen = 'administrador@partiturasmusicales.capnix.com';
    $headers = "From: " . $correoOrigen . "\r\n";
    $headers .= "Cc: administrador@partiturasmusicales.capnix.com\r\n";
    $headers .= "Cc: musical_score@hotmail.com\r\n";
    $correoDestino = $_POST['emailDestino'];
    $headers .= "Cc: " . $correoDestino . "\r\n";
    mail($destinatario, $asunto, $mensaje, $headers);
    include 'desconectar.php';
}

function topDescargas() {
    include 'conectar.php';
    $sqlConsultar = "SELECT *  FROM  partituras_subidas  ORDER BY  contador_descargas DESC  LIMIT 0 , 10";
    $result = mysql_query($sqlConsultar, $conexion);
    $contador = 0;
    while ($row = @mysql_fetch_array($result)) {
        $arr[$contador] = array(
            'Id' => $row['id'],
            'Titulo' => $row['titulo'],
            'Autor' => $row['autor'],
            'Link' => $row['link_descarga'],
            'Contador' => $row['contador_descargas']);
        $contador++;
    }

    echo '' . json_encode($arr) . '';
    include 'desconectar.php';
}

function registroUsuarios() {
    include 'conectar.php';
    $user = $_POST['username'];
    $email = $_POST['email_register'];
    $nombres = $_POST['nombres'];
    $password = $_POST['password'];
    $fechaRegistro = date("Y-m-d");
    $codigoverificacion = rand(0000000000, 9999999999);
    $total = mysql_num_rows(mysql_query("SELECT id FROM tbl_users WHERE user='$user' or email='$email'"));
    if ($total == 0) {
        $insertar = "INSERT INTO tbl_users (tipo_usuario, nombres, user, pass, email, fecha_registro, estado, codigo_verificacion) VALUES ('Usuario', '$nombres', '$user','$password','$email', '$fechaRegistro', 'Activo',$codigoverificacion) ";
        mysql_query($insertar, $conexion);

        $destinatario = $_POST['email_register'];
        $asunto = "Bienvenido a Partituras Musicales";
        $mensaje = "---------------------------------- \n";
        $mensaje.= "Gracias por ser parte de nuestra comunidad, esperamos que nuestro trabajo sea de utilidad para ti.";
        $mensaje.= "No olvides agregarnos a tus contactos en tu cuenta de correo electronico.\n";
        $mensaje.= "Bienvenido.\n\n";
        // $mensaje.= "http://www.partiturasmusicales.capnix.com/funciones/confirmarCorreo.php?codigo=" . $codigoverificacion . " \n\n\n";
        $mensaje.= "---------------------------------- \n";
        $mensaje.= "Enviado desde http://www.partiturasmusicales.capnix.com \n\n\n";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $correoOrigen = 'administrador@partiturasmusicales.capnix.com';
        $headers = "From: " . $correoOrigen . "\r\n";
        $correoDestino = 'eaar23@gmail.com';
        $headers .= "Cc: " . $correoDestino . "\r\n";
        mail($destinatario, $asunto, $mensaje, $headers);
        session_start();
        $_SESSION["Usuario"] = "Si";
        $_SESSION["Administrador"] = "No";
        $_SESSION["Nombre_Usuario"] = $_POST['username'];
        $_SESSION["Correo_Usuario"] = $_POST['email_register'];
        $_SESSION["Tipo_Usuario"] = 'Usuario';
        $arr[0] = array('estado' => '1');
        echo '' . json_encode($arr) . '';
    } else {
        $arr[0] = array('estado' => '0');
        echo '' . json_encode($arr) . '';
    }



    include 'desconectar.php';
}

function loginUsuarios() {
    include 'conectar.php';
    $tipo_usuario = $_POST["username_login"];
    if (!empty($_POST["username_login"]) && !empty($_POST["password_login"])) {
        $tipo_separado = explode("#", $tipo_usuario);
        $tipo_final = end($tipo_separado);
        $nombre_Usuario = $tipo_separado[0];
        $arr[0] = array('estado' => '0');
        if ($tipo_final == 'administrador') {
            $sqlConsultar = "SELECT * FROM tbl_users where tipo_usuario='Administrador'";
            $result = mysql_query($sqlConsultar, $conexion);
            while ($row = @mysql_fetch_array($result)) {
                if ($row['user'] == $nombre_Usuario && $row['pass'] == $_POST["password_login"]) {
                    session_start();
                    $_SESSION["Administrador"] = "Si";
                    $_SESSION["Usuario"] = "No";
                    $_SESSION["Nombre_Usuario"] = $nombre_Usuario;
                    $_SESSION["Correo_Usuario"] = $row['email'];
                    $_SESSION["Tipo_Usuario"] = $row['tipo_usuario'];
                    $arr[0] = array('estado' => '2');
                    break;
                }
            }
        } else {
            $sqlConsultar1 = "SELECT * FROM tbl_users where tipo_usuario='Usuario'";
            $result1 = mysql_query($sqlConsultar1, $conexion);
            while ($row1 = @mysql_fetch_array($result1)) {
                if ($row1['user'] == $_POST["username_login"] && $row1['pass'] == $_POST["password_login"]) {
                    session_start();
                    $_SESSION["Usuario"] = "Si";
                    $_SESSION["Administrador"] = "No";
                    $_SESSION["Nombre_Usuario"] = $_POST['username_login'];
                    $_SESSION["Correo_Usuario"] = $row1['email'];
                    $_SESSION["Tipo_Usuario"] = $row1['tipo_usuario'];
                    $arr[0] = array('estado' => '1');
                    break;
                }
            }
        }
    } else {
        $arr[0] = array('estado' => '0');
    }


    echo '' . json_encode($arr) . '';
    include 'desconectar.php';
}

function recuperarDatos() {
    include 'conectar.php';
    $email = $_POST['email_recovery'];
    $total = mysql_num_rows(mysql_query("SELECT id FROM tbl_users WHERE email='$email'"));
    if ($total == 1) {
        $sqlConsultar = "SELECT user, pass FROM tbl_users WHERE email='$email'";
        $result = mysql_query($sqlConsultar, $conexion);
        $usuario="";
        $contraseña="";
        while ($row = @mysql_fetch_array($result)) {
            $usuario= $row['user'];
            $contraseña=$row['pass'];
        }
        $destinatario = $_POST['email_recovery'];
        $asunto = "Datos de Ingreso Partiruas Musicales";
        $mensaje = "---------------------------------- \n";
        $mensaje.= "Has solicitado el reenvio de tus datos de Ingreso a Partituras Musicales\n\n";
        $mensaje.= "Usuario:           ".$usuario."\n";
        $mensaje.= "Contraseña:        ".$contraseña."\n";
        $mensaje.= "---------------------------------- \n";
        $mensaje.= "Enviado desde http://www.partiturasmusicales.capnix.com \n\n\n";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $correoOrigen = 'administrador@partiturasmusicales.capnix.com';
        $headers = "From: " . $correoOrigen . "\r\n";
        $correoDestino = 'eaar23@gmail.com';
        $headers .= "Cc: " . $correoDestino . "\r\n";
        mail($destinatario, $asunto, $mensaje, $headers);       
        $arr[0] = array('estado' => '1');
        echo '' . json_encode($arr) . '';
    } else {
        $arr[0] = array('estado' => '0');
        echo '' . json_encode($arr) . '';
    }

    include 'desconectar.php';
}

function cerrarSesion() {
    session_start();
    //unset( $_SESSION["carro"] );  para eliminar una sesion en especifico
    //$_SESSION["carro"] = "";  para dejarla en blanco 
    session_destroy() or die("Error");
    $arr[0] = array('estado' => 'No');
    echo '' . json_encode($arr) . '';
}

?>