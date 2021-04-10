<?php

use Doctrine\Orm\Mapping as ORM;

/** @ORM\Entity **/
class Evenement{

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
     * @ORM\Column(name="lieu", type="string")
     */
    private $lieu;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
    *
    * @ORM\ManyToOne(targetEntity="TypeJeu")
    * @ORM\JoinColumn(name="typeJeu_id", referencedColumnName="id")
    */
    private $typeJeu;

    /**
     * @var int
     *
     * @ORM\Column(name="nbJEquipe", type="integer")
     */
    private $nbJEquipe;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    /**
    * @var int
    *
    * @ORM\Column(name="nbTournoi", type="integer")
    */
    private $nbTournoi;

    private $listeTournois;

    public function __construct($lieu, $date, $typeJeu, $nom, $nbJEquipe){
    	$this->lieu = $lieu;
    	$this->date = $date;
    	$this->typeJeu = $typeJeu;
    	$this->nom = $nom;
        $this->nbJEquipe = $nbJEquipe;
    	$this->nbTournoi = 0;
        $this->listeTournois = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(){
    	return $this->id;
    }

    public function getLieu(){
    	return $this->lieu;
    }

    public function getDate(){
    	return $this->date;
    }

    public function getTypeJeu(){
    	return $this->typeJeu;
    }

    public function getNom(){
    	return $this->nom;
    }

    public function getNbTournoi(){
        return $this->nbTournoi;
    }

    public function getNbJEquipe(){
        return $this->nbJEquipe;
    }

    //Ajouter setter si besoin

    public function addTournoi($tournoi){
    	$this->nbTournoi++;
        $tournoi->setEvenement($this);
        $this->listeTournois->add($tournoi);
    }

    public function getListeTournois(){
        return $this->listeTournois;
    }

}