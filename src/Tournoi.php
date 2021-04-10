<?php

use Doctrine\Orm\Mapping as ORM;

/** @ORM\Entity **/
class Tournoi{

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
     * @ORM\Column(name="tour", type="integer")
     */
    private $tour;

    /**
    *
    * @ORM\ManyToOne(targetEntity="Evenement")
    * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id")
    */
    private $evenement;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="Equipe")
     * @ORM\JoinTable(name="tournoi_equipe",
     *      joinColumns={@ORM\JoinColumn(name="tournois", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="equipes", referencedColumnName="nom")}
     *      )
     */
    private $equipes;

    public function __construct($nom){
    	$this->nom = $nom;
        $this->equipes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tour = 0;
    }

    public function getId(){
        return $this->id;
    }

    public function getNom(){
    	return $this->nom;
    }

    public function getTour(){
        return $this->tour;
    }

    public function nextTour(){
        $this-> tour++;
    }

    public function setEvenement($evenement){
    	$this->evenement = $evenement;
    }

    public function getEvenement(){
        return $this->evenement;
    }

    public function addEquipe($equipe){
        $this->equipes->add($equipe);
        // $equipe->addTournoi($this);
    }

    public function getEquipes(){
        return $this->equipes;
    }
}