/*
FIchier : Test_GroupeA.sql
Auteurs : 
Adam LEMONNIER 201908914
Baptiste CHEVALIER 21813639
Nom du groupe: D9
*/

/* 
	Test des triggers 
*/

/* Test trigger 1 */


/* Insertion d'une Poule de tour supérieur (99) au tour courrant du tournoi */
INSERT INTO Poule VALUES (4, 1, "poule 4", "3 set, 20 minutes", -1);

/* Affichage pour vérifier que l'erreur a bien été sauvegardé dans le log */

SELECT * FROM LOGERROR ;

/*Test trigger 2 */


/* Insertion d'un Match avec des equipes inscrites dans des tournois différents */
INSERT INTO MatchPoule VALUES ("Equipe1", "Equipe5", 1, "0-0", "grand terrain");

/* Insertion d'un Match avec deux fois la même equipe */
INSERT INTO MatchPoule VALUES ("Equipe1", "Equipe1", 1, "0-0", "grand terrain");

/* Affichage pour vérifier que l'erreur a bien été sauvegardé dans le log */
SELECT * FROM LOGERROR ;

/*Test trigger 3 */


/*Insertion d'un joueur de niveau 7 ( > 5) */
INSERT INTO Joueur(nom_equipe, nom, niveau) VALUES ("Equipe5", "Boris", 7);

/*Test trigger 4 */


/*Insertion d'une Equipe de niveau -1 ( < 1) */
INSERT INTO Equipe VALUES ("Equipe6", -1, "Club6");

/* 
	Test fonction 
*/

/* Fonction 1 */


/* Affiche pour chaque equipe sa categorie basée sur son niveau d'Equipe*/
SELECT nom, niveauE, CATEGORIE_EQUIPE(niveauE) FROM Equipe;

/* Fonction 2 */
/* Requete pour connaitre vainqueur tournoi (sujet 1) */


/* affiche le vainqueur du tournoi d'id = 1 (Principal) */
SELECT DISTINCT VAINQUEUR(1) FROM Tournoi;

/* Procédure 1 */

/* Affichage avant la màj */
SELECT nom, niveauE FROM Equipe WHERE nom="Equipe1";

/* Calcul le niveau de l'Equipe 1 a partir des niveaux des joueurs*/
CALL NIVEAU_EQUIPE("Equipe1");

/* Affichage apres la màj */
SELECT nom, niveauE FROM Equipe WHERE nom="Equipe1";

