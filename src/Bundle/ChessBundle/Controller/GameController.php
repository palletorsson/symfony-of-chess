<?php
// src/Bundle/ChessBundle/Controller/GameController.php

namespace Bundle\ChessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Bundle\ChessBundle\Entity\Move;
use Bundle\ChessBundle\Entity\Game;
use Bundle\ChessBundle\Entity\Enquiry;
use Bundle\ChessBundle\Form\EnquiryType;

class GameController extends Controller
{
	private $current_move;
	private $gameid;
	
	public function indexAction(){
		$enquiry = new Enquiry();
	    $form = $this->createForm(new EnquiryType(), $enquiry);
	
	    $request = $this->getRequest();
	    if ($request->getMethod() == 'POST') {
	        $form->bindRequest($request);
	
	        if ($form->isValid()) {
	            // Perform some action, such as sending an email
	
	            // Redirect - This is important to prevent users re-posting
	            // the form if they refresh the page
	            return $this->redirect($this->generateUrl('BundleChessBundle_game'));
	        }
	    }

    	return $this->render('BundleChessBundle::index.html.twig', array(
        	'form' => $form->createView()
    	));

        //return $this->render('BundleChessBundle::index.html.twig');
    }

    public function gameAction(){
    	// print_r($_POST);

		$p1 = $_POST['players']['player_1'];
		$p2 = $_POST['players']['player_2'];
		$savedgame = $_POST['players']['saved_game'];
		echo $savedgame; 
		/* if($savedgame){
			$em = $this -> getDoctrine()-> getEntityManager();
			$current_game = $em -> getRepository('BundleChessBundle:Game')
					            -> getGame($savedgame);
						
			$p1 = $current_game -> getPlayer1();
			$p2 = $current_game -> getPlayer2();
			$this -> gameid = $savedgame;
			
		}else{ */
			$current_game = new Game();
			$current_game -> createGame($p1, $p2);		 
	
			$em = $this -> getDoctrine()-> getEntityManager();
			$em -> persist($current_game);
			$em -> flush();
	        
	        $this -> gameid = $current_game -> getGameid();
	//	}
        return $this -> render('BundleChessBundle:Game:index.html.twig', array(
        	'player1' => $p1,
        	'player2' => $p2
    	));    
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
		//echo $gameid;
		
		// move objekt, kolla moven	
		$this -> current_move = new Move($gameboard,$turn);
		
		// Den manipulerade arrayen sparas i db. 
		$move_var = $this -> current_move -> move($slug);
		
		if ($move_var > 200) {
				$text = $move_var;
			
		} else if ($move_var == 100) {
				if($turn == 'w') {
					$turn = 'b';
					//Här under fyller vi på whitedraws-listan med det vita draget
					if($game -> getWhitedraws()){
						$whitedraws = $game -> getWhitedraws();  //hämta ut arrayen om den finns
					}else{
						$whitedraws = array(); //annars gör en ny array
					}
					$whitedraws[] = $slug;  //fyll på med draget
					$game -> setWhitedraws($whitedraws);

				}else if($turn == 'b'){
					$turn = 'w';
					//Här under fyller vi på blackdraws-listan med det svarta draget
					if($game -> getBlackdraws()){
						$blackdraws = $game -> getBlackdraws();  //hämta ut arrayen om den finns
					}else{
						$blackdraws = array(); //annars gör en ny array
					}
					$blackdraws[] = $slug;  //fyll på med draget
					$game -> setBlackdraws($blackdraws);
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
				 $text = $move_var;
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

    public function oldGameAction($slug){
		$gameidminus = $slug; 	
	    // get last game from database
	    $em = $this -> getDoctrine()-> getEntityManager();
		
		$gameid = $em -> getRepository('BundleChessBundle:Game')
				      -> getGameid();
		
		$game = $em -> getRepository('BundleChessBundle:Game')
				    -> getGame($gameid-$gameidminus);
		
		$gameboard = $game -> getGameboard();
		$turn = $game -> getTurn(); 	 
		$player1 =  $game -> getPlayer1(); 
		$player2 =  $game -> getPlayer2();
		$whitedraws =  $game -> getWhitedraws();
		$blackdraws =  $game -> getBlackdraws(); 
		
		$game = array(	"gameboard" => $gameboard
						, "turn" => $turn
						, "player1" => $player1
						, "player2" => $player2
						, "whitedraws" => $whitedraws
						, "blackdraws" => $blackdraws);
						
		$gameboard = array_change_key_case($gameboard); 
		// $gameboard är en array av snaste spelet 
        $text = json_encode($game);
        
		//här är xml:en som skickas som svar till ajax-requestet
		$response = new Response();
		$response->setContent($text);
		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/javascript'); 
		// prints the XML headers followed by the content
		return $response; 	    
	}


}



