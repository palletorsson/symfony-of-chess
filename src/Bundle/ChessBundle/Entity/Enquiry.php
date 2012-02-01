<?php
// src/Blogger/BlogBundle/Entity/Enquiry.php

namespace Bundle\ChessBundle\Entity;

class Enquiry
{
    protected $player1;

    protected $player2;

    public function getPlayer1()
    {
        return $this->player1;
    }

    public function setPlayer1($name)
    {
        $this->player1= $name;
    }

    public function getPlayer2()
    {
        return $this->player2;
    }

    public function setPlayer2($name)
    {
        $this->player2 = $name;
    }

}