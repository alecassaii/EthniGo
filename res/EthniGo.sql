DROP DATABASE IF EXISTS EthniGo;
CREATE DATABASE EthniGo;
USE EthniGo;

DROP TABLE IF EXISTS Utenti;
DROP TABLE IF EXISTS Ristoranti;

CREATE TABLE Utenti(
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    Username VARCHAR(30) NOT NULL,
    Email VARCHAR(50) NOT NULL PRIMARY KEY,
    Password VARCHAR(50) NOT NULL
);

CREATE TABLE Ristoranti(
    ID VARCHAR(30) NOT NULL PRIMARY KEY,
    TipoCucina VARCHAR(30) NOT NULL
);

INSERT INTO Utenti VALUES('Default','User','defUsr', 'user@mail.com', SHA('123456'));

INSERT INTO Ristoranti VALUES('7315003', 'Americano');
INSERT INTO Ristoranti VALUES('7315002', 'Africano');
INSERT INTO Ristoranti VALUES('7315083', 'Arabo');
INSERT INTO Ristoranti VALUES('7315062', 'Asiatico');
INSERT INTO Ristoranti VALUES('7315100', 'Egiziano');
INSERT INTO Ristoranti VALUES('7315019', 'Greco');
INSERT INTO Ristoranti VALUES('7315025', 'Italiano');
INSERT INTO Ristoranti VALUES('7315029', 'Sud Americano');
INSERT INTO Ristoranti VALUES('7315033', 'Messicano');
INSERT INTO Ristoranti VALUES('7315051', 'Vietnamita');
INSERT INTO Ristoranti VALUES('7315037', 'Polacco');
