<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/gestion.css">
    <link rel="stylesheet" href="css/reorga.css">
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
      <article id="top">
          <p>Nombre d'Equipes : <?php echo count($tournoi->getEquipes()); ?></p>
          <p class="g">Tour : <?php echo $tournoi->getTour(); ?></p>
      </article>
        <div id="poules">
        <?php
        $poules=$em->getRepository('Poule')->findBy(array(
            'tournoi' => $tournoi->getId(),
            'tour' => $tournoi->getTour()
        ));
        
        foreach ($poules as $p) {

          echo sprintf("<div class='poule' id='%s'><h2>%s</h2>",$p->getNom(),$p->getNom());

          $matchs = $em->getRepository('MatchPoule')->findBy(array(
              'poule' => $p->getId()
          ));

          $tabEquipes = array();
          foreach ($matchs as $m) {
            $e1 = $m->getEquipe1()->getNom();
            $e2 = $m->getEquipe2()->getNom();
            if(!in_array($e1,$tabEquipes)){
              echo sprintf("<h4 class=\"equipe\" id=\"%s\" draggable=\"true\">%s</h4>", $e1, $e1);
              array_push($tabEquipes, $e1);
            }
            if(!in_array($e2, $tabEquipes)){
              echo sprintf("<h4 class=\"equipe\" id=\"%s\"draggable=\"true\">%s</h4>", $e2, $e2);
              array_push($tabEquipes, $e2);
            }
          }
          echo "</div>";
        }

      
        ?></div>
        <button onclick="update()"> Actualiser</button>
        <form class="content" id="form" action="reorga.php?id=<?php echo $_GET['id']; ?>" method="post">
          <button type="submit" name="update">Valider</button>
        </form>
        <?php
          if(isset($_POST['update'])){

            $Poules = array();
            foreach ($_POST as $eqPoule => $v) {
               if($eqPoule != 'update'){
                  $data = explode("_",$eqPoule);

                  if(!isset($Poules[$data[0]])){
                    $Poules[$data[0]] = array();
                  }
                  $equipe=$em->getRepository('Equipe')->findBy(array(
                      'nom' => $data[1]
                  ));
                  array_push($Poules[$data[0]], $equipe[0]);
               }
             } 

             // print_r($Poules);

             foreach ($Poules as $ind => $po) {

                foreach ($poules as $p) {
                  if($p->getNom() == $ind){
                    $currentPoule = $p;
                    echo $currentPoule->getNom();
                  }
                }

                $matchs = $em->getRepository('MatchPoule')->findBy(array(
                    'poule' => $currentPoule->getId()
                ));

                foreach ($matchs as $m) {
                  $em->remove($m);
                }

                $em->flush();

                switch (count($po)) {
                    case 2:
                        
                        $M1 = new MatchPoule($po[0], $po[1], $currentPoule,"");
                        echo "creation match ".$po[0]->getNom()." vs ".$po[1]->getNom()." ".$currentPoule->getNom()."\n";

                        $em->persist($M1);
                        break;

                    case 3:
                        $M1 = new MatchPoule($po[0], $po[1], $currentPoule,"");
                        $M2 = new MatchPoule($po[1], $po[2], $currentPoule,"");
                        $M3 = new MatchPoule($po[0], $po[2], $currentPoule,"");
                        echo "creation match ".$po[0]->getNom()." vs ".$po[1]->getNom()." ".$currentPoule->getNom()."\n";
                        echo "creation match ".$po[1]->getNom()." vs ".$po[2]->getNom()." ".$currentPoule->getNom()."\n";
                        echo "creation match ".$po[0]->getNom()." vs ".$po[2]->getNom()." ".$currentPoule->getNom()."\n";

                        $em->persist($M1);
                        $em->persist($M2);
                        $em->persist($M3);
                        break;



                    case 4:
                        $M1 = new MatchPoule($po[0], $po[1], $currentPoule,"");
                        $M2 = new MatchPoule($po[0], $po[2], $currentPoule,"");
                        $M3 = new MatchPoule($po[0], $po[3], $currentPoule,"");
                        $M4 = new MatchPoule($po[1], $po[2], $currentPoule,"");
                        $M5 = new MatchPoule($po[1], $po[3], $currentPoule,"");
                        $M6 = new MatchPoule($po[2], $po[3], $currentPoule,"");
                        echo "creation match ".$po[0]->getNom()." vs ".$po[1]->getNom()." ".$currentPoule->getNom()."\n";
                        echo "creation match ".$po[0]->getNom()." vs ".$po[2]->getNom()." ".$currentPoule->getNom()."\n";
                        echo "creation match ".$po[0]->getNom()." vs ".$po[3]->getNom()." ".$currentPoule->getNom()."\n";
                        echo "creation match ".$po[1]->getNom()." vs ".$po[2]->getNom()." ".$currentPoule->getNom()."\n";
                        echo "creation match ".$po[1]->getNom()." vs ".$po[3]->getNom()." ".$currentPoule->getNom()."\n";
                        echo "creation match ".$po[2]->getNom()." vs ".$po[3]->getNom()." ".$currentPoule->getNom()."\n";

                        $em->persist($M1);
                        $em->persist($M2);
                        $em->persist($M3);
                        $em->persist($M4);
                        $em->persist($M5);
                        $em->persist($M6);
                        break;

                    default:
                        echo "probleme";
                        break;
                }
            }

            $em->flush();
            echo "done";
          }
        ?>

          <script type="text/javascript">
            
              function update(){
                console.log("update");
                let poules = document.getElementById('poules').childNodes;
                poules.forEach((p) =>{
                  if(p.nodeType != 3){
                    equipes = p.childNodes;
                    equipes.forEach((eq)=>{
                        if(eq.tagName != "H2"){
                          $('#form').append("<input type='checkbox' name='"+p.attributes.id.value+"_"+eq.attributes.id.value+"' value=1 checked hidden>");
                        }
                    }); 
                  }
                });
              }

          </script>
      <script src="js/dragdrop.js"></script>
    </div>
  </body>
</html>
