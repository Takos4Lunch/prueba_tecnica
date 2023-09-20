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
        
        public function getData($sqlstr){
            $results = $this->conection->query($sqlstr);
            $resultArray = array();
            foreach ($results as $key) {
                $resultArray[] = $key;
            }
            return $resultArray;
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
        
    }
?>