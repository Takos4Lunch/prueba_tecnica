<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/user_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/response_controller.php");
    use Firebase\JWT\JWT;

    class auth {

        //Function should return a token, otherwise, function will return an error code
        public function login($data) {
            //First, we pull the password from the DB and then compare it to the password provided
            //Verification of the data should've been done before callign this function
            $_user = new users;
            $_response = new response;

            $email = $data['email'];
            $password = $data['password'];

            //First, we search for the user in the database
            $user_data = $_user->getUserByEmail($email);
            if(!$user_data){
                return $_response->message_handler('User not found',404,'error');
            }
            $user_data = $user_data['result']; //
            //Then, we check if the provided password matches the DB one
            if(!password_verify($password, $user_data['password'])){
                return $_response->message_handler('Incorrect password',401,'error');
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
            return $_response->message_handler(JWT::encode($data,$secretKey,'HS512'),200,'OK');;
        }

        public function checkToken($jwt){
            //On success: return OK and the data inside the token for usage if needed
            //On failure: return error
            $_response = new response;
            $secretKey = '1234';
            try {
                $token = JWT::decode($jwt, $secretKey, ['HS512']);
                return $token;
            } catch (\Throwable $th) {
                return $_response->message_handler('Token Verification Failed, please check your credentials and try again', 401, 'error');
            }
        }
    }
?>