<?php

    class connect {

        private $server;
        private $user;
        private $password;
        private $database;
        private $port;
        private $conection;

        function __construct() {
            //First, we create the connection to the DB
            $datalist = $this->connectionData();
            foreach ($datalist as $key => $value) {
                $this->server = $value['server'];
                $this->user = $value['user'];
                $this->password = $value['password'];
                $this->database = $value['database'];
                $this->port = $value['port'];
            }

            $this->conection = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
            if($this->conection->connect_errno){
                echo "something went wrong";
                die();
            }
        }

        private function connectionData(){
            $direction = dirname(__FILE__);
            $jsondata = file_get_contents($direction . "/" . "config");
            return json_decode($jsondata,true);
        }

        private function transformUTF8($array){
            array_walk_recursive($array,function(&$item,$key){
                if(!mb_detect_encoding($item,'utf-8',true)){
                    $item = utf8_encode($item);
                }
            });
            return $array;
        }
        
        public function getData($sqlstr){
            $results = $this->conection->query($sqlstr);
            $resultArray = array();
            foreach ($results as $key) {
                $resultArray[] = $key;
            }
            return $this->transformUTF8($resultArray);
        }
    
        //general querys
        public function nonQuery($sqlstr){
            $results = $this->conection->query($sqlstr);
            return $this->conection->affected_rows;
        }
    
        //returns id of the last inserted row
        public function nonQueryId($sqlstr){
            $results = $this->conection->query($sqlstr);
            $filas =  $this->conection->affected_rows;
            if($filas >= 1){
                return $this->conection->insert_id;
            }else{
                return 0;
            }
        }
    
        protected function encrypt($string){
            $salt = "0netw0thr33f0ur";
    
            $password = hash('sha256', $salt.$string);
    
            return $password;
        }
    
        public function checkToken($token){
            $query = "SELECT api_key, ip_remote, id_status, id FROM users WHERE api_key = '$token'";
            $resp = $this->getData($query);
            if($resp){
                return $resp;
            }else{
                return 0;
            }
        }
    }
?>