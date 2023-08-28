<?php

require_once("dbConnect.php");
require_once("Persona.php");


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json');


$http_method = $_SERVER['REQUEST_METHOD'];

sleep(1);

switch ($http_method) {
    case "GET":
        if(isset($_GET['id'])){
            $query = "SELECT * FROM Persona WHERE id_Persona = $id";
        }else{
            $query = "SELECT * FROM Persona";
        }
        $arreglo_resultado = selectQuery($conexion, $query,10);

        foreach($arreglo_resultado as $key => $value){
            $persona = new Persona();
            $persona->Nombre = $value['Nombre'];
            $persona->Apellido = $value['Apellido'];
            $persona->Direccion = $value['Direccion'];
            $persona->Ciudad = $value['Ciudad'];
            $persona->Pais = $value['Pais'];
            $persona->setEmail($value['Email']);
            $persona->FechaNacimiento = $value['FechaNacimiento'];

            $response[]= $persona;
        }
        require_once("personaView.php");
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
