
# Reciclados 3R

Aplicación para administrar notas creadas a partir de las llamadas de diferentes clientes

Actualmente, la aplicación cuenta con 3 componentes esenciales:

* Base de datos MySQL
* API realizada en PHP
* Front end realizado en react

### Base de datos

DB sencilla, utilizando el motor MySQL. Contiene las tablas users y notes 

### API

Backbone de la aplicación. contiene todos los métodos crud utilizados para interactuar y administrar las notas registradas (y los usuarios)

### Front end

Vistas sencillas realizadas utilizando React

## Como correr localmente

* API PHP: ubicandonos en la carpeta php/src, ejecutar el siguiente comando : `php -S localhost:8000 'index.php'`

* DB: ejecutar `docker-compose up` en la carpeta raíz del proyecto

* Front end: ejecutar `npm start` ubicandonos en la carpeta front/frontend

Dentro de la carpeta raíz del repositorio debe encontrarse una colección de postman, que se puede utilizar para realizar llamados a la API sin necesidad de pasar por el front

### IMPORTANTE

Al crear un usuario, deben utilizarse los siguientes valores

* roles: Chief, Team Manager, Employee

* department: Client Support, HR, Commercial, Cleanup, Recycling Plant
