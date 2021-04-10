<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/classement.css">
    <title>Complexe Sportif</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/header.js"></script>
  </head>
  <body>
    <div id="header-placeholder"></div>

    <div class="corps">

      <h1>
        <?php

          require_once "../bootstrap.php";
            require_once "../src/Evenement.php";
            require_once "../src/TypeJeu.php";
            require_once "../src/Tournoi.php";
            require_once "../src/Equipe.php";
            require_once "../src/Poule.php";
            require_once "../src/fait_partie_de.php";
            require_once "../src/MatchPoule.php";

          $tournois=$em->getRepository('Tournoi')->findBy(array(
            'id' => $_GET["id"]
          ));
          $tournoi = $tournois[0];
          echo $tournoi->getNom();
        ?>
      </h1>

      <h2>Classement</h2>

      <table class="classement">
        <tr>
          <th>Equipe</th>
          <th>Rang</th>
        </tr>

      <?php
            

            $tournois=$em->getRepository('Tournoi')->findBy(array(
                'id' => $_GET["id"]
            ));
            $tournoi = $tournois[0];

            $poules = $em->getRepository('Poule')->findBy(array(
              'tournoi' => $tournoi->getId(),
              'tour' => $tournoi->getTour()
            ));

            array_reverse($poules);
            $dejaClass = array();
            $rg = 1;

            for ($i=count($poules) - 1; $i >= 0 ; $i--) { 
              // echo $poules[$i]->getNom()."<br />";

              $classements = $em->getRepository('Classement')->findBy(array(
                'poule' => $poules[$i]->getId()
              ));

              for ($j=1; $j <= count($classements); $j++) { 
                $rang = $em->getRepository('Classement')->findBy(array(
                  'poule' => $poules[$i]->getId(),
                  'rang' => $j
                ));
                if(!in_array($rang[0]->getEquipe()->getNom(), $dejaClass)){
                  array_push($dejaClass, $rang[0]->getEquipe()->getNom());
                  echo sprintf("<tr>
                                  <td>%s</td>
                                  <td>%d</td>
                                </tr>",$rang[0]->getEquipe()->getNom(),$rg);
                  $rg++;
                }
              }
            }
      ?>
    </table>
    </div>
  </body>
</html>