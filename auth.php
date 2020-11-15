<?php

    require_once 'clases/auth.class.php';
    require_once 'clases/respuestas.class.php';

   /*
        Para no confundirse con la instaciacion de las clases 
        Es buena practica colocar un $_valor para hacer una 
        diferencia entre un objeto y una variable
    */
    $_auth = new auth();
    $_respuestas = new respuestas();



    
    /* Vamos a preguntarle al
    servidor que metodos está utilizando para acceder al documento*/

    # - El metodo GET es mas facil de ser interceptado

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

        $datos = array(
            "usuario" => $usuario,
            "password" => $password
        );

        // --- RECIBIR HEADERS 

        // $datos = getallheaders();
        // $datosJson = json_encode($datos, true);
        // print_r ($datosJson);
       
        $datos_json = json_encode($datos);
    //     # Recibir datos
    //     /* Más informacion de la file_get_contents('php://input') en el archivo md*/
    //     // $postbody = file_get_contents('php://input');
      

    //     #  Enviamos estos datos al manejador
        $datosArray = $_auth->login($datos_json);

    //     # Le especificamos los header
        header('Content-Type: application/json');

    //     /*
    //      le devolvemos una respuesta   
    //      Si en datos array hay un sub array llamado result que se llama error_id
        
    //     */

        if (isset($datosArray['result']['error_id'])) {
            $responseCode=$datosArray['result']['error_id'];
            http_response_code($responseCode);
        } else {
            http_response_code(200);
        }
        
       
        echo(json_encode($datosArray));
    }else{
        #Le especificamos los header
        header('Content-Type: application/json');
        $datosArray = $_respuestas->error_405();
        echo json_encode($datosArray);
    }

?>