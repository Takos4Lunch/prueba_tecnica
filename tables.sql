-- Active: 1695114914348@@127.0.0.1@9906@NOTES_DB
CREATE TABLE users(  
    ID int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    username VARCHAR(255),
    password VARCHAR(255),
    email VARCHAR(50),
    role VARCHAR(25),
    department VARCHAR(50)
);

CREATE TABLE notes(
    ID int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    userID int,
    department VARCHAR(50),
    description VARCHAR(255),
    clientName VARCHAR(255),
    clientCompany VARCHAR(255),
    clientNumber VARCHAR(50),
    creationDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    saveDate TIMESTAMP,
    deleteDate TIMESTAMP,
    reactivationDate TIMESTAMP,
    observations VARCHAR(255),
    active BOOLEAN,
    status VARCHAR(255),
    FOREIGN KEY (userID) REFERENCES users(ID)
)