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
		
		// move objekt, kolla moven	
		$this -> current_move = new Move($gameboard,$turn);
		
		// Den manipulerade arrayen sparas i db. 
		$move_var = $this -> current_move -> move($slug);
		
		if ($move_var > 200) {
				$text = $move_var;
		} else if ($move_var == 100) {
				if($turn == 'w') {
					$turn = 'b';
				}else if($turn == 'b'){
					$turn = 'w';
				}
			
				$updated_gameboard = $this -> current_move ->updateBoard($slug, $gameboard);
				
				$game -> setGameboard($updated_gameboard);
				$game -> setTurn($turn);
				
				$em -> persist($game);
				$em -> flush();
				
				$text = $slug;
		}  else if ($move_var == 101) {
				
				$updated_gameboard = $this -> current_move ->updateBoardCrown($slug, $gameboard, $turn);
				
				$game -> setGameboard($updated_gameboard);
				if($turn == 'w') {
					$turn = 'b';
				}else if($turn == 'b'){
					$turn = 'w';
				}
				
				$game -> setTurn($turn);
				
				$em -> persist($game);
				$em -> flush();
				
				$text = "101".$slug.$turn;
		}
		
		else {
				// kommer att returnera felkod
		// $text = $move_var;
		} 
		
		//här är xml:en som skickas som svar till ajax-requestet
		$response = new Response();
		$response->setContent('<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
								<response>'.$text.'</response>');
		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/xml');
		// prints the XML headers followed by the content
		return $response; 
		
		
			
	} 

}



