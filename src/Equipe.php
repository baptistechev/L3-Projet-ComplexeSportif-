<?php

use Doctrine\Orm\Mapping as ORM;

/** @ORM\Entity **/
class Equipe{

	/**
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     * @ORM\Id
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="niveauE", type="integer")
     */
    private $niveauE; //moyenne du niveau des joueurs !!!!ajouter range constraint

    /**
     * @var string
     *
     * @ORM\Column(name="club", type="string")
     */
    private $club;

    private $tournois;

    private $joueurs;

    private $poules; 

    public function __construct($nom, $club){
    	$this->nom = $nom;
    	$this->club = $club;
    	$this->joueurs = new \Doctrine\Common\Collections\ArrayCollection();
  		$this->niveauE = 0;
  		$this->tournois = new \Doctrine\Common\Collections\ArrayCollection();
        $this->poules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getNom(){
    	return $this->nom;
    }

    public function getNiveau(){
    	return $this->niveauE;
    }

    public function getClub(){
    	return $this->club;
    }

    public function addJoueur($j){
    	$this->joueurs->add($j);

    	$j->setEquipe($this);

    	$n = 0;
    	foreach($this->joueurs as $jo){
    		$n += $jo->getNiveau();
    	}
    	$n /= $this->joueurs->count();
    	$this->niveauE = $n;
    }

    public function addTournoi($tournoi){//!!Ne pas utiliser directement --> voir Tournoi::addEquipe
    	$this->tournois->add($tournoi);
    }

    public function getTournois(){
    	return $this->tournois;
    }

    public function addPoule($poule){//!!Ne pas utiliser directement --> voir Poule::addEquipe
        $this->poules->add($poule);
    }

    public function getCurrentPoule(){
        return $this->poules->last();
    }

    public function getClassementPoule(){ //retourne le classement dans la poule courante
        return $this->getCurrentPoule()->getClassement($this);
    }

}