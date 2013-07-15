<?php 
$db_host="localhost"; 
$db_usuario="root"; 
$db_password=""; 
$db_nombre="bd_partituras_musicales"; 

$conexion = @mysql_connect($db_host, $db_usuario, $db_password) or die(mysql_error());
mysql_set_charset('utf8');
$db = @mysql_select_db($db_nombre, $conexion) or die(mysql_error()); 
?>