/*
Fichier: Creation_GroupeD9.sql
Auteurs:
Adam LEMONNIER 201908914
Baptiste CHEVALIER 21813639
Nom du groupe: D9
*/

/*
SUPRESSION DE LA BASE DE DONNÉES
*/
DROP DATABASE IF EXISTS complexe_sportif;
CREATE DATABASE complexe_sportif;
USE complexe_sportif;

/*
CREATION DE LA BASE DE DONNÉES
*/

DROP TABLE IF EXISTS Joueur;
DROP TABLE IF EXISTS tournoi_equipe;
DROP TABLE IF EXISTS Classement;
DROP TABLE IF EXISTS MatchPoule;
DROP TABLE IF EXISTS Equipe;
DROP TABLE IF EXISTS Poule;
DROP TABLE IF EXISTS Tournoi;
DROP TABLE IF EXISTS Evenement;
DROP TABLE IF EXISTS TypeJeu;
DROP TABLE IF EXISTS Organisateur;
DROP TABLE IF EXISTS LOGERROR;

/*
Création des relations
*/

CREATE TABLE Equipe (
	nom VARCHAR(30) NOT NULL,
	niveauE INT,
	club VARCHAR(30) NOT NULL,
	CONSTRAINT E_PK PRIMARY KEY(nom)
);

CREATE TABLE Joueur (
	id INT AUTO_INCREMENT NOT NULL,
	nom_equipe VARCHAR(30) DEFAULT NULL,
	nom VARCHAR(30) NOT NULL,
	niveau INT NOT NULL,
	CONSTRAINT J_PK PRIMARY KEY(id),
	CONSTRAINT J_FK FOREIGN KEY (nom_equipe) REFERENCES Equipe (nom)
);

CREATE TABLE TypeJeu (
	id INT AUTO_INCREMENT NOT NULL,
	description VARCHAR(255) NOT NULL,
	CONSTRAINT T_PK PRIMARY KEY(id)
);

CREATE TABLE Evenement (
	id INT AUTO_INCREMENT NOT NULL,
	lieu VARCHAR(255),
	date DATETIME,
	nbJEquipe INT NOT NULL,
	nom VARCHAR(30) NOT NULL,
	nbTournoi INT NOT NULL,
	typeJeu_id INT DEFAULT NULL,
	CONSTRAINT E_PK PRIMARY KEY(id),
	CONSTRAINT E_FK FOREIGN KEY (typeJeu_id) REFERENCES TypeJeu (id),
	CONSTRAINT nbTournoi_dom CHECK (nbTournoi > 0)
);

CREATE TABLE Tournoi (
	id INT AUTO_INCREMENT NOT NULL,
	evenement_id INT DEFAULT NULL,
	nom VARCHAR(30) NOT NULL,
	tour INT NOT NULL,
	CONSTRAINT T_PK PRIMARY KEY(id),
	CONSTRAINT T_FK FOREIGN KEY (evenement_id) REFERENCES Evenement (id)
);

CREATE TABLE tournoi_equipe (
	tournois INT NOT NULL,
	equipes VARCHAR(30) NOT NULL,
	CONSTRAINT t_PK PRIMARY KEY (tournois, equipes),
	CONSTRAINT t_FK1 FOREIGN KEY (tournois) REFERENCES Tournoi (id),
	CONSTRAINT t_FK2 FOREIGN KEY (equipes) REFERENCES Equipe (nom)
);

CREATE TABLE Poule (
	id INT AUTO_INCREMENT NOT NULL,
	tournoi_id INT DEFAULT NULL,
	nom VARCHAR(30) NOT NULL,
	format VARCHAR(255),
	tour INT NOT NULL,
	CONSTRAINT P_PK PRIMARY KEY(id),
	CONSTRAINT P_FK FOREIGN KEY (tournoi_id) REFERENCES Tournoi (id)
);

