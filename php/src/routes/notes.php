<?php
    header( 'Content-Type: application/json' );
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/controllers/Note_controller.php");

    $_note = new notes;
    
    $method = $_SERVER['REQUEST_METHOD'];
    $entityBody = json_decode(file_get_contents('php://input'), true);

    switch (strtoupper($method)) {
        case 'GET':
            $id = $entityBody['ID'];
            echo  json_encode($_note->getNote($id));
            break;
        case 'PUT':
            
            echo json_encode($_note->putNote($entityBody,1));
            break;
        case 'DELETE':
            
            $id = $entityBody['ID'];
            echo json_encode($_note->deleteNote($id));
            break;
        case 'POST':
            
            
            echo json_encode($_note->postNote($entityBody));
            break;
        default:
            
            echo "Invalid Operation";
            break;
    }
?>