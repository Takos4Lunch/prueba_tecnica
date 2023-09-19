<?php
    header( 'Content-Type: application/json' );
    require_once("php/src/db/connection.php"); //Must use absolute path
    
    $method = $_SERVER['REQUEST_METHOD'];

    switch (strtoupper($method)) {
        case 'GET':
            # code...
            echo json_encode(' get');
            break;
        case 'PUT':
            # code...
            echo json_encode(' put');
            break;
        case 'DELETE':
            # code...
            echo json_encode(' delete');
            break;
        case 'POST':
            # code...
            echo json_encode(' post');
            break;
                                
        default:
            # code...
            echo "nothing";
            break;
    }
?>