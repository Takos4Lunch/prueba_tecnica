<?php
    header( 'Content-Type: application/json' );

    //First, we must switch between the used HTTP verb
    //Then, apply whichever functionality we need
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