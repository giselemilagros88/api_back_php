<?php
    class conexion{
        private $server = 'localhost';
        private $user = 'root';
        private $password = '';
       // private $database = 'movies_cac';
        private $database = 'peliculas_cac_java';
        private $port  = '3306';
        private $conexion;

        function __construct(){
            $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
            if($this->conexion->connect_errno){
                echo "algo va mal con la conexion";
                die();
            }
        }
        #convertir caracteres a utf8
        private function convertirUTF8($array){
            array_walk_recursive($array,function(&$item,$key){
                if(!mb_detect_encoding($item,'utf-8',true)){
                    $item = utf8_encode($item);
                }
            });
            return $array;
        }

        #obtener los datos de la base de datos
        public function obtenerDatos($sqlstr){
            $results = $this->conexion->query($sqlstr);
        // print_r($results);
            $resultArray = array();
            #si results tiene algo entonces recorrerlo
            if($results){
                foreach($results as $key){
                        $resultArray[] = $key;
                }
                return $this->convertirUTF8($resultArray);
            }else{
                return 0;
            }  
        }
        #para guardar datos en la base de datos
        public function nonQuery($sqlstr){
            $results = $this->conexion->query($sqlstr);
            return $this->conexion->affected_rows;
        }
        #para obtener el id de un registro
        public function nonQueryId($sqlstr){
            $results = $this->conexion->query($sqlstr);
            $filas = $this->conexion->affected_rows;
            if($filas >= 1){
                return $this->conexion->insert_id;
            }else{
                return 0;
            }
        }
    }

?>