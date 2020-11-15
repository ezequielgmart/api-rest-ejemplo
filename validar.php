<?php
  
    require_once 'clases/auth.class.php';
    require_once 'clases/respuestas.class.php';

    $_auth = new auth();
    $_respuestas = new respuestas();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // $token = $_POST['token'];
        # Tomamos el json que enviamos a través del post 
        $token = json_decode(file_get_contents('php://input'),1);
        $json  =  json_encode($token);


    // Enviamos estos datos al manejador
       $datosArray = $_auth->verificarToken($json);

        
    // Le especificamos los header
        header('Content-Type: application/json');

        if (isset($datosArray['result']['error_id'])) {
            $responseCode=$datosArray['result']['error_id'];
            http_response_code($responseCode);
        } else {
            http_response_code(200);
        }
        echo(json_encode($datosArray));
    }


?>