CREATE TABLE MatchPoule (
	equipe1 VARCHAR(30) NOT NULL,
	equipe2 VARCHAR(30) NOT NULL,
	poule_id INT NOT NULL,
	score VARCHAR(10),
	terrain VARCHAR(255),
	CONSTRAINT M_PK PRIMARY KEY(equipe1, equipe2, poule_id),
	CONSTRAINT M_FK1 FOREIGN KEY (equipe1) REFERENCES Equipe (nom),
	CONSTRAINT M_FK2 FOREIGN KEY (equipe2) REFERENCES Equipe (nom),
	CONSTRAINT M_FK3 FOREIGN KEY (poule_id) REFERENCES Poule (id)
);

CREATE TABLE Classement (
	poule_id INT NOT NULL,
	nom_equipe VARCHAR(30) NOT NULL,
	rang INT,
	CONSTRAINT C_PK PRIMARY KEY(poule_id, nom_equipe),
	CONSTRAINT C_FK1 FOREIGN KEY (poule_id) REFERENCES Poule (id),
	CONSTRAINT C_FK2 FOREIGN KEY (nom_equipe) REFERENCES Equipe (nom)
);

CREATE TABLE Organisateur (
	utilisateur VARCHAR(40) NOT NULL,
	mot_de_pass VARCHAR(40) NOT NULL,
	nom VARCHAR(30) NOT NULL,
	CONSTRAINT O_PK PRIMARY KEY(utilisateur)
);

CREATE TABLE LOGERROR  (
  ID INT(11) AUTO_INCREMENT,
  MESSAGE VARCHAR(255) DEFAULT NULL,
  THETIME TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT PK_LOGERROR PRIMARY KEY (ID)
);

/*
Insertion de tuples dans les relations
*/

INSERT INTO Organisateur VALUES ("chef", md5("monMotDePass"), "LeChef");

INSERT INTO TypeJeu VALUES (1, "Volley");

INSERT INTO Evenement VALUES (1, "Tokyo", STR_TO_DATE('14-07-2020', '%d-%m-%Y'), 2, "FeteNat", 1, 1);

INSERT INTO Tournoi VALUES (1, 1, "Principal", 1);
INSERT INTO Tournoi VALUES (2, 1, "Amateur", 1);

INSERT INTO Equipe(nom, club) VALUES ("Equipe1", "club1");
INSERT INTO Equipe VALUES ("Equipe2",2,"club2");
INSERT INTO Equipe VALUES ("Equipe3",1,"club3");
INSERT INTO Equipe VALUES ("Equipe4",2,"club4");
INSERT INTO Equipe VALUES ("Equipe5",4,"club5");


INSERT INTO tournoi_equipe VALUES (1, "Equipe1");
INSERT INTO tournoi_equipe VALUES (1, "Equipe2");
INSERT INTO tournoi_equipe VALUES (1, "Equipe3");
INSERT INTO tournoi_equipe VALUES (1, "Equipe4");
INSERT INTO tournoi_equipe VALUES (2, "Equipe5");


INSERT INTO Joueur VALUES (1, "Equipe1", "Jean", 1);
INSERT INTO Joueur VALUES (2, "Equipe1", "Pierre", 5);

INSERT INTO Poule VALUES (1, 1, "Poule1", "3 set, 20 minutes", 1);

UPDATE Tournoi SET tour = 2 WHERE id = 1;

INSERT INTO Poule VALUES (2, 1, "Poule2", "3 set, 20 minutes", 2);
INSERT INTO Poule VALUES (3, 1, "Poule3", "3 set, 20 minutes", 2);

/*Match du tour 1 */
INSERT INTO MatchPoule VALUES ("Equipe1", "Equipe2", 1, "4-0", "petit terrain");
INSERT INTO MatchPoule VALUES ("Equipe1", "Equipe3", 1, "4-2", "grand terrain");
INSERT INTO MatchPoule VALUES ("Equipe1", "Equipe4", 1, "5-3", "terrain du fond");
INSERT INTO MatchPoule VALUES ("Equipe2", "Equipe3", 1, "7-2", "terrain pro");
INSERT INTO MatchPoule VALUES ("Equipe2", "Equipe4", 1, "1-0", "petit terrain");
INSERT INTO MatchPoule VALUES ("Equipe3", "Equipe4", 1, "7-2", "terrain pro");

INSERT INTO Classement VALUES (1, "Equipe1", 1);
INSERT INTO Classement VALUES (1, "Equipe2", 2);
INSERT INTO Classement VALUES (1, "Equipe3", 3);
INSERT INTO Classement VALUES (1, "Equipe4", 4);

