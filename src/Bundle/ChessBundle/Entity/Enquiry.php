<?php
// src/Blogger/BlogBundle/Entity/Enquiry.php

namespace Bundle\ChessBundle\Entity;

class Enquiry
{
    protected $player_1;

    protected $player_2;
	
	protected $saved_game;

    public function getPlayer1()
    {
        return $this->player_1;
    }

    public function setPlayer1($name)
    {
        $this->player_1= $name;
    }

    public function getPlayer2()
    {
        return $this->player_2;
    }

    public function setPlayer2($name)
    {
        $this->player_2 = $name;
    }
	
	public function getSavedGame()
    {
        return $this->saved_game;
    }

    public function setSavedGame($name)
    {
        $this->saved_game = $name;
    }
	

}