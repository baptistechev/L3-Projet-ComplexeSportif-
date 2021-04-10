<?php

use Doctrine\Orm\Mapping as ORM;

/** @ORM\Entity **/
class Organisateur{

	/**
     * @var string
     *
     * @ORM\Column(name="utilisateur", type="string")
     * @ORM\Id
     */
    private $utilisateur;

	/**
     * @var string
     *
     * @ORM\Column(name="mot_de_pass", type="string")
     */
    private $mot_de_pass;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    public function __construct($utilisateur,$mot_de_pass, $nom){
    	$this->utilisateur = $utilisateur;
    	$this->mot_de_pass = md5($mot_de_pass);
    	$this->nom = $nom;
    }

    public function getUtilisateur(){
    	return $this->utilisateur;
    }    

    public function get_mot_de_pass(){
    	return $this->mot_de_pass;
    }

    public function getNom(){
    	return $this->nom;
    }
}