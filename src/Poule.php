<?php

use Doctrine\Orm\Mapping as ORM;

/** @ORM\Entity **/
class Poule{

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
     * @var string
     *
     * @ORM\Column(name="format", type="string")
     */
    private $format;

    /**
     * @var int
     *
     * @ORM\Column(name="tour", type="integer")
     */
    private $tour;

    /**
    *
    * @ORM\ManyToOne(targetEntity="Tournoi")
    * @ORM\JoinColumn(name="tournoi_id", referencedColumnName="id")
    */
    private $tournoi;

    private $equipes;

    private $rel;

    public function __construct($nom, $format, $tour){
    	$this->nom = $nom;
    	$this->format = $format;
    	$this->tour = $tour;
    	$this->equipes = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->rel = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(){
        return $this->id;
    }

    public function getNom(){
    	return $this->nom;
    }

    public function getFormat(){
    	return $this->format;
    }

    public function setFormat($format){
        $this->format = $format;
    }

    public function getTour(){
    	return $this->tour;
    }

    public function addEquipe($equipe){

    	$f = new Fait_partie_de($this,$equipe, -1);

    	$this->equipes->add($equipe);
    	$this->rel->set($equipe->getNom(), $f);
    	$equipe->addPoule($this);
    	
    	return $f;
    }

    public function setClassement($equipe, $classement){
    	if($this->equipes->contains($equipe)){
    		$this->rel->get($equipe->getNom())->setClassement($classement);
    	}else{
    		echo $equipe->getNom()." n'est pas dans la poule ".$this->getNom()."\n";
    	}
    }

    public function getClassement($equipe){
    	if($this->equipes->contains($equipe)){
    		return $this->rel->get($equipe->getNom())->getClassement();
    	}else{
    		echo $equipe->getNom()." n'est pas dans la poule ".$this->getNom()."\n";
    	}
    }

    public function setTournoi($tournoi){
        $this->tournoi = $tournoi;
    }

    public function getTournoi(){
        return $this->tournoi;
    }
}