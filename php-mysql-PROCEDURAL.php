<?php

function conectarBD() {
    $servidor = "nombre_servidor";
    $usuario = "nombre_usuario";
    $contrasena = "contraseña";
    $basedatos = "nombre_basedatos";

    // Crear conexión
    $conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

    // Verificar conexión
    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    return $conexion;
}

function obtenerDatosDesdeBD() {
    $conexion = conectarBD();

    // Ejecutar consulta
    $consulta = "SELECT columna1, columna2 FROM tabla";
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si la consulta fue exitosa
    if (mysqli_num_rows($resultado) > 0) {
        // Crear un array asociativo con los resultados
        $datos = array();
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $datos[] = $fila;
        }

        // Cerrar la conexión y devolver los datos
        mysqli_close($conexion);
        return $datos;
    } else {
        // Cerrar la conexión y devolver un array vacío si no se encontraron resultados
        mysqli_close($conexion);
        return array();
    }
}

// Ejemplo de uso
$resultados = obtenerDatosDesdeBD();

// Imprimir los resultados
foreach ($resultados as $resultado) {
    echo $resultado['columna1'] . " - " . $resultado['columna2'] . "<br>";
}

?>
