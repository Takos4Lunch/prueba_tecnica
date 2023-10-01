<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/db/connection.php"); //Must use absolute path
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/response_controller.php");
    
    class users extends connect{

        private $table = "users";
        private $username = "";
        private $password = "";
        private $email = "";
        private $role = "";
        private $department = "";

        //Use nonquery for delete, nonqueryID for update and insert
        public function getUser($id){
            $_response = new response;
            $query = "SELECT * FROM users WHERE users.ID = $id";
            $data = parent::getData($query);
            return $_response->message_handler($data[0], 200, 'OK');
        }

        public function getUserByEmail($email){
            $_response = new response;
            $query = "SELECT * FROM users WHERE users.email = '$email'";
            $data = parent::getData($query);
            return $_response->message_handler($data[0], 200, 'OK');
        }

        public function postUser($data){
            $_response = new response;
            $username = $data['username'];
            $password = password_hash($data['password'],PASSWORD_BCRYPT);
            $email = $data['email'];
            $role = $data['role'];
            $department = $data['department'];

            $query = "INSERT INTO " . $this->table . " (username, password, department, role, email) VALUES ('$username', '$password', '$department', '$role', '$email')";
            $result = parent::nonQueryId($query);
            return $_response->message_handler($result, 200, 'OK');
        }

        public function putUser($data, $id){
            $_response = new response;
            $username = $data['username'];
            $password = $data['password'];
            $email = $data['email'];
            $role = $data['role'];
            $department = $data['department'];

            $query = "UPDATE " . $this->table . " SET username = '$username', password = '$password', department = '$department', role = '$role', email = '$email' WHERE users.ID = $id";
            $result = parent::nonQueryId($query);
            return $_response->message_handler($result, 200, 'OK');
        }

        public function deleteUser($id){
            $_response = new response;
            $query = "DELETE FROM " . $this->table . " WHERE users.ID= '" . $id . "'";
            $result = parent::nonQuery($query);
            return $_response->message_handler($result, 200, 'OK');
        }
    }
?>