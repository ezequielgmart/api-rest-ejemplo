<?php

require_once "conexion/conexion.php";

require_once "respuestas.class.php";

class usuarios extends conexion{

    private $tabla = "usuarios";
    private $Usuario = "";
    private $Password = "";
    private $Estado = "Activo";
    private $token ="";

    public function post($json)
    {
        $_respuestas = new respuestas();

        $datos = json_decode($json, true);

        if (!isset($datos["token"])) {
            $_respuestas->error_401("No cuenta con los permisos para realizar esta accion");
        }else {
            
        }
    }
}

?>