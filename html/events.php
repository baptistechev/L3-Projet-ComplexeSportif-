<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/events.css">
    <title>Complexe Sportif</title>
    <script src="js/jquery.min.js"></script>
    <script src="js/header.js"></script>
  </head>
  <body>
    <div id="header-placeholder"></div>

    <div class="corps">
        <?php
            require_once "../bootstrap.php";
            require_once "../src/TypeJeu.php";
            require_once "../src/Evenement.php";
            require_once "../src/Tournoi.php";
            require_once "../src/Equipe.php";
        ?>

        <h1>Créer un évenement</h1>
        <!-- Formulaire création d'un évènement-->
        <form action="events.php" method="post">

            <p>
              <label for="type_de_jeu">Type de jeu </label>
              <select name="type_de_jeu">
                <?php
                    $typeJeu=$em->getRepository('TypeJeu')->findAll();
                    foreach ($typeJeu as $t) {
                        echo sprintf("<option value='%s'>%s</option>", $t->getDesc(),$t->getDesc()); 
                    }
                ?>
              </select>
              <label for="nbJ">1 joueur</label><input type="radio" name="nbJ" value="1">
              <label for="nbJ">2 joueurs</label><input type="radio" name="nbJ" value="2">
              <label for="nbJ">3 joueurs</label><input type="radio" name="nbJ" value="3">
              <label for="nbJ">4 joueurs</label><input type="radio" name="nbJ" value="4">
              <label for="nbJ">11 joueurs</label><input type="radio" name="nbJ" value="11">
            </p>

            <p>
                <h3>Informations</h3>
                <input type="text" name="titre" value="" placeholder="Titre de l'évènement" required>
                <input type="text" name="lieu" value="" placeholder="Lieu" required>
                <input type="date" name="date" value="" placeholder="Date" required>
            </p>
            <p>
                <label for="nb"></label>Nombre de tournois <input type="number" name="nbTournoi" id="nb" value=1 />
            </p>
            <div id="tournois"></div>
            <p><input type="submit" name="sent" value="envoyer"></p>


            <script type="text/javascript">

                var nbForm = 1;
                genForm();

                $('#nb').on('input', function() {
                    nbForm = document.getElementById('nb').value;
                    genForm();
                });

                function genForm(){
                    if(nbForm<=0)
                        nbForm = 1;
                    document.getElementById('tournois').innerHTML = "";
                    for(let i = 0; i<nbForm;i++){
                        var form = "<p>\
                                <h3>Tournoi "+(i+1)+"</h3>\
                            <input type='text' name='nomTournoi"+i+"' value='' placeholder='Nom du tournoi' required>\
                            </p>";
                        document.getElementById('tournois').innerHTML += form;
                    }
                }

            </script>

            <?php

                if(isset($_POST["sent"])){

                    foreach ($typeJeu as $t) {
                        if($t->getDesc() == $_POST["type_de_jeu"]){
                            $type = $t;
                        }
                    }

                    $date = new DateTime($_POST["date"]);
                    $e = new Evenement($_POST["lieu"], $date, $type, $_POST["titre"], $_POST["nbJ"]);
                    $em->persist($e);
                    for ($i=0; $i < $_POST["nbTournoi"]; $i++) { 
                        $T = new Tournoi($_POST["nomTournoi".$i]);
                        $e->addTournoi($T);
                        $em->persist($T);
                    }

                    $em->flush();
                    echo "<h2>Votre Evenement a été créé avec succés !</h2>";
                }

            ?>
        </form>

    </div>
  </body>
</html>
