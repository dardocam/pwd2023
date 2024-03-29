<?php
//datos de conexion a base de Datos MYSQL
const DBM_MYSQL = 'mysql'; //'mysql'
const DBM_NAME = 'inet';
const DBM_HOST = '192.168.3.251';
const DBM_USER = 'usuario';
const DBM_PASSWORD = '123456';
const DBM_CHARSET = 'charset-utf8';

$conexion = mysqli_connect(DBM_HOST, DBM_USER, DBM_PASSWORD, DBM_NAME);


function selectQuery(object $conexion, string $query){//utiliza request GET
    $contador = 0;
    $respuesta = array();
    try {
        if (!$conexion) {
            die("Connection failed: " . mysqli_connect_error());
        }else{
            $result = mysqli_query($conexion, $query) or die('La consulta falló');
            if ($result) {
                while($fila = mysqli_fetch_assoc($result)){
                    $respuesta[]=$fila;
                    $contador++;
                }
                mysqli_close($conexion);
                return  $respuesta;
            }
        }
        mysqli_close($conexion);
    } catch (\Throwable $th) {
        return "Captured Throwable: " . $th->getMessage() . PHP_EOL;
    }
}

function genericQuery(object $conexion, string $query){//utiliza request POST, PUT, DELETE
    try {
        if (!$conexion) {
            die("Connection failed: " . mysqli_connect_error());
        }else{
            mysqli_query($conexion, $query) or die('La consulta falló');
            mysqli_close($conexion);
            return "Agregado con éxito!";
        }
    } catch (\Throwable $th) {
        return "Captured Throwable: " . $th->getMessage() . PHP_EOL;
    }
}