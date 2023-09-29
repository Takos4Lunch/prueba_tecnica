<?php
   header( 'Content-Type: application/json' );
   require_once($_SERVER['DOCUMENT_ROOT'] . '/php/src/vendor/autoload.php');
   
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