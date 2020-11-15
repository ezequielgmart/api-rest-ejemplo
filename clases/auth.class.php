<?php

    require_once "conexion/conexion.php";
    require_once "respuestas.class.php";

    class auth extends conexion{

        # Metodo login
        public function login($json){
            $_respuestas = new respuestas();

            # El JSON que le enviamos lo convertimos a un array asociativo (Para eso es el True)
            $datos = json_decode($json, true);
        
            # Si no existe un campo usuario o contraseña en esa peticion entonces:
                # Muestrame el error 400
            if (!isset($datos['usuario']) || !isset($datos['password'])) {
               return $_respuestas->error_400("Faltan datos");
            }else{
                # En caso de que si los envie, crea dos variables y asignales su valor correspondiente
                $usuario = $datos['usuario'];
                $password = $datos['password'];
                $password = parent::encriptar($password);
                $datos = $this->obtenerDatosUsuario($usuario);
                
                 if ($datos) {
                     # Si existe el usuario
                         # Verificar si contraseña existe
                         if ($password == $datos[0]['Password']) {
                            
                                # verificar que el usuario está activo
                                if ($datos[0]['Estado'] == "Activo") {
                                    # Crear el Token
                                    $verificar = $this->insertarToken($datos[0]['UsuarioId']);
                                        if ($verificar) {
                                            # Si se guardó: 
                                            /*
                                                Guardar el token en el elemento token del array $resultado. 
                                            */
                                            $resultado = $_respuestas->response;
                                            $resultado["result"] = array(
                                                "token" => $verificar
                                            );
                                            # Devuelve el array $resultado
                                            return $resultado;
                                        }else {
                                            # Error al guardar Token
                                            return $_respuestas->error_500("Error interno no hemos podido guardar");
                                        }
                                }else{
                                    # Sí el Usuario está inactivo
                                    return $_respuestas->error_201();

                                }
                         }else {
                             # Si la contraseña está incorrecta
                             return $_respuestas->error_202();
                         }

                        
                 }else{
                      #  No existe el usuario
                     return $_respuestas->error_203();
                 }

            }
        }

        public function verificarToken($json){
            $_respuestas = new respuestas();

            # El JSON que le enviamos lo convertimos a un array asociativo (Para eso es el True)
            $datos = json_decode($json, true);

            $token = $datos['token'];

            // echo json_encode($verificar = $this->validarToken($token));
            $verificar = $this->validarToken($token);

            if ($verificar == 0) {
                return $verificacion = array(
                    "codigo" => '400',
                     "concepto" => 'Token invalido',
                     "mensaje" => 'El token es invalido'
                );
            }else {
                return $verificacion = array(
                    "codigo" => '200',
                     "concepto" => 'Token valido',
                     "mensaje" => 'El token ha sido validado correctamente'
                );
            }


        }
        public function desactivarToken($json){
            $_respuestas = new respuestas();

            # El JSON que le enviamos lo convertimos a un array asociativo (Para eso es el True)
            $datos = json_decode($json, true);

            $token = $datos['token'];

            // echo json_encode($verificar = $this->validarToken($token));
            $verificar = $this->actualizarToken($token);

            if ($verificar) {
                // Si es True
                return $verificacion = array(
                    "codigo" => '200',
                     "concepto" => 'Token desactivado correctamente',
                     "mensaje" => 'El token ha sido desactivado correctamente'
                );
            }else {
                // Si es False
                
                return $verificacion = array(
                    "codigo" => '400',
                     "concepto" => 'El token no se ha podido desactivar',
                     "mensaje" => 'No se pudo desactivar el token.'
                );
            }


        }

        # Validamos el correo a ver si existe
        private function obtenerDatosUsuario($correo){
            $query ="SELECT UsuarioId,Password,Estado FROM usuarios WHERE Usuario = '$correo'";
            
            #obtendremos un metodo del padre
            $datos = parent::obtenerDatos($query);

            # Si el primer campo del array o sea el cero existe el campo usuarioId entonces
                #Retorname el array $datos
            if (isset($datos[0]['UsuarioId'])) {
                return $datos;
            }else{
                #En caso contrario retorna un false
                return 0;
            }
        }

        private function insertarToken($usuarioId){
            $value = true;
            // Dos combinaciones de funciones en php

            # Colocamos la variable, porque la funcion openssl no acepta algo que no sea una variable
            $token = bin2hex(openssl_random_pseudo_bytes(16,$value));
            $date = date("Y-m-d h:i");
            $estado = "Activo";

            $query = "INSERT INTO usuarios_token (UsuarioId, Token,Estado, Fecha)VALUES('$usuarioId','$token','$estado','$date') ";
            $verificar = parent::nonQuery($query);
            if ($verificar) {
                return $token;
            } else {
               return 0;
            }
            
        }

        private function actualizarToken($token){
            
            $query = "UPDATE usuarios_token SET Estado='Desactivado' WHERE Token='$token'";
            $verificar = parent::nonQuery($query);
            if ($verificar) {
                return $verificar;
            } else {
               return 0;
            }
            
        }
        private function validarToken($token){
            $query = "SELECT UsuarioId FROM usuarios_token WHERE Token='$token' AND Estado='Activo'";
            $verificar = parent::obtenerDatos($query);
            if($verificar){
                return $verificar;
            }else{
                return 0;
            }   
        }
    }

?>