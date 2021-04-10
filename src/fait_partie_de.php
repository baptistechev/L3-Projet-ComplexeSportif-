<?php

use Doctrine\Orm\Mapping as ORM;

/** @ORM\Entity **/
class Classement{ //Instance à créer via Poule::addEquipe

	/**
    *
    * @ORM\ManyToOne(targetEntity="Poule")
    * @ORM\JoinColumn(name="poule_id", referencedColumnName="id")
    * @ORM\Id
    */
	private $poule;

	/**
    *
    * @ORM\ManyToOne(targetEntity="Equipe")
    * @ORM\JoinColumn(name="nom_equipe", referencedColumnName="nom")
    * @ORM\Id
    */
	private $equipe;

	/**
     * @var int
     *
     * @ORM\Column(name="rang", type="integer")
     */
	private $rang;

	function __construct($poule, $equipe, $rang){
		$this->poule = $poule;
		$this->equipe = $equipe;
		$this->rang = $rang;
	}

    public function setRang($rang){
        $this->classement = $rang;
    }

    public function getRang(){
        return $this->rang;
    }

    public function getPoule(){
        return $this->poule;
    }

    public function getEquipe(){
        return $this->equipe;
    }

}