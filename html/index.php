<?php

  session_start();

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/evenements.css">
    <title>Complexe Sportif</title>
    <script src="js/header.js"></script>
    <script src="js/jquery.min.js"></script>
  </head>
  <body>
    <script src="js/header.js"></script>
    <div id="header-placeholder"></div>
    <div class="corps">

      <h1>Evenements</h1>

      <?php

        require_once "../bootstrap.php";
        require_once "../src/Evenement.php";
        require_once "../src/TypeJeu.php";
        require_once "../src/Tournoi.php";
        require_once "../src/Equipe.php";

        $events = $em->getRepository('Evenement')->findAll();
        foreach ($events as $e) {
          echo sprintf("<section>
                          <h3>%s</h3>
                          <p>
                            Type : %s <br />
                            Lieu : %s <br />
                            Date : %s <br />
                            Nombre de tournois : %d <br />
                          </p>",
                        $e->getNom(), $e->getTypeJeu()->getDesc(), $e->getLieu(), $e->getDate()->format('Y-m-d H:i'), $e->getNbTournoi());

          $tournois=$em->getRepository('Tournoi')->findBy(array(
            'evenement' => $e->getId()
          ));

          foreach($tournois as $t) {

              echo sprintf("<a href='tournoi.php?id=%d'><p>%s</p></a>", $t->getId() ,$t->getNom());

          }

          echo "</section>";
        }

      ?>

    </div>
  </body>
</html>
