<?php
    require_once "clases/respuestas.class.php";
    require_once "clases/pacientes.class.php";

    $_respuestas = new respuestas();
    $_pacientes = new pacientes();
    

    // if ($_SERVER["REQUEST_METHOD"] == 'GET'){
    //     $headers = getallheaders();
    //     // print_r($headers);
    //     if (isset($_GET["page"])) {
    //         $pagina = $_GET["page"];
    //         $listaPacientes = $_pacientes->listaPacientes($pagina);
    //         header("Content-Type:application/json");

    //         echo json_encode($listaPacientes);
    //         http_response_code(200);
    //     }else if (isset($_GET["id"])) {
    //        $pacienteId = $_GET["id"];
    //         $datosPaciente = $_pacientes->obtenerPaciente($pacienteId);
    //         header("Content-Type:application/json");
    //         echo json_encode($datosPaciente);
    //         http_response_code(200);
    //     }


    // }
    if ($_SERVER["REQUEST_METHOD"] == 'GET'){
        # Obtenemos los HEADERS de la peticion
        $headers = getallheaders();
        $headersJson = json_encode($headers);
        # convertimos en un array el resultado que nos regrese la 
        $resultado = $_pacientes->get($headersJson);

        echo json_encode($resultado);
        header("Content-Type:application/json");

        // $datosArray = $_pacientes->post($headers);
        // if (isset($_GET["page"])) {
        //     $pagina = $_GET["page"];
        //     $listaPacientes = $_pacientes->listaPacientes($pagina);
        //     header("Content-Type:application/json");

        //     echo json_encode($listaPacientes);
        //     http_response_code(200);
        // }else if (isset($_GET["id"])) {
        //    $pacienteId = $_GET["id"];
        //     $datosPaciente = $_pacientes->obtenerPaciente($pacienteId);
        //     header("Content-Type:application/json");
        //     echo json_encode($datosPaciente);
        //     http_response_code(200);
        // }


    } else if ($_SERVER["REQUEST_METHOD"] == 'POST'){
        # Lo que recibimos en el POST
        // $postBody = file_get_contents("php://input");

        // $_POST['nombre'];
        // $_POST['dni'];
        // $_POST['direccion'];
        // $_POST['correo'];
        // $_POST['fechaNacimiento'];
        // $_POST['telefono'];
        // $_POST['genero'];
        // $_POST['codigoPostal'];

        $formdata = array(
            "nombre" => $_POST['nombre'],
            "dni" => $_POST['dni'],
            "direccion" => $_POST['direccion'],
            "correo" => $_POST['correo'],
            "fechaNacimiento" => $_POST['fechaNacimiento'],
            "telefono" => $_POST['telefono'],
            "genero" => $_POST['genero'],
            "codigoPostal" => $_POST['codigoPostal']
        );

        $headers = getallheaders();
        $postBody = json_encode($formdata);
        $headersJson = json_encode($headers);

        # Enviamos eso al manejador, en este caso será un metodo en la clase pacientes
        $datosArray = $_pacientes->post($postBody,$headersJson);

         #Le especificamos los header
         header('Content-Type: application/json');

         # le devolvemos una respuesta   
             # Si en datos array hay un sub array llamado result que se llama error_id
         if (isset($datosArray['result']['error_id'])) {
             $responseCode=$datosArray['result']['error_id'];
             http_response_code($responseCode);
         } else {
             http_response_code(200);
         }
         
         echo(json_encode($datosArray));
    }else if ($_SERVER["REQUEST_METHOD"] == 'PUT'){
        # ésta parte es casi igual siempre. 
        $postBody = file_get_contents("php://input");

        # enviamos datos al Manejador 
        $datosArray = $_pacientes->put($postBody);
        
        // #Le especificamos los header
         header('Content-Type: application/json');

        // # le devolvemos una respuesta   
            # Si en datos array hay un sub array llamado result que se llama error_id
         if (isset($datosArray['result']['error_id'])) {
             $responseCode=$datosArray['result']['error_id'];
             http_response_code($responseCode);
         } else {
            http_response_code(200);
        }
        
        echo(json_encode($datosArray));

    }else if ($_SERVER["REQUEST_METHOD"] == 'DELETE'){
         # ésta parte es casi igual siempre. 
         $postBody = file_get_contents("php://input");

         # enviamos datos al Manejador 
         $datosArray = $_pacientes->delete($postBody);
         
         // #Le especificamos los header
          header('Content-Type: application/json');
 
         // # le devolvemos una respuesta   
             # Si en datos array hay un sub array llamado result que se llama error_id
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