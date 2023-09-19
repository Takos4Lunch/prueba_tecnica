<?php
    header( 'Content-Type: application/json' );

    $route =  $_SERVER["REQUEST_URI"];
    $routesDir = 'routes/'; 

    switch ($route) {
        case '/users':
           require $routesDir . 'users.php';
           break;
        case '/auth':
           require $routesDir . 'auth.php';
           break;
   }   
?>