/*Match du tour 2 */
INSERT INTO MatchPoule VALUES ("Equipe3", "Equipe4", 2, "3-6", "petit terrain");
INSERT INTO MatchPoule VALUES ("Equipe1", "Equipe2", 3, "2-0", "terrain de la finale");

INSERT INTO Classement VALUES (2, "Equipe3", 2);
INSERT INTO Classement VALUES (2, "Equipe4", 1);
INSERT INTO Classement VALUES (3, "Equipe1", 1);
INSERT INTO Classement VALUES (3, "Equipe2", 2);

  
 /* 
 Affichage des tuples
 */

SELECT * FROM Organisateur;
SELECT * FROM TypeJeu;
SELECT * FROM Evenement;
SELECT * FROM Tournoi;
SELECT * FROM Equipe;
SELECT * FROM Joueur;
SELECT * FROM Poule;
SELECT * FROM MatchPoule;
SELECT * FROM Classement;

/*
Définition de triggers
*/

/*
	Trigger pour verifier le tour d'une poule (a partir du tour du tournoi)
*/

DROP TRIGGER IF EXISTS TOUR_POULE_TOURNOI

DELIMITER $$
CREATE TRIGGER TOUR_POULE_TOURNOI
BEFORE INSERT on Poule
FOR EACH ROW
BEGIN
	DECLARE TOUR_TOURNOI INT;
	SET TOUR_TOURNOI = (SELECT tour FROM Tournoi where id=NEW.tournoi_id);

	IF NEW.tour <> TOUR_TOURNOI THEN
	    INSERT INTO LOGERROR(MESSAGE) VALUES (CONCAT("ERREUR TOUR DE LA POULE DU TOUR DU TOURNOI"));
        SIGNAL SQLSTATE VALUE '45000' SET MESSAGE_TEXT ="LE TOUR DE LA POULE DOIT ETRE IDENTIQUE AU TOUR DU TOURNOI";
    END IF;
END; $$

/*
	Trigger pour verifier que le match est conforme
	les equipes et la poules qui composent un match sont bien dans le meme tournoi
	le match n'est pas contitué de 2 fois la même equipe
*/

DROP TRIGGER IF EXISTS MATCH_CONFORME

DELIMITER $$
CREATE TRIGGER MATCH_CONFORME
BEFORE INSERT ON MatchPoule
FOR EACH ROW
BEGIN
	DECLARE TOURNOI_EQUIPE1 INT;
	DECLARE TOURNOI_EQUIPE2 INT;
	DECLARE TOURNOI_POULE INT;

	SET TOURNOI_POULE = (SELECT tournoi_id FROM Poule where id=NEW.poule_id);
	SET TOURNOI_EQUIPE1 = (SELECT tournois FROM tournoi_equipe where equipes=NEW.equipe1 and tournois=TOURNOI_POULE);
	SET TOURNOI_EQUIPE2 = (SELECT tournois FROM tournoi_equipe where equipes=NEW.equipe2 and tournois=TOURNOI_POULE);

	IF (TOURNOI_EQUIPE1 IS NULL) OR (TOURNOI_EQUIPE2 IS NULL) THEN
	    INSERT INTO LOGERROR(MESSAGE) VALUES (CONCAT("ERREUR TOURNOI EQUIPE1 EQUIPE2 POULE DIFFERENTS"));
        SIGNAL SQLSTATE VALUE '45000' SET MESSAGE_TEXT ="LES 2 EQUIPES ET LA POULE DOIVENT APPARTENIR AU MEME TOURNOI";
    END IF;

    IF NEW.equipe1 = NEW.equipe2 THEN
	    INSERT INTO LOGERROR(MESSAGE) VALUES (CONCAT("ERREUR MEME EQUIPES !"));
        SIGNAL SQLSTATE VALUE '45000' SET MESSAGE_TEXT ="LES 2 EQUIPES COMPOSANT UN MATCH DOIVENT ETRE DIFFERENTES !";
    END IF;

END;$$

/*
	Trigger pour verifier que le niveau d'un joueur est compris entre 1 et 5
*/

