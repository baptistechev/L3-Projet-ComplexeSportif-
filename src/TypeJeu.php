<?php

use Doctrine\Orm\Mapping as ORM;

/** @ORM\Entity **/
class TypeJeu{

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
     * @ORM\Column(name="description", type="string")
     */
    private $description;

    public function __construct($description){
    	$this->description = $description;
    }

    public function getDesc(){
    	return $this->description;
    }

}