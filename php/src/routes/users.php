<?php
    header( 'Content-Type: application/json' );
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/user_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/verification_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/response_controller.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/auth_controller.php");
    //First, we must switch between the requested HTTP verb
    //Then, apply whichever functionality we need
    $_user = new users;
    $_verifyer = new verifyer;
    $_response = new response;
    $_auth = new auth;

    $method = $_SERVER['REQUEST_METHOD'];
    //Request body, will be dealt with individually on a per method basis inside the switch statement
    //This should be moved to the index, then passed through the global variable
    $entityBody = json_decode(file_get_contents('php://input'), true);

    //Check for the auth token
    $headers = getallheaders();
    if(!isset($headers['Authorization']) || empty($headers['Authorization'])){
        echo json_encode($_response->message_handler('Authorization Token Required', 401, 'error'));
        exit();
    }
    //Trim the token

    //Now we verify the token
    $credentials = $_auth->checkToken(trim(substr($headers['Authorization'], 7)));

    if (isset($credentials['status']) && $credentials['status'] == 'error') {
        echo json_encode($credentials);
        exit();
    }
    //Getting past this point means token verification was successful
    //Now we must verify those credentials for each request
    //Data verification should be done on this layer
    switch (strtoupper($method)) {
        case 'GET':
            $check = $_verifyer->emptycheck(['ID'], $entityBody);
            if($check['status_code'] == 200) {
                $id = $entityBody['ID'];
                echo  json_encode($_user->getUser($id));
            }else{
                echo json_encode($check);
            }
            break;
        case 'PUT':
            
            echo json_encode($_user->putUser($entityBody,1));
            break;
        case 'DELETE':
            
            $check = $_verifyer->emptycheck(['ID'], $entityBody);
            if($check['status_code'] == 200) {
                $id = $entityBody['ID'];
                echo  json_encode($_user->deleteUser($id));
            }else{
                echo json_encode($check);
            }
            break;
        case 'POST':
            
            //Only roles available: Chief, Team Manager, Employee
            //Only departments available: Client Support, HR, Commercial, Cleanup, Recycling Plant
            echo json_encode($_user->postUser($entityBody));
            break;
        default:
            
            echo "Invalid Operation";
            break;
    }
?>