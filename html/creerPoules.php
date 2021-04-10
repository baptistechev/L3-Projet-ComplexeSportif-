<?php

function creerPoules($nbE, $equipes, $tournoi, $em){

    // $equipes = $equipes->toArray();

    $nbETot = count($equipes); //nb equipe total

    $nbP = $nbETot / $nbE; //nb de poules
    if( $nbETot % $nbE !=0){
        $nbP = floor($nbP) + 1;
    }

    $p=$em->getRepository('Poule')->findBy(array(
        'tournoi' => $tournoi->getId()
    ));

    $poules = array();
    // $curseur = 0;
    for ($i=1; $i <= $nbP; $i++) {
        echo "creation de la Poule" . ($i+count($p))."\n";
        $poules[$i] = new Poule("Poule".($i+count($p)), "", $tournoi->getTour());
        $poules[$i]->setTournoi($tournoi);
        $em->persist($poules[$i]);
    }

    $Poules = array();
    for ($i=1; $i <= $nbP; $i++) { 
        $Poules[$i] = array();
    }

    $sens = 1;
    $compteur = 1;
    while(!empty($equipes)){
        array_push($Poules[$compteur], array_shift($equipes));
        if($sens == 1){
            $compteur++;
            if($compteur >$nbP){
                $sens = -1;
                $compteur--;
            }
        }else if($sens = -1){
            $compteur--;
            if($compteur < 1){
                $sens = 1;
                $compteur++;
            }
        }
    }

    for ($i=1; $i <= $nbP; $i++) { 
        for ($j=0; $j < $nbE; $j++) { 
            if(isset($Poules[$i][$j]))
                echo $Poules[$i][$j]->getNom()." ";
        }
        echo "\n";
    }
    
    foreach ($Poules as $ind => $po) {
        switch (count($po)) {
            case 2:
                
                $M1 = new MatchPoule($po[0], $po[1], $poules[$ind],"");
                echo "creation match ".$po[0]->getNom()." vs ".$po[1]->getNom()." ".$poules[$ind]->getNom()."\n";

                $em->persist($M1);
                break;

            case 3:
                $M1 = new MatchPoule($po[0], $po[1], $poules[$ind],"");
                $M2 = new MatchPoule($po[1], $po[2], $poules[$ind],"");
                $M3 = new MatchPoule($po[0], $po[2], $poules[$ind],"");
                echo "creation match ".$po[0]->getNom()." vs ".$po[1]->getNom()." ".$poules[$ind]->getNom()."\n";
                echo "creation match ".$po[1]->getNom()." vs ".$po[2]->getNom()." ".$poules[$ind]->getNom()."\n";
                echo "creation match ".$po[0]->getNom()." vs ".$po[2]->getNom()." ".$poules[$ind]->getNom()."\n";

                $em->persist($M1);
                $em->persist($M2);
                $em->persist($M3);
                break;



            case 4:
                $M1 = new MatchPoule($po[0], $po[1], $poules[$ind],"");
                $M2 = new MatchPoule($po[0], $po[2], $poules[$ind],"");
                $M3 = new MatchPoule($po[0], $po[3], $poules[$ind],"");
                $M4 = new MatchPoule($po[1], $po[2], $poules[$ind],"");
                $M5 = new MatchPoule($po[1], $po[3], $poules[$ind],"");
                $M6 = new MatchPoule($po[2], $po[3], $poules[$ind],"");
                echo "creation match ".$po[0]->getNom()." vs ".$po[1]->getNom()." ".$poules[$ind]->getNom()."\n";
                echo "creation match ".$po[0]->getNom()." vs ".$po[2]->getNom()." ".$poules[$ind]->getNom()."\n";
                echo "creation match ".$po[0]->getNom()." vs ".$po[3]->getNom()." ".$poules[$ind]->getNom()."\n";
                echo "creation match ".$po[1]->getNom()." vs ".$po[2]->getNom()." ".$poules[$ind]->getNom()."\n";
                echo "creation match ".$po[1]->getNom()." vs ".$po[3]->getNom()." ".$poules[$ind]->getNom()."\n";
                echo "creation match ".$po[2]->getNom()." vs ".$po[3]->getNom()." ".$poules[$ind]->getNom()."\n";

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









// $tournois=$em->getRepository('Tournoi')->findBy(array(
//     'id' => 9
// ));
// $tournoi = $tournois[0];
// $equipes=$tournoi->getEquipes();

// creerPoules(, $equipes, $tournoi, $em);

?>