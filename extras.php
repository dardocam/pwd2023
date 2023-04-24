<?php
require_once("Db_connect.php");

//un buen ejemplo de interfaz es el volante de un auto
//al mover el volante las ruedas giran no importa como
//Ejemplo para el lado del cliente
// const movieApiMovies = () => {
//     let loader = `<div class="boxLoading"></div>`;
//     document.getElementById('movieResult').innerHTML = loader;
//     fetch(movieApi_url + "movies/")
//         .then(response => response.json())
//         .then(function (data) {
//             let result = `<h2> Movies I've watched! </h2>`;
//             data.forEach((movie) => {
//                 const {id, name, year, note_imdb, genre, duration} = movie;
//                 result +=
//                     `<div>
//                         <h5> Movie ID: ${id} </h5>
//                         <ul>
//                             <li>Movie name: ${name}</li>
//                             <li>Movie year: ${year}</li>
//                             <li>Movie note on IMDB: ${note_imdb}</li>
//                             <li>Movie Genre: ${genre}</li>
//                             <li>Movie duration: ${duration}</li>
//                         </ul>
//                     </div>`;
//                 document.getElementById('movieResult').innerHTML = result;
//             })
//         })
//     };
//OTRO...
// var url = 'https://example.com/profile';
// var data = {username: 'example'};

// fetch(url, {
//   method: 'POST', // or 'PUT'
//   body: JSON.stringify(data), // data can be `string` or {object}!
//   headers:{
//     'Content-Type': 'application/json'
//   }
// }).then(res => res.json())
// .catch(error => console.error('Error:', error))
// .then(response => console.log('Success:', response));

