<?php

use Doctrine\Orm\Mapping as ORM;

/** @ORM\Entity **/
class MatchPoule{

	/**
    *
    * @ORM\ManyToOne(targetEntity="Equipe")
    * @ORM\JoinColumn(name="equipe1", referencedColumnName="nom")
    * @ORM\Id
    */
	private $equipe1;

	/**
    *
    * @ORM\ManyToOne(targetEntity="Equipe")
    * @ORM\JoinColumn(name="equipe2", referencedColumnName="nom")
    * @ORM\Id
    */
	private $equipe2; //ajouter une contraine equipe1 != equipe2

	/**
    *
    * @ORM\ManyToOne(targetEntity="Poule")
    * @ORM\JoinColumn(name="poule_id", referencedColumnName="id")
    * @ORM\Id
    */
	private $poule;

	/**
     * @var string
     *
     * @ORM\Column(name="score", type="string")
     */
	private $score;

	/**
     * @var string
     *
     * @ORM\Column(name="terrain", type="string")
     */
	private $terrain;

	public function __construct($equipe1, $equipe2, $poule, $terrain){ //gerer les conditions

		$this->equipe1 = $equipe1;
		$this->equipe2 = $equipe2;
		$this->poule = $poule;
		$this->terrain = $terrain;
		$this->score = "";
	}

	public function getEquipe1(){
		return $this->equipe1;
	}

	public function getEquipe2(){
		return $this->equipe2;
	}

	public function getPoule(){
		return $this->poule;
	}

	public function getScore(){
		return $this->score;
	}

	public function getTerrain(){
		return $this->terrain;
	}

	public function setScore($score){
		$this->score = $score;
	}

	public function setTerrain($terrain){
		$this->terrain = $terrain;
	}
}