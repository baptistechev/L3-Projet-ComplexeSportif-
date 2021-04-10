<?php

  require_once "../bootstrap.php";
  require_once "../src/Organisateur.php";

  session_start();

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/formulaire.css">
    <title>Complexe Sportif</title>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="js/header.js"></script>
  </head>
  <body>
    <div id="header-placeholder"></div>
    <div class="corps">
      
      <?php
        if(isset($_POST['deco']))
          unset($_SESSION['connect']);

        if(!isset($_SESSION['connect'])){

          if(isset($_POST['login']) && $_POST['login']!="" && isset($_POST['password']) && $_POST['password'] != ""){

            $log = $_POST['login'];
            $pwd = md5($_POST['password']);
            
            $p=$em->getRepository('Organisateur')->findBy(array(
              'utilisateur' => $log,
              'mot_de_pass' => $pwd
            ));
            if (count($p)){
              echo "Connexion...";
              $_SESSION['connect'] = array();
              array_push($_SESSION['connect'], $p[0]->getUtilisateur());
              array_push($_SESSION['connect'], $p[0]->get_mot_de_pass());
              header("Refresh:0");
            }else{
              echo "<p>Login/Mot de passe incorrect !</p>";
            }
            
          }
          echo '<div class="Forms">
                  <h2>Connexion</h2>
                  <form class="LaForm" action="compte.php" method="post">
                    <p><input type="text" name="login" value="" placeholder="Nom d\'utilisateur" required></p>
                    <p><input type="password" name="password" value="" placeholder="Mot de passe" required></p>
                    <p><input id="submit" type="submit" name="connect" value="connect"></p>
                  </form>
                </div>';
        }else{
          echo "<div class='Forms'><p>Vous êtes connecté !</p>";
          echo "<p>Bonjour ".$_SESSION['connect'][0]." !</p>";
          echo '<form method="POST"><input type="submit" name="deco" value="Deconnexion"></form></div>';
        }
      ?>

    </div>
  </body>
</html>
