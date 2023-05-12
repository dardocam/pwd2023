<?php
	echo '<pre>';
    
    $arreglo_asociativo = array('Modelo'=>'vector',5,3,null,8,true,9,-1,3,6.554,4,array('fruta'=>'manzana','id'=>1));
    
    $serializeVector = serialize($arreglo_asociativo);
    
    echo "Url con el array serializado: ". " Location: 2.php?b=$serializeVector"."<br>";
    
    $encript = base64_encode($serializeVector);
    
    echo "Url con el array serializado y encriptado: ". "Location: 2.php?var1=$encript"."<br>";
    
    var_dump(base64_decode($encript)); 

	var_dump(unserialize(base64_decode($encript)));
        

    
?>