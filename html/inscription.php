<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/formulaire.css">
    <link rel="stylesheet" href="css/inscription.css">
    <title>Complexe Sportif</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/header.js"></script>
    <script type="text/javascript">
      var clicked = false;
      var nbJoueurs = 0;
      function generationForm(nbJoueurs){
        console.log(nbJoueurs);
        let html = "<div class=\"item\" >";
        for (var i = 0; i < nbJoueurs; i++){
          html+="<input type=\"text\" name=\"nomJ"+i+"\" placeholder=\"Nom du joueur\" required><label for=\"niv"+i+"\">loisir</label><input type=\"radio\" name=\"niv"+i+"\" value=\"loi\"><label for=\"niv"+i+"\">régional</label><input type=\"radio\" name=\"niv"+i+"\" value=\"reg\"><label for=\"niv"+i+"\">N3</label><input type=\"radio\" name=\"niv"+i+"\"value=\"n3\"><label for=\"niv"+i+"\">N2</label><input type=\"radio\" name=\"niv"+i+"\" value=\"n2\"><label for=\"niv"+i+"\">Pro</label><input type=\"radio\" name=\"niv"+i+"\" value=\"pro\"><br>"
        }
        html+="</div>"
        if(clicked){
          $('.item').hide();
          clicked = false;
        }else{
          $(".laForm").append(html);
          clicked = true;
        }
        $(".laForm").append("<input type=\"submit\" name=\"register\" value=\"inscrire\">");
      }
    </script>
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
        require_once "../src/Joueur.php";
    ?>
    <div class="Forms">
      <h2>Inscription Equipe</h2>
        <form class="laForm" action="inscription.php?id=<?php echo $_GET['id']; ?>" method="post">
          <input type="text" name="nomEquipe" placeholder="Nom de l'équipe" required><br>
          <input type="text" name="nomClub" placeholder="Nom du club (facultatif)" ><br>
          <i>Pour chaque joueur, selectionnez un niveau</i>
        </form>
    </div>
    <?php
      //Affichage du bon nombre d'entrée de joueurs
      $tournoi = $em->getRepository('Tournoi')->findBy(array(
      'id' => $_GET["id"]
      ));
      $event = $tournoi[0]->getEvenement();
      $nb = $event->getNbJEquipe();
      if($nb == null){
        echo"<h3>*Erreur lors de la requête*</h3>";
      }else{
        echo "<script>
        var nbJoueurs=".$nb.";
        generationForm(nbJoueurs);
        console.log(\"done\");
        </script>";
      }

      //Ajout dans la BD
      $niveau = 0;
      if(isset($_POST["register"])){
        $equipe = new Equipe($_POST["nomEquipe"],$_POST["nomClub"]);

        for($i=0; $i<$nb; $i++) {
          //Nom joueur 1: $_POST["nomJ".$i]
          //Niv joueur 1: $_POST["niv".$i]
          if($_POST["niv".$i] == "loi")
            $niveau = 1;
          elseif($_POST["niv".$i] == "reg")
            $niveau = 2;
          elseif($_POST["niv".$i] == "n3")
            $niveau = 3;
          elseif($_POST["niv".$i] == "n2")
            $niveau = 4;
          elseif($_POST["niv".$i] == "pro")
            $niveau = 5;

          $joueur = new Joueur($_POST["nomJ".$i],$niveau);
          $equipe->addJoueur($joueur);
          $em->persist($joueur);
          $em->persist($equipe);
        }
        $tournoi[0]->addEquipe($equipe);
        $em->flush();
        //Lier également à tournoi_equipe
        echo "<h2>L'équipe \"".$equipe->getNom()."\" à bien été inscrite</h2>";
      }
      ?>

  </body>
</html>
