<?php
    header( 'Content-Type: application/json' );
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/Note_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/verification_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/response_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/auth_controller.php");
    
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
            $roles = array(
                "Chief",
                "Team Manager",
                "Employee"
            );

            $departments = array(
                "Client Support",
                "HR",
                "Commercial",
                "Cleanup",
                "Recycling Plant"
            );

            $credentials = json_decode($credentials, true);
            $permissions = $_verifyer->check_credentials($roles, $departments, $credentials);
            if ($permissions['status_code']!=200) {
                echo json_encode($permissions);
                break;
            }

            if($permissions['status_code'] == 200) {
                if ($credentials['department'] == 'Client Support') {
                    echo json_encode($_note->getAllNotes());    
                }else{
                    echo json_encode($_note->getNotes($credentials['department']));
                }
            }else{
                echo json_encode($check);
            }
            break;
        case 'PUT':
            
            /**
             * Users are only allowed to change:
             * description (only whoever created it can do it)
             * status
             * observations
             * 
             * retrictions
             * Note must be for the same department as the user's
             * Roles: Chief, Team Manager
             */

            $fields = array(
                "ID",
                "description",
                "status",
                "observations"
            );

            $roles = array(
                "Chief",
                "Team Manager"
            );

            $departments = array(
                "Client Support",
                "HR",
                "Commercial",
                "Cleanup",
                "Recycling Plant"
            );

            $emptycheck = $_verifyer->emptycheck($fields, $entityBody);
            if($emptycheck['status_code']!=200){
                echo json_encode($emptycheck);
                break;
            }

            $credentials = json_decode($credentials, true);
            $permissions = $_verifyer->check_credentials($roles, $departments, $credentials);
            if ($permissions['status_code']!=200) {
                echo json_encode($permissions);
                break;
            }

            $note_data = $_note->getNoteByDepartment($entityBody['ID'], $credentials['department'], $credentials['userID']);
            //Just in case the note doesn't exist
            if (empty($note_data['result'])) {
                echo json_encode($_response->message_handler('Note not found', 404, 'error'));
                break;
            }

            //At this point, we know for sure that the note belongs to the department
            //Time to modify the note

            echo json_encode($_note->putNote($entityBody,$entityBody['ID']));
            break;
        case 'DELETE':
            
            $roles = array(
                "Chief",
                "Team Manager"
            );

            $departments = array(
                "Client Support"
            );

            $emptycheck = $_verifyer->emptycheck(['ID'], $entityBody);
            if($emptycheck['status_code']!=200){
                echo json_encode($emptycheck);
                break;
            }

            $credentials = json_decode($credentials, true);
            $permissions = $_verifyer->check_credentials($roles, $departments, $credentials);
            if ($permissions['status_code']!=200) {
                echo json_encode($permissions);
                break;
            }

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

            //Additional data for the note body
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