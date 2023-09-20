<?php 
    require_once("php/src/db/connection.php"); //Must use absolute path
    
    class users extends connect{

        private $table = "users";
        private $username = "";
        private $password = "";
        private $email = "";
        private $role = "";
        private $department = "";

        //Use nonquery for delete, nonqueryID for update and insert
        public function getUser($id){
            $query = "SELECT * FROM users WHERE users.ID = $id";
            $data = parent::getData($query);
            return $data;
        }

        public function postUser($data){

            $username = $data['username'];
            $password = $data['password'];
            $email = $data['email'];
            $role = $data['role'];
            $department = $data['department'];

            $query = "INSERT INTO " . $this->table . " (username, password, department, role, email) VALUES ('$username', '$password', '$department', '$role', '$email')";
            $result = parent::nonQueryId($query);
            return $result;
        }

        public function putUser($data, $id){
            $username = $data['username'];
            $password = $data['password'];
            $email = $data['email'];
            $role = $data['role'];
            $department = $data['department'];

            $query = "UPDATE " . $this->table . " SET username = '$username', password = '$password', department = '$department', role = '$role', email = '$email' WHERE users.ID = $id";
            $result = parent::nonQueryId($query);
            return $result;
        }

        public function deleteUser($id){
            $query = "DELETE FROM " . $this->table . " WHERE users.ID= '" . $id . "'";
            $result = parent::nonQuery($query);
            return $result;
        }
    }
?>