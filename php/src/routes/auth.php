<?php
    header( 'Content-Type: application/json' );
    require_once($_SERVER['DOCUMENT_ROOT'] . "/php/src/controllers/auth_controller.php");

    $_auth = new auth;

    $method = $_SERVER['REQUEST_METHOD'];

    $entityBody = json_decode(file_get_contents('php://input'), true);

    switch (strtoupper($method)) {
        case 'POST':
            //This is the only method that will be allowed on this endpoint
            echo json_encode($_auth->login($entityBody));
            break;
        default:
            # code...
            echo "Invalid Operation";
            break;
    }
?>