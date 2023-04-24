<?php
require_once("Db_connect.php");

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$http_method = $_SERVER['REQUEST_METHOD'];

sleep(1);

switch ($http_method) {
    case "GET":
        //echo "METHOD GET";
        //devuelve todos los productos
        //debe enviar en el query (?) de la peticion un id si desea un solo item
        //puede implementar un limite de productos recibidos
        $limit=0;
        if(isset($_GET['limit'])){
            $limit = (int)trim($_GET['limit']);
        }
        $query = "SELECT * FROM Persona";
        RequestHttpGet($conexion, $query, $limit);
        //methodGet($productos);
        break;
    case "POST":
        //echo "METHOD POST";
        //debe enviar en el body de la petición ('id','tittle','description','cost')

        break;
    case "PUT":
        //echo "METHOD PUT";
        //debe enviar en el query (?) de la petición ('id','propertie','value')
        //donde propertie es la propiedad a modificar del producto

        break;
    case "DELETE":
        //var_dump($_REQUEST);
         //debe enviar en el query (?) de la petición ('id')

        break;
}


function RequestHttpGet(object $conexion, string $query,int $limit){
    $resultado = selectQuery($conexion,$query,$limit);
    echo json_encode($resultado);
}
