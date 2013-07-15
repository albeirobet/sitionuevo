<?php

include 'conectar.php';
$sqlConsultar1 = "SELECT  `link_descarga`  FROM  `partituras_subidas` ";
$resultado = mysql_query($sqlConsultar1, $conexion);

while ($row = @mysql_fetch_array($resultado)) {
    echo $row['link_descarga'] . "<br>";
}

include 'desconectar.php';
?>
