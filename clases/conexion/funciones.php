<?php

function arrayVacio($array)
{
    

    # Verifica todos los elementos de un array para verificar si uno de esos se encuentra vacio. 
    foreach ($array as $key => $value) {
        $valor = empty($value);

        if ($valor) {
            return $valor;
            die;
        }
      
        
    }

    return $valor;

}    

?>