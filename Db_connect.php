<?php

const DBM_MYSQL = 'mysql'; //'mysql'
const DBM_NAME='e-commerce';
const DBM_HOST='127.0.0.1';
const DBM_USER='root';
const DBM_PASSWORD='root';
const DBM_CHARSET='charset-utf8';

$conexion = mysqli_connect(DBM_HOST, DBM_USER, DBM_PASSWORD, DBM_NAME);

function selectQuery(object $conexion, string $query,string $limit=NULL){//utiliza request GET
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
                    if($limit == $contador){
                        break;
                    }
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





// class ConexionMsqli{
//     private $conexion;
//     private $response;
    
//     function __construct(){
//         $this->
//         $this->response = [];
//     }
    
//     function getConexion(){
//         return $this->conexion;
//     }
    
//     function getQuery(string $query,string $limit=NULL){//utiliza request GET
//         $contador = 0;
//         try {
//             if (!$this->conexion) {
//                 die("Connection failed: " . mysqli_connect_error());
//             }else{
//                 $result = mysqli_query($this->conexion, $query) or die('La consulta falló');
//                 if ($result) {
//                     while($fila = mysqli_fetch_assoc($result)){
//                         $this->response[]=$fila;
//                         $contador++;
//                         if($limit == $contador){
//                             break;
//                         }
//                     }
//                     mysqli_close($this->conexion);
//                     return  $this->response;
//                 }
//             }
//             mysqli_close($this->conexion);
//         } catch (\Throwable $th) {
//             return "Captured Throwable: " . $th->getMessage() . PHP_EOL;
//         }
//     }

//     function postQuery(string $query){//utiliza request POST, PUT
//         try {
//             if (!$this->conexion) {
//                 die("Connection failed: " . mysqli_connect_error());
//             }else{
//                 mysqli_query($this->conexion, $query) or die('La consulta falló');
//                 mysqli_close($this->conexion);
//                 return "Agregado con éxito!";
//             }
//         } catch (\Throwable $th) {
//             return "Captured Throwable: " . $th->getMessage() . PHP_EOL;
//         }
//     }


//     function deleteQuery(string $query){//utiliza request DELETE
//         try {
//             if (!$this->conexion) {
//                 die("Connection failed: " . mysqli_connect_error());
//             }else{
//                 mysqli_query($this->conexion, $query) or die('La consulta falló');
//                 mysqli_close($this->conexion);
//                 return 'El item ha sido eliminado';
//             }
//         } catch (\Throwable $th) {
//             return "Captured Throwable: " . $th->getMessage() . PHP_EOL;
//         }
//     }
// }

