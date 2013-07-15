<?php

include 'conectar.php';

//obtener la lista de correos de la aplicación
//SELECT  email FROM tbl_users union select email from tbl_comentarios   

$sqlConsultar1 = "SELECT  email FROM tbl_users union select email from tbl_comentarios ";
$resultado = mysql_query($sqlConsultar1, $conexion);
$listaCorreos="";
while ($row = @mysql_fetch_array($resultado)) {
    $listaCorreos.=$row['email'] . ",";
}

echo 'asi quedo la lista de correos:  '.$listaCorreos.'<br><br>';

//$asunto = "Partituras Nuevas en partiturasmusicales.capnix.com";
//$mensaje= "Reconocimiento a Colaborador partiturasmusicales.capnix.com\n";
//$mensaje.= "---------------------------------- \n\n";
//$mensaje.= "Queremos agradecer a SalseroRomantico por habernos hecho llegar los siguientes arreglos:\n\n\n";
//$mensaje.= "* LA SALSA VIVE - TITO NIEVES\n";
//$mensaje.= "* LOCURA DE AMOR - GILBERTO SANTA ROSA\n";
//$mensaje.= "* TENGO GANAS - VICTOR MANUELLE\n\n\n";
//
//
//$mensaje.= "Enviado desde http://www.partiturasmusicales.capnix.com \n\n\n";
//$headers = "MIME-Version: 1.0\r\n";
//$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
//
//$correoOrigen = 'administrador@partiturasmusicales.capnix.com';
//$headers = "From: " . $correoOrigen . "\r\n";
//$headers .= "Bcc: ".$listaCorreos."\n";
//mail(null, $asunto, $mensaje, $headers);
echo 'Correo enviado De Agradecimiento';
include 'desconectar.php';




?>
