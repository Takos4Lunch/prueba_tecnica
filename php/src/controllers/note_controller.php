<?php
    require_once("php/src/db/connection.php"); //Must use absolute path

    class notes extends connect{

        private $table = "notes";
        private $username = ""; //User that creates the note
        private $department = ""; //Department to which the note is addressed to
        private $description = "";
        private $client_name = "";
        private $client_company = "";
        private $client_number = "";
        private $creation_date = "";
        private $save_date = "";
        private $delete_date = "";
        private $reactivation_date = "";
        private $observations = "";

        public function getNote($id){

        }

        public function postNote($data){

        }

        public function putNote($data){

        }

        public function deleteNote($id){
            
        }
    }
?>