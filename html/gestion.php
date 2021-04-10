<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/gestion.css">
    <title>Complexe Sportif</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/header.js"></script>
    <style media="screen">

      #reorga{
        margin-left: 40%;
        width: 180px;
        padding: 10px;
        text-align: center;
      	color: red;
      	border: solid black 1px;
        border-radius: 5px;
      	background-color: #f3f0ef;
      }

      #reorga a{
        color: black;
      }
    </style>
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

        <article id="top">
            <p>Nombre d'Equipes : <?php echo count($tournoi->getEquipes()); ?></p>
            <p class="g">Tour : <?php echo $tournoi->getTour(); ?></p>
        </article>

        <section id="reorga"><a href="reorga.php?id=<?php echo $_GET['id']; ?>">Réorganiser les poules</a></section>

        <?php

            include("creerPoules.php");

            if (isset($_POST['next']) || isset($_POST['fin'])) {
                include("next.php");
            }else if($tournoi->getTour() != 0){
                include("score.php");
            }else{
                include("formule.php");
            }


            if(isset($_POST['nb'])){
                $nbEquipeGarder = $_POST['nb'];

                $equipes = array();
                $perdants = array();

                $poules=$em->getRepository('Poule')->findBy(array(
                    'tournoi' => $_GET['id'],
                    'tour' => $tournoi->getTour()
                ));
                foreach ($poules as $p) {
                    $classements=$em->getRepository('Classement')->findBy(array(
                        'poule' => $p->getId()
                    ));
                    foreach ($classements as $c) {
                        if($c->getRang() <= $nbEquipeGarder){
                            array_push($equipes, $c->getEquipe());
                        }else{
                            array_push($perdants, $c->getEquipe());
                        }
                    }
                }

                $tournoi->nextTour();
                if(isset($_POST['perdants'])){

                    if($_POST['perdants'] == 'tournoi'){

                        $T = new Tournoi("Perdants ".$tournoi->getNom()." Tour ".($tournoi->getTour()-1));
                        $T->setEvenement($tournoi->getEvenement());

                        foreach ($perdants as $per) {
                            $T->addEquipe($per);
                        }

                        $em->persist($T);
                        $em->flush();
                    }else if($_POST['perdants'] == 'poule'){
                        creerPoules($_POST['formule'], $perdants, $tournoi, $em);
                    }

                }

                creerPoules($_POST['formule'], $equipes, $tournoi, $em);

            }

        ?>
    </div>
  </body>
</html>
