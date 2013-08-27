<?php

/*
 * Función encargada de realizar la conexion a la base de datos, en este
 * caso al motor mysql, pero puede cambiarse por cualquiera de los motores
 * soportados por PDO (ver documentación).
 */

//ini_set('display_errors', 'On');

function crearConexion() {
    try {
        $conn = new PDO('mysql:host=localhost;dbname=bd_partituras_musicales;charset=utf8', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }
    return $conn;
}

function cerrarConexion($conn) {
    $conn = null;
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
    cerrarConexion($conn);
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
    cerrarConexion($conn);
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
    cerrarConexion($conn);
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
    cerrarConexion($conn);
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
    cerrarConexion($conn);
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
    $stmt = $conn->prepare("SELECT * FROM $nombreTabla WHERE $colNombreUsuario=:username AND $colPassword=:password AND estado = 'Activo'");
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();
    cerrarConexion($conn);
    if ($count == 1) {
        $arreglo = $stmt->fetchAll();
        return $arreglo;
    } else {
        return false;
    }
}

function registerUsers($nombreTabla, $username, $email, $nombres, $password, $fechaRegistro, $ip, $ciudad, $region, $pais, $codigoverificacion) {
    $existe = userExiste($nombreTabla, $username, $email);
    if ($existe == 0) {
        
        $conn = crearConexion();
        $stmt = $conn->prepare("INSERT INTO $nombreTabla (tipo_usuario, nombres, user, pass, email, fecha_registro, estado, codigo_verificacion, ip, ciudad, region, pais) VALUES ('Usuario', :nombres, :username, :password, :email, :fechaRegistro, 'Pendiente', :codigoVerificacion, :ip, :ciudad, :region, :pais)");
        $stmt->bindValue(':nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':fechaRegistro', $fechaRegistro, PDO::PARAM_STR);
        $stmt->bindValue(':codigoVerificacion', $codigoverificacion, PDO::PARAM_INT);
        $stmt->bindValue(':ip', $ip, PDO::PARAM_STR);
        $stmt->bindValue(':ciudad', $ciudad, PDO::PARAM_STR);
        $stmt->bindValue(':region', $region, PDO::PARAM_STR);
        $stmt->bindValue(':pais', $pais, PDO::PARAM_STR);
        $stmt->execute();
        $ingreso = $stmt->rowCount();
        cerrarConexion($conn);
        return $ingreso;
    } else {
        return $existe;
    }
}

function userExiste($nombreTabla, $username, $email) {
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT count(id) as contador FROM $nombreTabla WHERE user=:username or email=:em");
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':em', $email, PDO::PARAM_STR);
    $stmt->execute();
    $arreglo = $stmt->fetchAll();
    foreach ($arreglo as $row) {
        $cantidad = $row["contador"];
    }
    cerrarConexion($conn);
    return $cantidad;
}

function confirmarCuenta($nombreTabla, $codigoVerificacion) {
    $conn = crearConexion();
    $stmt = $conn->prepare("UPDATE $nombreTabla set  estado='Activo', codigo_verificacion=0 where codigo_verificacion=:codigoVerificacion");
    $stmt->bindValue(':codigoVerificacion', $codigoVerificacion, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->rowCount();
    cerrarConexion($conn);
    return $count;
}

function recuperarDatosCuenta($nombreTabla, $email) {
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT user, pass FROM $nombreTabla WHERE email=:email AND estado = 'Activo'");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->rowCount();
    cerrarConexion($conn);
    if ($count == 1) {
        $arreglo = $stmt->fetchAll();
        return $arreglo;
    } else {
        return false;
    }
}

function datosPerfilUsuario($nombreTabla, $username) {
    $conn = crearConexion();
    $stmt = $conn->prepare("SELECT * FROM $nombreTabla WHERE user =:username");
    $stmt->bindValue(':user', $username, PDO::PARAM_STR);
    $stmt->execute();
    $arreglo = $stmt->fetchAll();
    cerrarConexion($conn);
    return $arreglo;
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
    cerrarConexion($conn);
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
    cerrarConexion($conn);
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
    cerrarConexion($conn);
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
    cerrarConexion($conn);
}

?>
