<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/evenements.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>Complexe Sportif</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/header.js"></script>
  </head>
  <body>
    <div id="header-placeholder"></div>

    <div class="corps">
      
        <p id="create"><a href="events.php">Nouvel Evenement</a></p>

        <h1>Gerer Les Evenements</h1>

      <?php

        require_once "../bootstrap.php";
        require_once "../src/Evenement.php";
        require_once "../src/TypeJeu.php";
        require_once "../src/Tournoi.php";
        require_once "../src/Equipe.php";

        foreach ($_POST as $k => $v) {
            $ev=$em->getRepository('Evenement')->findBy(array(
              'id' => $k
            ));

            $tr = $em->getRepository('Tournoi')->findBy(array(
              'evenement' => $k
            ));
            foreach ($tr as $tt) {
              $em->remove($tt);
            }
            $em->remove($ev[0]);
        }
        $em->flush();
        

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

              echo sprintf("<a href='gestion.php?id=%d'><p>%s</p></a>", $t->getId() ,$t->getNom());
          
          }
          echo sprintf("<form action='admin.php' method='post'><input type='submit' id='del' name='%d' value='X'></form>", $e->getId());
          echo "</section>";
        }

      ?>

    </div>

  </body>
</html>