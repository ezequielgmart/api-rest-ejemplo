<?php

    class respuestas
    {
        // las respuestas seran un array 

        public $response = [
            "status" => "ok",
            "result" => array()
        ];


        public function error_405(){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => "405",
                'error_mg' => 'Metodo no permitido'
            );
            return $this->response;
        }

        public function error_200($valor = 'Datos incorrectos'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => "200",
                'error_mg' =>  $valor
            );
            return $this->response;
        }

        public function error_201($valor = 'Usuario incorrecto'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => "201",
                'error_mg' =>  $valor
            );
            return $this->response;
        }
        public function error_202($valor = 'Password invalida'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => "202",
                'error_mg' =>  $valor
            );
            return $this->response;
        }
        public function error_203($valor = 'El usuario no existe'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => "203",
                'error_mg' =>  $valor
            );
            return $this->response;
        }
        public function error_400(){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => "400",
                'error_mg' =>  "Datos enviados incompletos"
            );
            return $this->response;
        }

        public function error_500($valor = 'Error interno del servidor'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => "500",
                'error_mg' =>  $valor
            );
            return $this->response;
        }

        public function error_501($valor = 'No se pudo guardar'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => "501",
                'error_mg' =>  $valor
            );
            return $this->response;
        }

        public function error_401($valor = 'No autorizado'){
            $this->response['status'] = 'error';
            $this->response['result'] = array(
                'error_id' => "401",
                'error_mg' =>  $valor
            );
            return $this->response;
        }
    }
    


?>