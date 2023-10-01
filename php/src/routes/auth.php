<?php
    header( 'Content-Type: application/json' );
    require_once($_SERVER['DOCUMENT_ROOT'] . "/controllers/auth_controller.php");

    $_auth = new auth;

    $method = $_SERVER['REQUEST_METHOD'];

    $entityBody = json_decode(file_get_contents('php://input'), true);

    switch (strtoupper($method)) {
        case 'POST':
            //This is the only method that will be allowed on this endpoint
            echo json_encode($_auth->login($entityBody));
            break;
        //Temporary enabled for verification
        case 'GET':
            echo json_encode($_auth->checkToken($entityBody['token']));
            break;
        default:
            
            echo "Invalid Operation";
            break;
    }
?>