DROP TRIGGER IF EXISTS NIVEAU_CONFORME_J

DELIMITER $$
CREATE TRIGGER NIVEAU_CONFORME_J
BEFORE INSERT ON Joueur
FOR EACH ROW
BEGIN
  DECLARE NIVEAU_J INT;
  SET NIVEAU_J = NEW.niveau;

  IF NIVEAU_J < 1 OR NIVEAU_J > 5 THEN
    INSERT INTO LOGERROR(MESSAGE) VALUES (CONCAT("ERREUR NIVEAU DU JOUEUR INCORRECT !"));
      SIGNAL SQLSTATE VALUE '45000' SET MESSAGE_TEXT ="LE NIVEAU DU JOUEUR DOIT ÊTRE COMPRIS ENTRE 1 ET 5";
  END IF;
END;$$

/*
Trigger pour verifier que le niveau d'une equipe est compris entre 1 et 5
*/

DROP TRIGGER IF EXISTS NIVEAU_CONFORME_E

DELIMITER $$
CREATE TRIGGER NIVEAU_CONFORME_E
BEFORE INSERT ON Equipe
FOR EACH ROW
BEGIN
DECLARE NIVEAU_E INT;
  SET NIVEAU_E = NEW.niveauE;

  IF NIVEAU_E < 1 OR NIVEAU_E > 5 THEN
    INSERT INTO LOGERROR(MESSAGE) VALUES (CONCAT("ERREUR NIVEAU DE L'EQUIPE INCORRECT !"));
      SIGNAL SQLSTATE VALUE '45000' SET MESSAGE_TEXT ="LE NIVEAU D'UNE EQUIPE DOIT ÊTRE COMPRIS ENTRE 1 ET 5";
  END IF;

END;$$


/*
Définition de functions ou procedures
*/

/*
	Fonction qui donne le niveau d'une equipes (regionnal, N2...ect ) en fonction d'une equipe (niveau en nb)
*/
DROP FUNCTION IF EXISTS CATEGORIE_EQUIPE;
DELIMITER $$
CREATE FUNCTION CATEGORIE_EQUIPE (NIVEAU INT)
RETURNS VARCHAR(20)
DETERMINISTIC
BEGIN
    DECLARE CATEGORIE VARCHAR(20);

    CASE NIVEAU
    	WHEN 1 THEN SET CATEGORIE='LOISIR';
    	WHEN 2 THEN SET CATEGORIE='REGIONAL';
    	WHEN 3 THEN SET CATEGORIE='N3';
    	WHEN 4 THEN SET CATEGORIE='N2';
    	WHEN 5 THEN SET CATEGORIE='PRO';
    	ELSE SET CATEGORIE='NONE';
    END CASE;

    RETURN (CATEGORIE);
END$$

/*
	Fonction qui donne le vainqueur d'un tournoi
*/

DROP FUNCTION IF EXISTS VAINQUEUR;

DELIMITER $$
CREATE FUNCTION VAINQUEUR (TOURNOI INT)
RETURNS VARCHAR(30)
DETERMINISTIC
BEGIN
    DECLARE MEILLLEUR_POULE INT;
    DECLARE EQUIPE VARCHAR(30);

    SET MEILLLEUR_POULE = 
    					(SELECT MAX(poule_id) 
    					FROM Classement 
    					WHERE poule_id IN 
    						(SELECT id FROM Poule WHERE tournoi_id = TOURNOI));

    SET EQUIPE = (SELECT nom_equipe FROM Classement WHERE poule_id = MEILLLEUR_POULE AND rang = 1);

    RETURN (EQUIPE);
END$$

/*
	PROCEDURE pour calculer le niveau d'une équipe (pas trigger pcq on doit d'abord ajouter les joueurs)
*/

DELIMITER $$
CREATE OR REPLACE PROCEDURE NIVEAU_EQUIPE (NOM_E VARCHAR(30))
BEGIN

    UPDATE Equipe 
    SET 
    	niveauE = (SELECT CAST(AVG(niveau) AS INT) FROM Joueur WHERE NOM_E = nom_equipe) 
    WHERE 
    	nom = NOM_E;

END$$
