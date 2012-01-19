<?php
// src/Bundle/ChessBundle/Controller/GameController.php

namespace Bundle\ChessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Bundle\ChessBundle\Entity\Game;

//include('../Entity/Game.php');
class GameController extends Controller
{
	private $current_game;
	
	public function indexAction(){
        return $this->render('BundleChessBundle::index.html.twig');
    }

    public function gameAction(){ 	
		//$_SESSION['turn']=1; // white
		$this -> current_game = new Game(); 		 		 
        return $this->render('BundleChessBundle:Game:index.html.twig');    
	}
    
    public function moveAction($slug) {
    	$this -> current_game = new Game();
		
		$text = $slug;
		// the response DETTA ÄR DET ENDA SOM FAKTISKT KÖRS ÄN SÅ LÄNGE 		
		
		if($this -> current_game -> move($slug)){
				$text = $slug;
		}else{
				$text = "Invalid move!";
		}
			
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



