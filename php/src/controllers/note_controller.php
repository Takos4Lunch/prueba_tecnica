<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/db/connection.php"); //Must use absolute path
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/response_controller.php");

    class notes extends connect{

        private $table = "notes";

        public function getNote($id){
            $_response = new response;
            $query = "SELECT * FROM notes WHERE notes.ID = $id";
            $data = parent::getData($query);
            return $_response->message_handler($data[0], 200, 'OK');
        }

        public function getNotes($department){
            //Should be filtered based on department
            $_response = new response;
            $query = "SELECT * FROM notes WHERE notes.department = $department";
            $data = parent::getData($query);
            return $_response->message_handler($data, 200, 'OK');
        }

        public function postNote($data){
            $_response = new response;
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
            return $_response->message_handler($result, 200, 'OK');
        }

        public function putNote($data){
            $_response = new response;
            $id = $data['id'];
            $description = $data['description'];
            $observations = $data['observations'];
            $status = $data['status'];

            $query = "UPDATE " . $this->table . " SET description = '$description', observations = '$observations', status = '$status' WHERE notes.ID = $id";;
            $result = parent::nonQueryId($query);
            return $_response->message_handler($result, 200, 'OK');
        }

        public function deleteNote($id){
            $_response = new response;
            $query = "DELETE FROM " . $this->table . " WHERE notes.ID= '" . $id . "'";
            $result = parent::nonQuery($query);
            return $_response->message_handler($result, 200, 'OK');
        }
    }
?>