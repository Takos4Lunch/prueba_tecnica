<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/user_controller.php");
    use Firebase\JWT\JWT;
    
    class auth {

        //Function should return a token, otherwise, function will return an error code
        public function login($data) {
            //First, we pull the password from the DB and then compare it to the password provided
            //Verification of the data should've been done before callign this function
            $_user = new users;

            $email = $data['email'];
            $password = $data['password'];

            //First, we search for the user in the database
            $user_data = $_user->getUserByEmail($email);
            if(!$user_data){
                $response = [
                    'status' => "error",
                    'status_code' => "404",
                    'message' => 'User not found',
                ];
                return $response;
            }
            //Then, we check if the provided password matches the DB one
            if(!password_verify($password, $user_data['password'])){
                $response = [
                    'status' => "error",
                    'status_code' => "404",
                    'message' => 'Incorrect Password',
                    'password' => $user_data['password'],
                    'sent password' => $password
                ];
                return $response;
            }

            //If both conditions are met, we return the JWT token
            //JWTs payload should contain role and department
            //So these can be used for authorization purposes
            //Lets proceed to organize the data for the payload
            $secretKey = '1234';
            $username = $user_data['username'];
            $role = $user_data['role'];
            $department = $user_data['department'];

            $data = [
                'userName' => $username,
                'role' => $role,
                'department' => $department
            ];

            return JWT::encode($data,$secretKey,'HS512');
        }
    }
?>