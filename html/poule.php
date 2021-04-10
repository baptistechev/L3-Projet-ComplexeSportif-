<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/poule.css">
    <title>Complexe Sportif</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/header.js"></script>
  </head>
  <body>
    <div id="header-placeholder"></div>
        <?php
        require_once "../bootstrap.php";
        require_once "../src/Evenement.php";
        require_once "../src/TypeJeu.php";
        require_once "../src/Tournoi.php";
        require_once "../src/Equipe.php";
        require_once "../src/Poule.php";
        require_once "../src/fait_partie_de.php";
        require_once "../src/MatchPoule.php";
    ?>

    <div class="corps">

        <h1>Tous les matchs</h1>
        <h2>
            <?php
              $tournois=$em->getRepository('Tournoi')->findBy(array(
                'id' => $_GET["id"]
              ));
              $tournoi = $tournois[0];
              echo $tournoi->getNom();
            ?>
        </h2>
        <div class="content">
            <nav class="gauche">
                
                <?php

                    $poules=$em->getRepository('Poule')->findBy(array(
                      'tournoi' => $tournoi->getId()
                    ));

                    foreach ($poules as $p) {
                        echo sprintf("<a href='#%d'>%s</a>",$p->getId(),$p->getNom());
                    }

                ?>

            </nav>
            <section class="droite">
                
                <?php

                    foreach ($poules as $p) {
                        echo sprintf("<article id='%d'> 
                                        <h3>%s</h3>
                                        <br />
                                        <table>
                                            <tr>
                                                <th>Match</th>
                                                <th>Score</th>
                                            </tr>",$p->getId(),$p->getNom());

                        $matchs=$em->getRepository('MatchPoule')->findBy(array(
                          'poule' => $p->getId()
                        ));
                        foreach ($matchs as $m) {
                            echo sprintf("<tr>
                                            <td>%s VS %s</td>
                                            <td>%s</td>
                                          </tr>", 
                                        $m->getEquipe1()->getNom(), $m->getEquipe2()->getNom(),$m->getScore()); 
                          
                        }
                        echo "</table></article>";
                    }

                ?>

            </section>
        </div>
    </div>
  </body>
</html>