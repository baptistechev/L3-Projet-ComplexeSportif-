<?php

require_once "bootstrap.php";
require_once "src/TypeJeu.php";
require_once "src/Organisateur.php";


$t1 = new TypeJeu("Volley");
$t2 = new TypeJeu("Tennis");
$t3 = new TypeJeu("Foot");
$t4 = new TypeJeu("Ping-pong");

$O = new Organisateur("chef", "monMotDePAss", "Billy");

$em->persist($t1);
$em->persist($t2);
$em->persist($t3);
$em->persist($t4);

$em->persist($O);

$em->flush();
echo "done\n";