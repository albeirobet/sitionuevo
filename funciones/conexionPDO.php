<?php

/*
 * Función encargada de realizar la conexion a la base de datos, en este
 * caso al motor mysql, pero puede cambiarse por cualquiera de los motores
 * soportados por PDO (ver documentación).
 */

function crearConexion() {
    try {
        $conn = new PDO('mysql:host=localhost;dbname=bd_partituras_musicales;charset=utf8', 'root', 'hds2013');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
    return $conn;
}

/*
 * Funcion encargada de retornar todos los elementos de una tabla,
 * Paramteros: Nombre Tabla.
 * Retorna: Elementos solicitados.
 */

function getElementosTabla($nombreTabla) {
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT * FROM $nombreTabla");
    $stmt->execute();
    $arreglo = $stmt->fetchAll();
    return $arreglo;
}

/*
 * Funcion encargada de retornar un elementos especificos
 * Parametros: Nombre de la tabla, Nombre de la columna, Valor a ser buscado
 *             Tipo de dato, se debe especificar si la columna es de tipo 'string' o 'int'
 *             esto con el fin de prevenir injeccion sql.
 *             Nota: Para los casos en que el tipo de columna sea diferente de int siempre sera
 *             string.
 * Retorna: Elementos solicitados.
 */

function getElementosEspecificos($nombreTabla, $columna, $valor, $tipo) {
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT * FROM $nombreTabla WHERE $columna=:valor");
    if ($tipo == 'string') {
        $stmt->bindValue(':valor', $valor, PDO::PARAM_STR);
    }
    if ($tipo == 'int') {
        $stmt->bindValue(':valor', $valor, PDO::PARAM_INT);
    }
    $stmt->execute();
    $arreglo = $stmt->fetchAll();
    return $arreglo;
}

/*
 * Funcion encargada de retornar un elementos especificos
 * Parametros: Nombre de la tabla, Nombre de la columna, Valor a ser buscado, filtroAdicional (por ejemplo "ORDER BY id DESC LIMIT 10")
 *             Tipo de dato, se debe especificar si la columna es de tipo 'string' o 'int'
 *             esto con el fin de prevenir injeccion sql.
 *             Nota: Para los casos en que el tipo de columna sea diferente de int siempre sera
 *             string.
 * Retorna: Elementos solicitados.
 */

function getElementosEspecificosPorLimite($nombreTabla, $columna, $valor, $tipo, $filtroAdicional) {
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT * FROM $nombreTabla WHERE $columna=:valor $filtroAdicional");
    if ($tipo == 'string') {
        $stmt->bindValue(':valor', $valor, PDO::PARAM_STR);
    }
    if ($tipo == 'int') {
        $stmt->bindValue(':valor', $valor, PDO::PARAM_INT);
    }
    $stmt->execute();
    $arreglo = $stmt->fetchAll();
    return $arreglo;
}

/*
 * Funcion encargada de retornar el numero de registros de una Tabla
 * Parametros: Nombre de la tabla
 * Retorna: Numero de Registros.
 */

function getCantidadRegistros($nombreTabla) {
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT count(*) as cantidad FROM $nombreTabla");
    $stmt->execute();
    $arreglo = $stmt->fetchAll();
    foreach ($arreglo as $row) {
        $cantidad = $row["cantidad"];
    }
    return $cantidad;
}

/*
 * Funcion encargada de retornar elementos dentro de un limite 
 * de una tabla.
 * Parametro: Nombre Tabla, Nombre Columna a Ordenar, Orden (DESC ó ASC), Limite
 * Retorna: 
 */

function getElementosPorLimiteTabla($nombreTabla, $columna, $orden, $limite) {
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT * FROM $nombreTabla ORDER BY $columna $orden LIMIT $limite");
    $stmt->execute();
    $arreglo = $stmt->fetchAll();
    return $arreglo;
}

/*
 * Funcion encargada de crear el login para la pagina.
 * Parametros: Nombre de Usuario, Contraseña
 * Retorna: Un array con los Datos del usuario logueado si las credenciales son correctas
 *          False si ocurrio un error en la autenticación
 * 
 */

function loginUsers($nombreTabla, $colNombreUsuario, $username, $colPassword, $password) {
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT * FROM $nombreTabla WHERE $colNombreUsuario=:username AND $colPassword=:password");
//    $stmt = $conn->prepare("SELECT * FROM $nombreTabla");
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($count == 1) {
        $arreglo = $stmt->fetchAll();
        return $arreglo;
    } else {
        return false;
    }
//    $arreglo = $stmt->fetchAll();
//    return $arreglo;
}

///////////////////////////////////////////////////////////////////////////////
////////////////--------------------------------------/////////////////////////
////////////////--------------------------------------/////////////////////////
////////////////---FUNCIONES ESPECIFICAS SITIO WEB----/////////////////////////
////////////////----    PARTITURAS MUSICALES     -----/////////////////////////
////////////////--------------------------------------/////////////////////////
////////////////--------------------------------------/////////////////////////
///////////////////////////////////////////////////////////////////////////////

/*
 * 
 */
function getPartiturasPorGenero($nombreTabla, $genero, $limite, $filtro, $palabra) {
    $busquedaEspecifica = '';
    if ($palabra != '') {
        $busquedaEspecifica = "AND titulo LIKE  '%$palabra%' OR autor LIKE  '%$palabra%'";
        $filtro = 'titulo';
    }
    $fil = 'ASC';
    if ($filtro == 'puntos_positivos' || $filtro == 'puntos_negativos' || $filtro == 'contador_descargas')
        $fil = "DESC";
    if ($filtro == 'fecha_publicacion') {
        $filtro = 'id';
        $fil = "DESC";
    }
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT * FROM $nombreTabla WHERE genero =:gen  $busquedaEspecifica  ORDER BY $filtro $fil  LIMIT $limite, 5");
    $stmt->bindValue(':gen', $genero, PDO::PARAM_STR);
    $stmt->execute();
    $arreglo = $stmt->fetchAll();
    return $arreglo;
}

function getCantidadPartiturasPorGenero($nombreTabla, $genero, $palabra) {
    $busquedaEspecifica = '';
    if ($palabra != '') {
        $busquedaEspecifica = "AND titulo LIKE  '%$palabra%' OR autor LIKE  '%$palabra%'";
    }
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT count(id) as contador FROM $nombreTabla WHERE genero =:gen $busquedaEspecifica ORDER BY autor ASC");
    $stmt->bindValue(':gen', $genero, PDO::PARAM_STR);
    $stmt->execute();
    $arreglo = $stmt->fetchAll();
    foreach ($arreglo as $row) {
        $cantidad = $row["contador"];
    }
    return $cantidad;
}

function updateContadorDescargasPartitura($nombreTabla, $columna, $id) {
    $conn = crearConexion();
    $stmt = $conn->prepare("UPDATE $nombreTabla set $columna=$columna+1 where id=:id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $arreglo = getElementosEspecificos($nombreTabla, 'id', $id, 'int');
    foreach ($arreglo as $row) {
        $cantidad = $row[$columna];
    }
    return $cantidad;
}

function updateDatosLocalizacionUsuario($nombreTabla, $ip, $ciudad, $region, $pais, $username) {
    $conn = crearConexion();
    $stmt = $conn->prepare("UPDATE $nombreTabla set ip= :ip , ciudad= :ciudad, region= :region, pais= :pais WHERE user= :username");
    $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
    $stmt->bindValue(':ciudad', $ciudad, PDO::PARAM_STR);
    $stmt->bindValue(':region', $region, PDO::PARAM_STR);
    $stmt->bindValue(':pais', $pais, PDO::PARAM_STR);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
}

?>
