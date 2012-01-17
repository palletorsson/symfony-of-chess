<?php
// src/Bundle/ChessBundle/Controller/GameController.php

namespace Bundle\ChessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
		
class GameController extends Controller
{
	public function indexAction()
    {
        return $this->render('BundleChessBundle::index.html.twig');
    }

    public function gameAction()
    { 	
		$_SESSION['turn']=1; // white 		 
        return $this->render('BundleChessBundle:Game:index.html.twig');    
	}
    
    public function moveAction($slug) {	
		$string = $slug;
		// no checks are made, use functions below etc 
		$text = $string;
		
		function makeValues($string) {
			$pattern = "/^[0-9]{4}+[A-H]{1}+[0-9]{1}[-][A-H]{1}+[0-9]{1}/";
			if (preg_match($pattern, $string)) {
					$string_array = explode('-', $string);
					$from = $string_array[0]; 
					$to = $string_array[1];
					
			return array('from'=>$from, 'to'=>$to); 		
		
			}  else {
			return "invalide syntax";
			}
		}	
		
		
		// $string = strtolower($string);
		// explode hand check that the input was of avalide type (a4-b6)
		// check that letter and number in right order.
		// check if moved farward and return string to board
		
		function pawnMove() {
			if ($string[1]+1 == $string[4]) { 
				$string_array = explode('-', $string);
				$from = $string_array[0]; 
				$to = $string_array[1];
				$text = $from.":".$to; 
			} else {
				$text = "invalide move";
			}
		}

		function checkTurn($piece, $turn) {
			$black = array('rook'=>9820, 'bishop'=>9822, 'knight'=>9819, 'queen'=>9821, 'king'=>9818, 'pawn'=>9823);
			$white = array('rook'=>9814, 'bishop'=>9816, 'knight'=>9816, 'king'=>9815, 'queen'=>9813, 'pawn'=>9812);
			
			if (in_array($piece, $white) && $_SESSION['turn'] == 1) {
					echo "Whites turn!";			
			}
		}
		
		// the reponse 		
		

		$response = new Response();
		$response->setContent('<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
								<response>'.$text.'</response>');
		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/xml');
		// prints the XML headers followed by the content
		return $response; 
				
	} 

}



