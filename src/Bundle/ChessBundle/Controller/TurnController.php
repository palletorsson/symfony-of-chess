<?php
namespace Bundle\ChessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Bundle\ChessBundle\Entity\Move;
use Bundle\ChessBundle\Entity\Game;
use Bundle\ChessBundle\Entity\Player;
use Bundle\ChessBundle\Entity\Friend;

class TurnController extends Controller {
		
	public function checkturnAction() {
		
		$gameidIn = $_POST['sendid'];
	    $whosturn = $_POST['myturn'];
	    $em = $this -> getDoctrine()-> getEntityManager();
		
		$game = $em -> getRepository('BundleChessBundle:Game')
				    -> getGame($gameidIn);
			
		$gameboard = $game -> getGameboard();
		$turn = $game -> getTurn();
		$gameid =  $game -> getGameid(); 
		// om det inte är din tur
		if ($turn == $whosturn) {
			$game = array("turn" => "0");	

		} else {
			
			if ($turn == "b") {
				if(!$whitedraws = $game -> getWhitedraws()) {
					$lastdraw = "0";
				} else {
					$lastdraw = end($whitedraws);
				}
			}
				
			if ($turn == "w") {
				if(!$blackdraws = $game -> getBlackdraws()) {
					$lastdraw = "0";
				} else {
					$lastdraw = end($blackdraws);
				}
			}
			
			$game = array(	"turn" => $turn
							, "gameid" => $gameid
							, "lastdraw" => $lastdraw
						 );	

		}	
		
						
        $game = json_encode($game);
        
		//här är json som skickas som svar till ajax-requestet
		$response = new Response();
		$response->setContent($game);
		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/javascript'); 
		// prints the javascript headers followed by the content
		return $response; 	    
	}
		
		
}	
	
?>
