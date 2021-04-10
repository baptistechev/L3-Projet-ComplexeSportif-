<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/equipe.css">
    <title>Complexe Sportif</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/header.js"></script>
  </head>
  <body>
    <div id="header-placeholder"></div>
        <?php
        require_once "../bootstrap.php";
        require_once "../src/Equipe.php";
        require_once "../src/Joueur.php";
    ?>

    <div class="corps">
        <div class="content">

            <h1>Joueurs de l'equipe <?php echo $_GET["nom"] ;?>              
            </h1>

            <?php

                $joueurs=$em->getRepository('Joueur')->findBy(array(
                    'equipe' => $_GET["nom"]
                  ));
                $cpt = 0;
                echo "<div class='row'>";
                foreach ($joueurs as $j) {
                    if($cpt>=4){
                        echo "</div><div class='row'>";
                        $cpt = 0;
                    }
                    echo sprintf("<div class='joueur'>%s<br />
                                                    Niveau %d<br />
                                    </div>", $j->getNom(), $j->getNiveau());
                    $cpt++;
                }
                echo "</div>";

            ?>
        </div>
    </div>

  </body>
</html>