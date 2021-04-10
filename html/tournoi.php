<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/tournois.css">
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

      <h1>
        <?php
          $tournois=$em->getRepository('Tournoi')->findBy(array(
            'id' => $_GET["id"]
          ));
          $tournoi = $tournois[0];
          echo $tournoi->getNom();
        ?>
      </h1>

      <h2><a href="inscription.php?id=<?php echo $_GET['id'] ; ?>" >Lien d'inscription</a></h2>
      <h2><a href="classement.php?id=<?php echo $_GET['id'] ; ?>" >Résultats</a></h2>
      
      <div class="content">
        <section class="gauche">
          <article class="equipes">
            
            <h2>Liste des equipes</h2>
            <table>
              <tr>
                <th>Nom</th>
                <th>Niveau</th>
                <th>Club</th>
              </tr>

              <?php

                foreach($tournoi->getEquipes()->toArray() as $equipe){
                  echo sprintf("<tr>
                                  <td><a href='equipe.php?nom=%s'>%s</a></td>
                                  <td>%d</td>
                                  <td>%s</td>
                                </tr>", $equipe->getNom(), $equipe->getNom(), $equipe->getNiveau(), $equipe->getClub());
                }
              
              ?>
            </table>
          </article>
        </section>
        <section class="droite">
          <article class="infos">
            <h2>Infos</h2>
            <?php

              $e = $tournoi->getEvenement();
              echo sprintf("<section>
                            <h3>%s</h3>
                            <p>
                              Type : %s <br />
                              Lieu : %s <br />
                              Date : %s <br />
                            </p>
                            </section>",
                          $e->getNom(), $e->getTypeJeu()->getDesc(), $e->getLieu(), $e->getDate()->format('Y-m-d H:i'));

            ?>
          </article>
          <article class="matchs">
            <h2>Derniers Matchs</h2>

            <table>
              <tr>
                <th>Match</th>
                <th>Poule</th>
                <th>Score</th>
              </tr>

            <?php

                $poules = $em->getRepository('Poule')->findBy(array(
                  'tournoi' => $tournoi->getId(),
                  'tour' => $tournoi->getTour()
                ));

                foreach ($poules as $p) {
                  $matchs = $em->getRepository('MatchPoule')->findBy(array(
                    'poule' => $p->getId()
                  ));
                  foreach ($matchs as $m) {
                    if($m->getScore() != null){
                      echo sprintf("<tr>
                                      <td><a href='equipe.php?nom=%s'>%s</a> VS <a href='equipe.php?nom=%s'>%s</a></td>
                                      <td>%s</td>
                                      <td>%s</td>
                                    </tr>", $m->getEquipe1()->getNom(),$m->getEquipe1()->getNom(), $m->getEquipe2()->getNom(),$m->getEquipe2()->getNom(),$m->getPoule()->getNom(),$m->getScore()); 
                    }
                  }
                }

                

                
            ?>
          </table>
            <section class="button"><a href="poule.php?id=<?php echo $_GET['id']; ?>">Voir tous les matchs</a></section>

          </article>
          <article class="poules">
            <h2>Poules</h2>

            <?php

              $poules = $em->getRepository('Poule')->findBy(array(
                  'tournoi' => $tournoi->getId()
                ));

              

              foreach ($poules as $po) {
                $equi = array();
                echo sprintf("<section class='poule'><h4>%s</h4><p> Format : %s Tour : %d <br />",$po->getNom(), $po->getFormat(), $po->getTour());
                $matchs = $em->getRepository('MatchPoule')->findBy(array(
                  'poule' => $po->getId()
                ));
                foreach ($matchs as $m) {
                  if(!in_array($m->getEquipe1(), $equi)){
                    array_push($equi, $m->getEquipe1());
                    echo sprintf("<a href='equipe.php?nom=%s'>%s</a><br />", $m->getEquipe1()->getNom(),$m->getEquipe1()->getNom());
                  }
                  if(!in_array($m->getEquipe2(), $equi)){
                    array_push($equi, $m->getEquipe2());
                    echo sprintf("<a href='equipe.php?nom=%s'>%s</a><br />", $m->getEquipe2()->getNom(),$m->getEquipe2()->getNom());
                  }
                }
                echo "</section>";
              }
            ?>

          </article>
        </section>
      </div>
    </div>
  </body>
</html>
