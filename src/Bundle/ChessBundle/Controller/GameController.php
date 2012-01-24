<?php
// src/Bundle/ChessBundle/Controller/GameController.php

namespace Bundle\ChessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Bundle\ChessBundle\Entity\Move;
use Bundle\ChessBundle\Entity\Game;

class GameController extends Controller
{
	private $current_game;
	private $current_move;
	
	public function indexAction(){
        return $this->render('BundleChessBundle::index.html.twig');
    }

    public function gameAction(){ 	
		//$_SESSION['turn']=1; // white
		$this -> current_game = new Game();  
		$this -> current_game -> createGame();		 
        return $this->render('BundleChessBundle:Game:index.html.twig');    
	}
    
    public function moveAction($slug) {
		$em = $this -> getDoctrine()-> getEntityManager();
					 
		/*$gameid = $em -> getRepository('BundleChessBundle:Game') 
					  -> getGameId();
		*/
		$gameboard = $em -> getRepository('BundleChessBundle:Game')
						 -> getGameboard(1);
						 
		$turn = $em -> getRepository('BundleChessBundle:Game')
					-> getTurn();

		$this -> current_move = new Move($gameboard,$turn);
		
		$text = $slug;
		
		// the response DETTA ÄR DET ENDA SOM FAKTISKT KÖRS ÄN SÅ LÄNGE 		
		//Den manipulerade arrayen måste in i db nånstans.Var?
		if($this -> current_move -> move($slug)){
				$updated_gameboard = $this -> current_move -> updateBoard($slug, $gameboard);
				$em -> getRepository('BundleChessBundle:Game') -> updateGameboard(1,$updated_gameboard);
				//ändra i databasen 1. titta på array 2. titta på movet dvs A3-A4 3. ändra enligt move
				$text = $slug;
		}else{
				$text = "Invalid move!";
		}
		
		//här är xml:en som skickas som svar till ajax-requestet
		$response = new Response();
		$response->setContent('<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
								<response>'.$text.'</response>');
		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/xml');
		// prints the XML headers followed by the content
		return $response; 
		
		
		function whitePawnMove($from, $to) {
			if ($from+1 == $to) { 
				return true;  
			} else {
				return false;
			}
		}

		function blackPawnMove($from, $to) {
			if ($from-1 == $to) { 
				return true;  
			} else {
				return false;
			}
		}
		
			
	} 

}



