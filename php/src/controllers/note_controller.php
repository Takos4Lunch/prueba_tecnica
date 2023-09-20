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
            $query = "SELECT * FROM notes WHERE notes.ID = $id";
            $data = parent::getData($query);
            return $data;
        }

        public function getNotes($department){
            //Should be filtered based on department
            $query = "SELECT * FROM notes WHERE notes.department = $department";
            $data = parent::getData($query);
            return $data;
        }

        public function postNote($data){

            $userID = $data['userID'];
            $department = $data['department'];
            $description = $data['description'];
            $clientName = $data['client_name'];
            $clientCompany = $data['client_company'];
            $clientNumber = $data['client_number'];
            $saveDate = "";
            $delete_date = "";
            $reactivation_date = "";
            $observations = "";
            $active = true;


            $query =  "INSERT INTO " . $this->table . " (userID, department, description, clientName, clientCompany, clientNumber, saveDate, deleteDate, reactivationDate, observations, active)
            VALUES ('$userID', '$department', '$description', '$clientName', '$clientCompany', '$clientNumber', '$saveDate', '$delete_date', '$reactivation_date', '$observations', '$active')";
            $result = parent::nonQueryId($query);
            return $result;
        }

        public function putNote($data){
            $id = $data['id'];
            $description = $data['description'];
            $observations = $data['observations'];
            $status = $data['status'];

            $query = "UPDATE " . $this->table . " SET description = '$description', observations = '$observations', status = '$status' WHERE notes.ID = $id";;
            $result = parent::nonQueryId($query);
            return $result;
        }

        public function deleteNote($id){
            $query = "DELETE FROM " . $this->table . " WHERE notes.ID= '" . $id . "'";
            $result = parent::nonQuery($query);
            return $result;
        }
    }
?>