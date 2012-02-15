<?php
namespace Bundle\ChessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Bundle\ChessBundle\Entity\Move;
use Bundle\ChessBundle\Entity\Game;
use Bundle\ChessBundle\Entity\Player;
use Bundle\ChessBundle\Entity\Friend;

class FindPlayerController extends Controller {
		
	public function waitforplayerAction() {
		
		$gameidIn = $_POST['sendid'];
	
	    $em = $this -> getDoctrine()-> getEntityManager();
		
		$game = $em -> getRepository('BundleChessBundle:Game')
				    -> getGame($gameidIn);
			
		$dbplayer2 = $player2 -> getPlayer2();
		$gameid =  $game -> getGameid(); 
			
			$game = array(	"dbplayer2" => $dbplayer2
							, "gameid" => $gameid
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
