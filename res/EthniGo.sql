DROP DATABASE IF EXISTS EthniGo;
CREATE DATABASE EthniGo;
USE EthniGo;

DROP TABLE IF EXISTS Preferiti;
DROP TABLE IF EXISTS Ristoranti;
DROP TABLE IF EXISTS Utenti;

CREATE TABLE Utenti(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(30) NOT NULL,
    Cognome VARCHAR(30) NOT NULL,
    Username VARCHAR(30) NOT NULL UNIQUE,
    Email VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL
);

CREATE TABLE Ristoranti(
    ID VARCHAR(30) NOT NULL PRIMARY KEY,
    TipoCucina VARCHAR(30) NOT NULL
);

CREATE TABLE Preferiti(
    ID_Utente INT NOT NULL,
    ID_Ristorante VARCHAR(30) NOT NULL,
    DataAggiunta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID_Utente, ID_Ristorante),
    FOREIGN KEY (ID_Utente) REFERENCES Utenti(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Ristorante) REFERENCES Ristoranti(ID) ON DELETE CASCADE
);

INSERT INTO Utenti (Nome, Cognome, Username, Email, Password) 
VALUES ('Default','User','defUsr', 'user@mail.com', SHA1('123456'));

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

-- Esempio di un preferito
-- INSERT INTO Preferiti (ID_Utente, ID_Ristorante) VALUES (1, '7315025');
