DROP DATABASE IF EXISTS EthniGo;
CREATE DATABASE EthniGo;
USE EthniGo;

DROP TABLE IF EXISTS Utenti;
DROP TABLE IF EXISTS Categorie;
DROP TABLE IF EXISTS Preferiti;

CREATE TABLE Utenti(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    Username VARCHAR(30) NOT NULL,
    Email VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL
);

CREATE TABLE Categorie(
    ID VARCHAR(30) NOT NULL PRIMARY KEY,
    TipoCucina VARCHAR(30) NOT NULL
);

CREATE TABLE Preferiti(
    ID_Utente INT NOT NULL,
    ID_Ristorante VARCHAR(50) NOT NULL,
    Nome_Ristorante VARCHAR(100) NOT NULL,
    Indirizzo VARCHAR(255),
    Telefono VARCHAR(20),
    SitoWeb VARCHAR(255),
    DataAggiunta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID_Utente, ID_Ristorante),
    FOREIGN KEY (ID_Utente) REFERENCES Utenti(ID) ON DELETE CASCADE
);

INSERT INTO Utenti (Nome, Cognome, Username, Email, Password)
VALUES ('Default','User','defUsr', 'user@mail.com', SHA1('123456'));

INSERT INTO Categorie VALUES('7315003', 'Americano');
INSERT INTO Categorie VALUES('7315002', 'Africano');
INSERT INTO Categorie VALUES('7315083', 'Arabo');
INSERT INTO Categorie VALUES('7315062', 'Asiatico');
INSERT INTO Categorie VALUES('7315100', 'Egiziano');
INSERT INTO Categorie VALUES('7315019', 'Greco');
INSERT INTO Categorie VALUES('7315025', 'Italiano');
INSERT INTO Categorie VALUES('7315029', 'Sud Americano');
INSERT INTO Categorie VALUES('7315033', 'Messicano');
INSERT INTO Categorie VALUES('7315051', 'Vietnamita');
INSERT INTO Categorie VALUES('7315037', 'Polacco');