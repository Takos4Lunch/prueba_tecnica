<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/db/connection.php"); //Must use absolute path
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/response_controller.php");

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
            $query = "SELECT * FROM notes WHERE notes.department = '$department'";
            $data = parent::getData($query);
            return $_response->message_handler($data, 200, 'OK');
        }

        public function getAllNotes(){
            $_response = new response;
            $query = "SELECT * FROM notes WHERE 1";
            $data = parent::getData($query);
            return $_response->message_handler($data, 200, 'OK');
        }

        //Returns a single note, based on the department and user that created the note
        public function getNoteByDepartment($id, $department, $userID){
            $_response = new response;
            $query = "SELECT * FROM notes WHERE notes.department = '$department' AND notes.userID = $userID AND notes.ID = $id";
            $data = parent::getData($query);
            return $_response->message_handler($data[0], 200, 'OK');
        }

        public function postNote($data){
            $_response = new response;
            $userID = $data['userID'];
            $department = $data['department'];
            $description = $data['description'];
            $clientName = $data['client_name'];
            $clientCompany = $data['client_company'];
            $clientNumber = $data['client_number'];
            $observations = "";
            $active = true;

            $query =  "INSERT INTO " . $this->table . " (userID, department, description, clientName, clientCompany, clientNumber, observations, active, status) 
            VALUES ('$userID', '$department', '$description', '$clientName', '$clientCompany', '$clientNumber', '$observations', '$active', 'Pending')";
            $result = parent::nonQueryId($query);
            //return $query;
            return $_response->message_handler($result, 200, 'OK');
        }

        public function putNote($data, $id){
            $_response = new response;
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