<?php
// src/Blogger/BlogBundle/Entity/Enquiry.php

namespace Bundle\ChessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * 
 @ORM\Entity(repositoryClass="Bundle\ChessBundle\Repository\PlayerRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */


class Player
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */

	 protected $playerid;
	
	/**
	 * @ORM\Column(type="string", length="40")
	 */
    protected $player;

	/**
	 * @ORM\Column(type="string", length="40")
	 */
    protected $player2;

	/**
	 * @ORM\Column(type="string", length="256")
	 */
 	protected $password;
	
	/**
	 * * @ORM\Column(type="string", length="40")
	 */
 	protected $salt;

	/**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="game")
     */
    protected $games;
    
	
	public function __construct(){
		$this -> games = new ArrayCollection();
	}
	
    /**
     * Get playerid
     *
     * @return integer 
     */
    public function getPlayerid()
    {
        return $this->playerid;
    }

    /**
     * Set player
     *
     * @param string $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }

    /**
     * Get player
     *
     * @return string 
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Add games
     *
     * @param Bundle\ChessBundle\Entity\Game $games
     */
    public function addGame(\Bundle\ChessBundle\Entity\Game $games)
    {
        $this->games[] = $games;
    }

    /**
     * Get games
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Set player2
     *
     * @param string $player2
     */
    public function setPlayer2($player2)
    {
        $this->player2 = $player2;
    }

    /**
     * Get player2
     *
     * @return string 
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * Set player1
     *
     * @param string $player1
     */
    public function setPlayer1($player1)
    {
        $this->player1 = $player1;
    }

    /**
     * Get player1
     *
     * @return string 
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }
}