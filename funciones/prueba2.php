<?php 

//var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));
//$arreglo = var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));


$arreglo = file_get_contents('http://www.geoplugin.net/php.gp?ip=186.87.185.22');
//$arreglo[0].geoplugin_countryName;


echo $arreglo;

?> 