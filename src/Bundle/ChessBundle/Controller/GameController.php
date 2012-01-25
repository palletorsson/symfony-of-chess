<?php
// src/Bundle/ChessBundle/Controller/GameController.php

namespace Bundle\ChessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Bundle\ChessBundle\Entity\Move;
use Bundle\ChessBundle\Entity\Game;

class GameController extends Controller
{
	private $current_move;
	private $gameid;
	
	public function indexAction(){
        return $this->render('BundleChessBundle::index.html.twig');
    }

    public function gameAction(){ 	

		$current_game = new Game();  
		$current_game -> createGame();		 

		$em = $this -> getDoctrine()-> getEntityManager();
		$em -> persist($current_game);
		$em -> flush();
        
        $this -> gameid = $current_game -> getGameid();
        
        return $this -> render('BundleChessBundle:Game:index.html.twig');    
	}
    
    public function moveAction($slug) {
		$em = $this -> getDoctrine()-> getEntityManager();
		
		$gameid = $em -> getRepository('BundleChessBundle:Game')
				      -> getGameid();
		
		$game = $em -> getRepository('BundleChessBundle:Game')
				    -> getGame($gameid);
					
		$gameboard = $game -> getGameboard();
		$turn = $game -> getTurn(); 	 
		//print_r($gameboard);
		//echo $turn;
		
		//move objekt, kolla moven	
		$this -> current_move = new Move($gameboard,$turn);
		
		$text = $slug;
		
		// the response DETTA ÄR DET ENDA SOM FAKTISKT KÖRS ÄN SÅ LÄNGE 		
		//Den manipulerade arrayen måste in i db nånstans.Var?
		if($this -> current_move -> move($slug)){
			
				if($turn == 'w'){
					$turn = 'b';
				}else if($turn == 'b'){
					$turn = 'w';
				}
			
				$updated_gameboard = $this -> current_move ->updateBoard($slug, $gameboard);
				
				$game -> setGameboard($updated_gameboard);
				$game -> setTurn($turn);
				
				$em -> persist($game);
				$em -> flush();
				//print_r($result);
				
				/*
				$em -> persist($updated_gameboard);
				$em -> flush();
				$em -> getRepository('BundleChessBundle:Game') -> updateTurn($turn);
				*/
				//uppdatera move också
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



