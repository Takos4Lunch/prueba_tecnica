<?php
   header( 'Content-Type: application/json' );
   use Firebase\JWT\JWT;
   require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
   

    $route =  $_SERVER["REQUEST_URI"];
    $routesDir = 'routes/'; 

    switch ($route) {
        case '/users':
           require $routesDir . 'users.php';
           break;
        case '/auth':
           require $routesDir . 'auth.php';
           break;
        case '/notes':
           require $routesDir . 'notes.php';
           break;
   }   
?>