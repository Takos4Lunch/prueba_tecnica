<?php 
    require_once("php/src/db/connection.php"); //Must use absolute path
    
    class users extends connect{

        private $table = "users";
        private $username = "";
        private $password = "";
        private $email = "";
        private $role = "";
        private $department = "";

        public function getUser($id){

        }

        public function postUser($data){

        }

        public function putUser($data){

        }

        public function deleteUser($id){

        }
    }
?>