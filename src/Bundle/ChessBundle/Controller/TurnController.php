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
		// is your turn
		if ($turn == $whosturn) {
			// om det inte är din tur
			$game = array("turn" => "0");	

		} else {
			if(!$whitedraws = $game -> getWhitedraws()){
				$whitedraws = "0";
			} else {
				$whitedraws = end($whitedraws);
			}
			
			if(!$blackdraws = $game -> getBlackdraws()){
				$blackdraws = "0";
			} else {
				$blackdraws = end($blackdraws);
			}
			$game = array(	"turn" => $turn
							, "gameid" => $gameid
							, "blackdraw" => $blackdraws
							, "whitedraw" => $whitedraws
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
