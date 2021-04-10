<?php
	session_start();
?>
<header>
      <ul>
        <!-- Logo? -->
        <li><a href="index.php">Home</a></li>
        <!-- <li><a href="tournois.html">Tournois</a></li> -->
        <?php if(isset($_SESSION['connect'])){ echo "<li><a href='admin.php'>Administration</a></li>"; } ?>
        <li><a class="connect" href="compte.php"><?php
        												if(isset($_SESSION['connect'])){
        													echo "Deconnexion";
        												}else{
        													echo "Connexion";
        												}
        											?></a></li>
      </ul>
</header>