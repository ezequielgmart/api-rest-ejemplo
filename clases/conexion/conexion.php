<?php
    require_once ("funciones.php");
    // Buena practica : Al archivo que contendrá la clase, ponle el mismo nombre

        
    class conexion {
        private $server;
        private $user;
        private $password;
        private $database;
        private $port;
        private $conexion;
        
        /*
            Para obtener el valor que contendran los atributos crearemos una funcion para extraer esos datos del archivo config. 
        */


         function __construct() {
             # Guardo en esta variable los datos que me traigo del archivo config. 
            $listaDatos = $this->datosConexion();
            foreach ($listaDatos as $key => $value) {
                $this->server = $value['server'];
                $this->user = $value['user'];
                $this->password = $value['password'];
                $this->database = $value['database'];
                $this->port = $value['port'];
                
            }

            $this->conexion = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);

            if ($this->conexion->connect_errno) {
                echo "algo falló con la conexion";
                die();
            }
        }


       
        private function datosConexion(){
             //--- dirname recibe como parametro la direccion de un archivo
            $direccion = dirname(__FILE__);

            // file_get_contents guarda todo el contenido de un archivo y lo devuelve
            $jsonData = file_get_contents($direccion . "/" . "config");
            return json_decode($jsonData, true);
        }

        private function convertirUTF8($array){
            array_walk_recursive($array, function(&$item,$key){
                if (!mb_detect_encoding($item,'utf-8', true)) {
                   $item = utf8_encode($item);
                } 
                
            });
            return $array;
        }

        public function obtenerDatos($consulta){
            $resultados = $this->conexion->query($consulta);
            $array = array();
            foreach ($resultados as $key ) {
                $array[] = $key;

            }
            return $this->convertirUTF8($array);
        }

        public function nonQuery($consulta){
            $resultado = $this->conexion->query($consulta);
            return $this->conexion->affected_rows;
        }

        public function nonQueryId($consulta){
            $resultado = $this->conexion->query($consulta);
            $filas =  $this->conexion->affected_rows;
            if ($filas >= 1) {
                return $this->conexion->insert_id;
            } else {
                return 0;
            }
            
        }

        protected function encriptar($password){
            return md5($password);

        }

    }


?>