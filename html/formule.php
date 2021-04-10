<h3>Formule</h3>
    <form class="formules" method="post" action="gestion.php?id=<?php echo $_GET['id'] ?>">
        <button name="formule" value="2">Poules de 2 equipes</button>
        <button name="formule" value="3">Poules de 3 equipes</button>
        <button name="formule" value="4">Poules de 4 equipes</button>
    </form>

<?php

	if(isset($_POST["formule"])){
		
		$nbE = $_POST["formule"]; //nb equipe par poule

		// echo $nbE."x".$nbP;

		$equipes = $tournoi->getEquipes()->toArray();

		$tournoi->nextTour();
		creerPoules($nbE, $equipes, $tournoi, $em);

		header("Refresh:0");
		
	}
?>