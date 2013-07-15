<?php
include 'conectar.php';
//$sqlConsultar1 = "SELECT  email FROM tbl_users union select email from tbl_comentarios";

//$sqlConsultar1 = "SELECT  email FROM tbl_users where email <> 'eaar23@gmail.com' and email <> 'musical_score@hotmail.com'";


$sqlConsultar1 = "SELECT  email FROM tbl_users  where 
     email  <> 'm.diego-89@hotmail.com'
and  email  <> 'juamjito2038@hotmail.com' 
and  email  <> 'efree_29@hotmail.com' 
and  email  <> 'anthony_al_tlv@hotmail.com' 
and  email  <> 'ferpalos_89@gmail.com' 
and  email  <> 'reyleon@yahoo.com.co' 
and  email  <> 'carlos1@hotmail.com' 
and  email  <> 'selecciondehuara@hotmail.com' 
and  email  <> 'marquito_pl@hotmail.com' 
and  email  <> 'alberto_25luis@hotmail.com' 
and  email  <> 'madera.orquestan-@hotmail.com' 
and  email  <> 'rigoespa@yahoo.com' 
and  email  <> 'danileon@yahoo.com.co' 
and  email  <> 'anyinsam26@yahoo.es' 
and  email  <> 'crbrrico@hotmail.com' 
and  email  <> 'robertperezs55@hotmail.com' 
and  email  <> 'zairita19@hotmail.com' 
and  email  <> 'acercado@durman.com' 
and  email  <> 'vendotusarreglos@hotmail.com' 
and  email  <> 'elguitarrosta02@hotmail.com' 
and  email  <> 'jaco_jake@hotmail.com' 
and  email  <> 'jojaysalsa@aol.com' 
and  email  <> 'efrain_trump@hotmail.com' 
and  email  <> 'partiuras2012@hotmail.com'
and  email  <> 'paony_elangelito@hotmail.com'
and  email  <> 'remedios@yahoo.es'
and  email  <> 'artespacificklife@hotmail.com'
and  email  <> 'musivoz1145a@aol.com'
and  email  <> 'anderbides25@gmail.com'
and  email  <> 'ferpalos_89@gmail.com'
and  email  <> 'abanosanchez@gmail.com'
and  email  <> 'alguncorreo@midominio.com'
and  email  <> 'stomvimonet@yahoo.com.mx'
and  email  <> 'queteimporta@hotmail.com'
and  email  <> 'sefexo_oforafal@hotmail.com'
    union select email from tbl_comentarios";
$resultado = mysql_query($sqlConsultar1, $conexion);
$contador=0;
while ($row = @mysql_fetch_array($resultado)) {
    echo $row['email'] . ",";
    if($contador==300){
        echo '<br><br><br><br>'; 
        $contador=0;
    }
    $contador++;
}

include 'desconectar.php';
?>
