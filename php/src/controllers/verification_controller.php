<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/response_controller.php");

    class verifyer {
        //This class will act as a type/data veryfication tool for the input provided by the user
        //if the input provided by the user is either null or doesn't adhere to certain criteria, it will indicate the missing field based on an array
        //provided at the moment of calling this function

        //Check if any required field is missing or empty
        public function emptycheck($keys, $input_array){
            $_response = new response;
            //First, we check if there's any missing field
            foreach ($keys as $key) {
                if(!isset($input_array[$key])){
                    return $_response->message_handler("The " . $key . " field is required", '404', "error");
                }
            }

            //Then, if there isn't any missing field, we check if they're empty
            foreach ($input_array as $key => $value) {
                if(empty($value)){
                    return $_response->message_handler("The " . $key . " field is empty", '404', "error");
                }
            };

            return $_response->message_handler('success', '200', 'OK');
        }

        public function check_credentials($roles, $departments, $data){
            //Roles and Departments are array which contain the allowed roles/departments for the operation this is called in
            //Data contains the array with the user's credentials
            $_response = new response;
            if(in_array($data['role'],$roles) && in_array($data['department'],$departments)){
                return $_response->message_handler('success', '200', 'OK');
            }else{
                return $_response->message_handler("Unauthorized", '401', "error");
            }
        }
        
    }
?>