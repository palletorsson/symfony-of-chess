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
		//echo $savedgame; 
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
        	'player2' => $p2,
        	'gameid' => $this ->gameid
    	));    
	}
    
	
    public function moveAction($slug) {
		$em = $this -> getDoctrine()-> getEntityManager();
		
		$gameid = substr($slug, 5); 
		$slug = substr($slug, 0, 5);
		
		$game = $em -> getRepository('BundleChessBundle:Game')
				    -> getGame($gameid);
					
		$gameboard = $game -> getGameboard();
		$turn = $game -> getTurn(); 	 
		
		// move objekt, kolla moven	
		$this -> current_move = new Move($gameboard,$turn);
		
		//returnerar en kod som avgör hur slaget gått igenom
		$move_var = $this -> current_move -> move($slug);
		//echo "move_var: ".$move_var;
		//giltigt drag, 101 betyder krönt bonde
		if (($move_var === 100) || ($move_var === 101)) {
			
			//1. börja med att se om draget slår ut annan pjäs och lista den (för persistens)
			if($x_piece = $this -> current_move -> checkHit($slug)){ //kolla vilken pjäs som blir utslagen
				if(!$hitpieces = $game -> getHitpieces()){ //hämta ut hitpieces arrayen om finns
					$hitpieces = array(); //annars gör en ny array
				}
				
				$hitpieces[] = $x_piece;  //fyll på med den utslagna pjäsen
				$game -> setHitpieces($hitpieces);
			}				
			
			//2. byt färg och fyll på drag-listorna
			$slugx = $this -> current_move -> checkX($slug); 
			if($turn == 'w') {
				$turn = 'b';
				//Här under fyller vi på whitedraws-listan med det vita draget
				if(!$whitedraws = $game -> getWhitedraws()){
					$whitedraws = array(); //annars gör en ny array
				}
				$whitedraws[] = $this->current_move->getPiece($slug).$slugx;  //fyll på med pjäs och drag
				$game -> setWhitedraws($whitedraws);

			}else if($turn == 'b'){
				$turn = 'w';
				//Här under fyller vi på blackdraws-listan med det svarta draget
				if(!$blackdraws = $game -> getBlackdraws()){
					$blackdraws = array(); //annars gör en ny array
				}
				$blackdraws[] = $this->current_move->getPiece($slug).$slugx;  //fyll på med draget
				$game -> setBlackdraws($blackdraws);
			}
			
			//3. Uppdatera board-arrayen
			if($move_var == 101){
				$updated_gameboard = $this -> current_move ->updateBoardCrown($slug, $gameboard, $turn);
				$text = "101".$slug.$turn;
			}else if($move_var == 100){
				$updated_gameboard = $this -> current_move ->updateBoard($slug, $gameboard);
				$text = $slug;
			}		
			$game -> setGameboard($updated_gameboard);
			$game -> setTurn($turn);
			
			$em -> persist($game);
			$em -> flush();
			
		}else if($move_var > 200) {
			// kommer att returnera felkod
			$text = $move_var;
		} else {
			echo "Something is wrong, movevar is: ".$move_var;
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
		
	    // get last game from database
	    $em = $this -> getDoctrine()-> getEntityManager();
		
		$game = $em -> getRepository('BundleChessBundle:Game')
				    -> getGame($slug);
		
		$gameboard = $game -> getGameboard();
		$turn = $game -> getTurn(); 	 
		$player1 =  $game -> getPlayer1(); 
		$player2 =  $game -> getPlayer2();
		$gameid =  $game -> getGameid(); 

		if(!$hitpieces =  $game -> getHitpieces()){
			$hitpieces = array();
		};
		if(!$whitedraws =  $game -> getWhitedraws()){
			$whitedraws  = array();
		};
		if(!$blackdraws =  $game -> getBlackdraws()){
			$blackdraws  = array();
		};
		
		$game = array(	"gameboard" => $gameboard
						, "turn" => $turn
						, "player1" => $player1
						, "player2" => $player2
						, "gameid" => $gameid
						, "hitpieces" => $hitpieces
						, "whitedraws" => $whitedraws
						, "blackdraws" => $blackdraws);
						
		$gameboard = array_change_key_case($gameboard); 
		// $gameboard är en array av det aktuella spelet 
        $text = json_encode($game);
        
		//här är json som skickas som svar till ajax-requestet
		$response = new Response();
		$response->setContent($text);
		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/javascript'); 
		// prints the javascript headers followed by the content
		return $response; 	    
	}


}



