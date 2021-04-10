<?php
	$poules=$em->getRepository('Poule')->findBy(array(
      	'tournoi' => $_GET['id']
    ));

    foreach ($poules as $p) {
    	$matchs=$em->getRepository('MatchPoule')->findBy(array(
	      	'poule' => $p->getId()
	    ));
    	$points = array();

    		foreach ($matchs as $m) {

    			if(!isset($points[$m->getEquipe1()->getNom()]))
	    			$points[$m->getEquipe1()->getNom()] = 0;
	    		if(!isset($points[$m->getEquipe2()->getNom()]))
	    			$points[$m->getEquipe2()->getNom()] = 0;

				$score = explode("-", $m->getScore());
				if($score[0]>$score[1])
			    	$points[$m->getEquipe1()->getNom()]++;
			    if($score[0]<$score[1])
			    	$points[$m->getEquipe2()->getNom()]++;
		    }
		// print_r($points);

		$points2 = array();
		$fin = count($points);
		while($fin != count($points2)){
			$max = 0;
			$nom = "";
			foreach ($points as $k => $v) {
				if($v >= $max){
					$max = $v;
					$nom = $k;
				}
			}
			$points2[$nom] = $max;
			unset($points[$nom]);
		}

		// print_r($points2);

		$i = 1;
		$equipes=$tournoi->getEquipes();
		foreach ($points2 as $nom => $pts) {
			foreach ($equipes as $eq) {
				if($nom == $eq->getNom()){
					$classements=$em->getRepository('Classement')->findBy(array(
				      	'poule' => $p->getId(),
				      	'equipe' => $eq->getNom()
				    ));
				    if(isset($classements[0])){
				    	$em->remove($classements[0]);
				    	$em->flush();
				    }
					$c = new Classement($p, $eq, $i);
					$i++;
					$em->persist($c);
					$em->flush();
				}
			}
		}
    }

    if(isset($_POST['fin'])){

    	header("Location: classement.php?id=".$_GET['id']);

    }else{

    $poules=$em->getRepository('Poule')->findBy(array(
      	'tournoi' => $_GET['id'],
      	'tour' => $tournoi->getTour()
    ));

    $eq=$em->getRepository('Classement')->findBy(array(
      	'poule' => $poules[0]->getId()
    ));

    $nbEqPoule = count($eq);
?>

<form class="next" method="post" action="gestion.php?id=<?php echo $_GET['id']; ?>" >
	<p><label for="nb">Nombre d'equipe a garder par poule</label><input type="number" name="nb" value=1 /></p>
	<p><label>Poules de 2 Equipes</label><input type="radio" name="formule" value=2 <?php if($nbEqPoule == 2) echo 'checked' ?>></p>
	<p><label>Poules de 3 Equipes</label><input type="radio" name="formule" value=3 <?php if($nbEqPoule == 3) echo 'checked' ?>></p>
	<p><label>Poules de 4 Equipes</label><input type="radio" name="formule" value=4 <?php if($nbEqPoule == 4) echo 'checked' ?>><p>
	<p><label for="perdants">Creer un tournoi pour les perdants </label><input type="radio" name="perdants" value="tournoi">
		<label for="perdants">Creer une poule pour les perdants </label><input type="radio" name="perdants" value="poule"></p>
	<p><input id="val" type="submit" name="update" value="Valider"></p>
</form>

<?php } ?>