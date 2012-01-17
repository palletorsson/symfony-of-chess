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
		$_SESSION['turn']=1; // white
		$this -> current_game = new Game(); 		 		 
        return $this->render('BundleChessBundle:Game:index.html.twig');    
	}
    
    public function moveAction($slug) {	
		$string = $slug;
		// no checks are made, use functions below etc 
		$text = $string;
		
		// check if pattern is ok and make piece, from and to values in an array
		function makeValues($string) {
			// $pattern = "/^[0-9]{4}+[A-H]{1}+[0-9]{1}[-][A-H]{1}+[0-9]{1}/";
			// if (preg_match($pattern, $string)) {
					$string_array = explode('-', $string);
					$piece = $string_array[0]; 
					$from = $string_array[0]; 
					$to = $string_array[1];
					
			return array('piece'=>$piece, 'from'=>$from, 'to'=>$to); 		
		
			// }  else {
			// return "invalide syntax";
			// }
		}	
		
		// takes the int of the $piece and checks against black or white $turn
		function checkTurn($piece, $turn) {
			$black = array('rook'=>9820, 'bishop'=>9822, 'knight'=>9819, 'queen'=>9821, 'king'=>9818, 'pawn'=>9823);
			$white = array('rook'=>9814, 'bishop'=>9816, 'knight'=>9816, 'king'=>9815, 'queen'=>9813, 'pawn'=>9812);
			
			if (in_array($piece, $white) && $_SESSION['turn'] == 1) {
					echo "Whites turn!";			
			}
		}
				
		// $string = strtolower($string);
		// explode hand check that the input was of avalide type (a4-b6)
		// check that letter and number in right order.
		// check if moved farward and return string to board
		
		// basic white pawnMove, to make check black use negative numbers
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
		
		// the response 		
		

		$response = new Response();
		$response->setContent('<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
								<response>'.$text.'</response>');
		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/xml');
		// prints the XML headers followed by the content
		return $response; 
				
	} 

}



