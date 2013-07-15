<?php

//http://localhost/partiturasmusicales/funciones/confirmarCorreo.php?codigo=1048379633


include 'conectar.php';
$codigo = $_GET['codigo'];
$total = mysql_num_rows(mysql_query("SELECT codigo_verificacion FROM tbl_users where codigo_verificacion= $codigo "));
if ($total == 1) {
    $sql = "update tbl_users set estado='Activo', codigo_verificacion=0 where codigo_verificacion= $codigo";
    mysql_query($sql, $conexion);
    echo 'Usuario Activado';
}else{
    echo 'Codigo Invalido';
}

////$numero = mysql_num_rows(mysql_query("SELECT id FROM tbl_users WHERE user='$user' or email='$email'"));
//
//if ($resultado = mysql_fetch_array($buscar)) // Si se encontro el codigo de verificacion seguimos 
//{ 
// if (!mysql_query("DELETE FROM tbl_users_confirmar WHERE codigo_verificacion ='".$codigo."' LIMIT 1")) die (mysql_error()); 
// if (!mysql_query("INSERT INTO tbl_users(tipo_usuario, nombres, user, pass, email, fecha_registro, estado) values ('".$resultado['tipo_usuario']."','".$resultado['nombres']."','".$resultado['user']."'),'".$resultado['pass']."'),'".$resultado['email']."'),'".$resultado['fecha_registro']."'), 'Activo'")) die (mysql_error()); 
//echo 'Se verifico correctamente';
//} 
//else // Si no encontro el codigo de verificacion, le damos error: 
//{ 
//echo "El codigo de verificacion no es valido."; 
//} 
//
//
//
include 'desconectar.php';
?>
