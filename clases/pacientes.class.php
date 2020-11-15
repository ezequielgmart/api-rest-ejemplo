<?php

    require_once "conexion/conexion.php";

    require_once "respuestas.class.php";

    class pacientes extends conexion{
        /*
            Le pasamos una pagina porque en caso de que la lista de pacientes sea mayor a cien, solo lo 
            traga de 100 en 100 algo asi como una paginacion. 
        */
        private $tabla = "pacientes";
        private $pacienteid = "";
        private $dni = "";
        private $nombre = "";
        private $direccion = "";
        private $codigoPostal = "";
        private $genero ="";
        private $telefono ="";
        private $fechaNacimiento ="0000-00-00";
        private $correo = "";
        private $token ="";
        // private $queryGetPacientes = 

        public function get($json){
           
            $_respuestas = new respuestas();
            # true para que lo haga un array asoc
            $datos = json_decode($json,true);

            # Verificar que el array con los datos del header contenga un campo con un token
            if (!isset($datos["token"])) {
                # Si no hay token mandar un error
                return $_respuestas->error_401();
            }else {
                # verificar el token
                $this->token = $datos["token"];
                $arrayToken = $this->buscarToken();

                # Si se puede verificar que el token es correcto
                if ($arrayToken) {
                    $query = "SELECT PacienteId, Nombre, DNI, Telefono,Correo FROM " . $this->tabla . " ORDER BY PacienteId DESC";
                    $datos = parent::obtenerDatos($query);
                    return $datos;
                } else {
                    # Si el token no es correcto
                    return $_respuestas->error_401("El token que envio es invalido o ha caducado");
                }
                
                

            }
        }
        public function obtenerPaciente($id){
            $query = "SELECT * FROM ".$this->tabla." WHERE PacienteId = '$id'";
            return parent::obtenerDatos($query);

        }

        public function post($json,$headers){
            $_respuestas = new respuestas();
            # true para que lo haga un array asoc
            $datos = json_decode($json,true);

            $headers = json_decode($headers,true);

            # Validar que el usuario que solicita los datos tiene un token valido para visualizarlos. 
            if (!isset($headers["token"])) {
                return $_respuestas->error_401();
            }else {
                $this->token = $headers["token"];
                $arrayToken = $this->buscarToken();
                if ($arrayToken) {
                        # validar que se encuentren los datos requeridos
                        # Si el array $datos no contiene ninguno de estos campos entonces devuelve un error.
                        if (!isset($datos['nombre']) || !isset($datos['dni']) || !isset($datos['correo'])) {
                            return $_respuestas->error_400();
                        } else {
                            # validar que todos los campos estén llenos
                            if (arrayVacio($datos)) {
                                    return $_respuestas->error_401("Rellene todos los campos");

                                } else {
                                    # Validar que el campo "codigo postal" sea un string de numeros
                                    if (is_numeric($datos["codigoPostal"])) {
                                            $this->nombre = $datos['nombre'];
                                            $this->dni = $datos['dni'];
                                            $this->correo = $datos['correo'];
                
                                            if (isset($datos["telefono"])) { $this->telefono = $datos['telefono'];}
                                            if (isset($datos["direccion"])) { $this->direccion = $datos['direccion'];}
                                            if (isset($datos["codigoPostal"])) { $this->codigoPostal = $datos['codigoPostal'];}
                                            if (isset($datos["genero"])) { $this->genero = $datos['genero'];}
                                            if (isset($datos["fechaNacimiento"])) { $this->fechaNacimiento = $datos['fechaNacimiento'];}
                                            $resp = $this->insertarPaciente();
                                        
                                            if ($resp) {
                                                $respuesta = $_respuestas->response;
                                                $respuesta["result"] = array(
                                                "pacienteId" => $resp
                                                );
                                                
                                                return $respuesta;

                                            }else {

                                                return $_respuestas->error_500();
                                            
                                            }
                                    } else {
                                        return $_respuestas->error_401("El campo codigo postal debe de ser un entero");
                                    }
                                    
                                    

                            }
                            
                           
                        }
                }else {
                    return $_respuestas->error_401("El token que envio es invalido o ha caducado");
                }  
            }

        }

        public function put($json){
            $_respuestas = new respuestas();
            # true para que lo haga un array asoc
            $datos = json_decode($json,true);

            if (!isset($datos["token"])) {
                return $_respuestas->error_401();
            }else {
            # validar que se encuentren los datos requeridos
                if (!isset($datos['pacienteId'])) {
                return $_respuestas->error_400();
                } else {
                    $this->pacienteid = $datos["pacienteId"];
                if (isset($datos["nombre"])) { $this->nombre = $datos['nombre'];}
                if (isset($datos["dni"])) { $this->dni = $datos['dni'];}
                if (isset($datos["correo"])) { $this->correo = $datos['correo'];}
                    if (isset($datos["telefono"])) { $this->telefono = $datos['telefono'];}
                if (isset($datos["direccion"])) { $this->direccion = $datos['direccion'];}
                if (isset($datos["codigoPostal"])) { $this->codigoPostal = $datos['codigoPostal'];}
                if (isset($datos["genero"])) { $this->genero = $datos['genero'];}
                if (isset($datos["fechaNacimiento"])) { $this->fechaNacimiento = $datos['fechaNacimiento'];}
                    $resp = $this->modificarPaciente();

                        return $resp;
                        if ($resp) {
                            $respuesta = $_respuestas->response;
                            $respuesta["result"] = array(
                            "pacienteId" => $this->pacienteId
                            );
                            return $respuesta;
                        }else {
                            return $_respuestas->error_500();
                        }
                    }
            
                # code...
            }

        }

        private function insertarPaciente(){
            $query = "INSERT INTO " . $this->tabla . " (DNI, Nombre, Direccion, CodigoPostal, Telefono, Genero, FechaNacimiento, Correo)
            VALUES
            ('" . $this->dni . "','".$this->nombre ."','".$this->direccion ."','".$this->codigoPostal."','".$this->telefono."','".$this->genero."','".$this->fechaNacimiento."','".$this->correo."')";
     
            $resp = parent::nonQuery($query);

            if ($resp >=1) {
                return $resp;
            }else{
                return 0;
            }
        }

        private function modificarPaciente(){
            $query = "UPDATE " . $this->tabla . " SET Nombre ='" . $this->nombre . "',Direccion = '" . $this->direccion . "', DNI = '" . $this->dni . "', CodigoPostal = '" .
            $this->codigoPostal . "', Telefono = '" . $this->telefono . "', Genero = '" . $this->genero . "', FechaNacimiento = '" . $this->fechaNacimiento . "', Correo = '" . $this->correo ."' WHERE PacienteId = '" . $this->pacienteid . "'"; 
            
             $resp = parent::nonQuery($query);


             if($resp >= 1){
                  return $resp;
             }else{
                 return 0;
            }
        }

        public function delete($json){
            $_respuestas = new respuestas();
            # true para que lo haga un array asoc
            $datos = json_decode($json,true);

            if (!isset($datos["token"])) {
                return $_respuestas->error_401();
            }else {
                # validar que se encuentren los datos requeridos
                if (!isset($datos['pacienteId'])) {
                return $_respuestas->error_400();
                } else {
                    $this->pacienteid = $datos["pacienteId"];
                    $resp = $this->eliminarPaciente();

                    return $resp;
                    if ($resp) {
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                        "pacienteId" => $this->pacienteId
                        );
                        return $respuesta;
                    }else {
                        return $_respuestas->error_500();
                    }
                }
            }

        }

        private function eliminarPaciente(){
            $query = "DELETE FROM " . $this->tabla ." WHERE PacienteId ='". $this->pacienteid ."'";
            $resp = parent::nonQuery($query);

            # La funcion nonQuery devuelve numero de filas afectadas.            
            if ($resp >= 1) {
                return $resp;
            } else {
               return 0;
            }
            
        }

        private function buscarToken(){
            # no recibe parametro porque lo enviaremos por el atributo de la clase
            $query = "SELECT TokenId,UsuarioId,Estado FROM usuarios_token WHERE Token='" . $this->token . "' AND Estado='Activo'";
            $resp = parent::obtenerDatos($query);
            if ($resp) {
                return $resp;
            }else {
                return 0;
            }
        }

        private function actualizarToken($tokenId){
            $date = date("Y-m-d H:i");
            $query = "UPDATE usuarios_token SET Fecha = '$date' WHERE TokenId ='$tokenId'";
            $resp = parent::nonQuery($query);
            if ($resp >=1) {
                return $resp;
            }else {
                return 0;
            }
        }
    }

?>