function getAll($tabla,$limit=0){//request GET
    try {
        try {
            $conexion = new ConexionMsqli;
            $resultado = $conexion->getQuery("SELECT * FROM $tabla",$limit);
            echo json_encode($resultado);
        } catch (\Throwable $th) {
            echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
            return 0;
        }
    } catch (\Throwable $th) {
        echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
    }
}
function postAgregarAlCarrito(){//request POST (id_Persons,id_Products,Cantidad)
    try {
        if( isset($_POST['id_Persons']) && isset($_POST['id_Products']) && isset($_POST['Cantidad']) ){
            try {
                $items['id_Persons'] =  (int)trim($_POST['id_Persons']);
                $items['id_Products'] = (int)trim($_POST['id_Products']);
                $items['Cantidad'] =    (int)trim($_POST['Cantidad']); 
                $conexion = new ConexionMsqli;
                $msj = $conexion->postQuery("INSERT INTO Carrito (fk_id_Persons, fk_id_Products,Cantidad) 
                                        VALUES ($items[id_Persons],$items[id_Products],$items[Cantidad]);");
                echo $msj;
                return 0;
            } catch (\Throwable $th) {
                echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
                return 0;
            }
        }else{
            echo "Poorly formatted object";
            return 0;
        }
    } catch (\Throwable $th) {
        echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
    }
}

function putModificaItem(){//request PUT (id_Persons,id_Products,Cantidad)
    try {
        if( isset($_REQUEST['id_Persons']) && isset($_REQUEST['id_Products']) && isset($_REQUEST['Cantidad']) ){
            try {
                $items['id_Persons'] =  (int)trim($_REQUEST['id_Persons']);
                $items['id_Products'] = (int)trim($_REQUEST['id_Products']);
                $items['Cantidad'] =    (int)trim($_REQUEST['Cantidad']); 
                if($items['Cantidad']<=0){
                    die("Debe ingresar mayor a 0");
                }
                $conexion = new ConexionMsqli;
                $msj = $conexion->postQuery("UPDATE Carrito 
                                                SET Cantidad = $items[Cantidad] 
                                                    WHERE fk_id_Persons = $items[id_Persons] 
                                                        AND fk_id_Products = $items[id_Products]");
                echo $msj;
                return 0;
            } catch (\Throwable $th) {
                echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
                return 0;
            }
        }else{
            echo "Poorly formatted object";
            return 0;
        }
    } catch (\Throwable $th) {
        echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
    }
}

function deleteItem(){//request DELETE (id_Persons,id_Products)
    try {
        if( isset($_REQUEST['id_Persons']) && isset($_REQUEST['id_Products']) ){
            try {
                $items['id_Persons'] =  (int)trim($_REQUEST['id_Persons']);
                $items['id_Products'] = (int)trim($_REQUEST['id_Products']);

                $conexion = new ConexionMsqli;
                $msj = $conexion->deleteQuery("DELETE FROM Carrito 
                                                WHERE fk_id_Persons = $items[id_Persons] 
                                                    AND fk_id_Products = $items[id_Products]");
                echo $msj;
                return 0;
            } catch (\Throwable $th) {
                echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
                return 0;
            }
        }else{
            echo "Poorly formatted object";
            return 0;
        }
    } catch (\Throwable $th) {
        echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
    }
}

function postComprar(){
    try {
        if( isset($_POST['id_Persons']) ){
            try {
                $items['id_Persons'] =  (int)trim($_POST['id_Persons']);
                $items['id_Compra'] =   "'".token()."'";//genera un nuevo id_Compra cada vez

                //si hay elementos en el carrito...
                $conexion = new ConexionMsqli;
                $resultado = $conexion->getQuery("SELECT * FROM Carrito
                                                    WHERE fk_id_Persons = $items[id_Persons]");
                if($resultado){
                    $query = "INSERT INTO Compra (id_Compra, fk_id_Persons, fk_id_Products, Cantidad) 
                    VALUES ";
                    for ($i=0; $i < count($resultado); $i++) { 
                        $items['id_Products'] = (int)trim($resultado[$i]['fk_id_Products']);
                        $items['Cantidad'] =    (int)trim($resultado[$i]['Cantidad']);
                        
                        if ( $i == (count($resultado) - 1) ){//ultimo registro
                            $query .= "($items[id_Compra],"."$items[id_Persons],"
                            ."$items[id_Products],"."$items[Cantidad]);";
                        }else{
                            $query .= "($items[id_Compra],"."$items[id_Persons],"
                            ."$items[id_Products],"."$items[Cantidad]),";
                        }           
                    }
                    $conexion = new ConexionMsqli;
                    $conexion->postQuery($query);//inserta los elementos del carrito en la tabla Compras

                    $query = "";
                    for ($i=0; $i < count($resultado); $i++) { 
                        $items['id_Products'] = (int)trim($resultado[$i]['fk_id_Products']);
                        $items['id_Persons'] = (int)trim($resultado[$i]['fk_id_Persons']);
                        $query = "DELETE FROM Carrito 
                                        WHERE fk_id_Persons = $items[id_Persons] 
                                            AND fk_id_Products = $items[id_Products];";
                        $conexion = new ConexionMsqli;
                        $conexion->deleteQuery($query);//elimina los elementos del carrito
                    }
                    echo 'Agregado a la compra y eliminado del carrito';
                    return 0;
                }else{
                    echo "El carrito está vacío.";
                    return 0;
                }                                    
                
            } catch (\Throwable $th) {
                echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
                return 0;
            }
        }else{
            echo "Poorly formatted object";
            return 0;
        }
    } catch (\Throwable $th) {
        echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
    }
}

//genera un token
function token(){
    $r1= bin2hex(random_bytes(10));
    $r2= bin2hex(random_bytes(10));
    $r3= bin2hex(random_bytes(10));
    $r4= bin2hex(random_bytes(10));
    $token = $r1;
    return $token;
}


function curl(){
    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "http://192.168.0.251/pwd2023/api_Products.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "Accept: */*",
        "User-Agent: Thunder Client (https://www.thunderclient.com)"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    echo $response;
    }
}