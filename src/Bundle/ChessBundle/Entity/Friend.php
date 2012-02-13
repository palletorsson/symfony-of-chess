<?php
namespace Bundle\ChessBundle\Entity;


class Friend
{
	protected $player;
	protected $player2;
	
	public function setPlayer2($name){
		$this -> player2 = $name;
	}

	public function getPlayer2(){
		return $this -> player2;
	}
	public function setPlayer($name){
		$this -> player = $name;
	}

	public function getPlayer(){
		return $this -> player;
	}

}

