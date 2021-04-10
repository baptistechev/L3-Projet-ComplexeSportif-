<?php

use Doctrine\Orm\Mapping as ORM;

/** @ORM\Entity **/
class Joueur{

	/**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    /**
    * @var int
    *
    * @ORM\Column(name="niveau", type="integer")
    */
    private $niveau; //ajouter range constraint !!!!!

    /**
    *
    * @ORM\ManyToOne(targetEntity="Equipe")
    * @ORM\JoinColumn(name="nom_equipe", referencedColumnName="nom")
    */
    private $equipe;

    public function __construct($nom,$niveau){
    	$this->nom = $nom;
    	$this->niveau = $niveau;
    }

    public function getId(){
    	return $this->id;
    }

    public function getNom(){
    	return $this->nom;
    }

    public function getNiveau(){
    	return $this->niveau;
    }

    public function setEquipe($equipe){
    	$this->equipe = $equipe;
    }

}
