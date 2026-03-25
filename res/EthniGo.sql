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
    Password VARCHAR(50) NOT NULL,
    DataNascita DATE
);

CREATE TABLE Ristoranti(
    ID VARCHAR(30) NOT NULL PRIMARY KEY,
    TipoCucina VARCHAR(30) NOT NULL
);

INSERT INTO Utenti VALUES('Default','User','defUsr', 'user@mail.com', SHA('123456');

INSERT INTO Ristoranti VALUES('7315003', 'american');
INSERT INTO Ristoranti VALUES('7315002', 'african');
INSERT INTO Ristoranti VALUES('7315083', 'arab');
INSERT INTO Ristoranti VALUES('7315062', 'asian');
INSERT INTO Ristoranti VALUES('7315100', 'egyptian');
INSERT INTO Ristoranti VALUES('7315019', 'greek');
INSERT INTO Ristoranti VALUES('7315025', 'italian');
INSERT INTO Ristoranti VALUES('7315029', 'sudAmerica');
INSERT INTO Ristoranti VALUES('7315033', 'mexican');
INSERT INTO Ristoranti VALUES('7315051', 'vietnam');
INSERT INTO Ristoranti VALUES('7315037', 'polish');
