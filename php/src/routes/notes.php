<?php
    header( 'Content-Type: application/json' );
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/Note_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/verification_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/response_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/auth_controller.php");
    
    $_note = new notes;
    $_verifyer = new verifyer;
    $_response = new response;
    $_auth = new auth;
    
    $method = $_SERVER['REQUEST_METHOD'];
    $entityBody = json_decode(file_get_contents('php://input'), true);

    //Get token from headers
    $headers = getallheaders();
    if(!isset($headers['Authorization']) || empty($headers['Authorization'])){
        echo json_encode($_response->message_handler('Authorization Token Required', 401, 'error'));
        exit();
    }

    //Substract and verify token
    $credentials = $_auth->checkToken(trim(substr($headers['Authorization'], 7)));
    if (isset($credentials['status']) && $credentials['status'] == 'error') {
        echo json_encode($credentials);
        exit();
    }

    switch (strtoupper($method)) {
        case 'GET':
            //This method should return all notes from the associated department

            $check = $_verifyer->emptycheck(['ID'], $entityBody);
            if($check['status_code'] == 200) {
                $id = $entityBody['ID'];
                echo  json_encode($_note->getNote($id));
            }else{
                echo json_encode($check);
            }
            break;
        case 'PUT':
            
            echo json_encode($_note->putNote($entityBody,1));
            break;
        case 'DELETE':
            
            $id = $entityBody['ID'];
            echo json_encode($_note->deleteNote($id));
            break;
        case 'POST':

            /**
             * The fields "employee" (which is the user that created the note) and department are contained within the authorization data carried
             * inside the JWT payload, so they're not requested here
             * The date and hour of creation is determined automatically by the database
             * Status is always 'Pending' by default
             * ONLY USERS FROM THE CLIENT SUPPORT DEPARTMENT CAN ACCESS THIS METHOD
             */
            $fields = array(
                "description",
                "department",
                "client_name",
                "client_company",
                "client_number"
            );

            $roles = array(
                "Chief",
                "Team Manager",
                "Employee"
            );

            $departments = array(
                "Client Support",
            );

            //Check for empty fields
            $emptycheck = $_verifyer->emptycheck($fields, $entityBody);
            if($emptycheck['status_code']!=200){
                echo json_encode($emptycheck);
                break;
            }

            //Check for permissions
            $permissions = $_verifyer->check_credentials($roles, $departments, json_decode($credentials,true));
            if ($permissions['status_code']!=200) {
                echo json_encode($permissions);
                break;
            }

            $credentials = json_decode($credentials,true);

            $additional_data = array(
                "status" => 'Pending',
                "userID" => $credentials['userID']
            );

            $check = $_verifyer->emptycheck('',$entityBody);
            
            $finalbody = array_merge($additional_data, $entityBody);

            echo json_encode($_note->postNote($finalbody));
            break;
        default:
            
            echo "Invalid Operation";
            break;
    }
?>