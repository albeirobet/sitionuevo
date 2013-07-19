<?php
require_once './conexionPDO.php';
$codigoVerificacion = $_GET['codigo'];
$activado=confirmarCuenta('tbl_users', $codigoVerificacion);
if($activado==1){
    echo 'Cuenta Confirmada';
}else{
    echo 'Hubo un error mientras se confirmaba la cuenta, por favor pida su correo de confirmacion de cuenta nuevamente, Gracias';
}
?>
