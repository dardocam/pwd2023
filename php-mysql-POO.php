<?php

function conectarBD() {
    $servidor = "nombre_servidor";
    $usuario = "nombre_usuario";
    $contrasena = "contraseña";
    $basedatos = "nombre_basedatos";

    // Crear conexión ENFOQUE ORIENTADO A OBJETOS
    $conexion = new mysqli($servidor, $usuario, $contrasena, $basedatos);

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Error al conectar con la base de datos: " . $conexion->connect_error);
    }

    return $conexion;
}

function obtenerDatosDesdeBD() {
    $conexion = conectarBD();

    // Ejecutar consulta
    $consulta = "SELECT columna1, columna2 FROM tabla";
    $resultado = $conexion->query($consulta);

    // Verificar si la consulta fue exitosa
    if ($resultado->num_rows > 0) {
        // Crear un array asociativo con los resultados
        $datos = array();
        while ($fila = $resultado->fetch_assoc()) {
            $datos[] = $fila;
        }

        // Cerrar la conexión y devolver los datos
        $conexion->close();
        return $datos;
    } else {
        // Cerrar la conexión y devolver un array vacío si no se encontraron resultados
        $conexion->close();
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
