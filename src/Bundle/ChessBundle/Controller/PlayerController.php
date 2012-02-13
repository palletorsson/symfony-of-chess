<?php
namespace Bundle\ChessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Bundle\ChessBundle\Entity\Move;
use Bundle\ChessBundle\Entity\Game;
use Bundle\ChessBundle\Entity\Player;
use Bundle\ChessBundle\Entity\Friend;
use Bundle\ChessBundle\Form\EnquiryType;
use Bundle\ChessBundle\Form\EnquiryType2;

class PlayerController extends Controller{
			
		public function newplayerAction()
		{
		print_r($_POST);
		$player = $_POST['players']['player'];
		if(!isset($_POST['players']['player2'])){
			$player2 = 'player2';
		};
		
		$password = md5($_POST['players']['password']);
		
		$newplayer = new Player();
		$newplayer -> setPlayer2($player2); 
		$newplayer -> setPlayer($player);		
		$newplayer -> setPassword($password);

		$em = $this -> getDoctrine()-> getEntityManager();
		$em -> persist($newplayer);
		$em -> flush();
		$playerid = $newplayer -> getPlayerid();
		echo $playerid;

		$playerFriend = new Friend();
	    $form = $this->createForm(new EnquiryType2(), $playerFriend);
	    $request = $this->getRequest();
	    if (isset($_POST['submitFriend']) && $request->getMethod() == 'POST') {
			$newplayer -> setPlayer2($_POST['players']['player2']); 
			$em -> persist($newplayer);
			$em -> flush();
            return $this->redirect($this->generateUrl('BundleChessBundle_game'));
		}

    	return $this->render('BundleChessBundle:Game:newplayer.html.twig', array(
    		'player1' => $player,
    		'form' => $form->createView()
		));
		
	}

	public function loggedinAction(){
		$playerid = $_POST['players']['playerid'];

		$em = $this -> getDoctrine()-> getEntityManager();
		$player = $em -> getRepository('BundleChessBundle:Player')
				      -> getGamesForPlayer($playerid);
					
		$gameboard = $game -> getGameboard();
		$turn = $game -> getTurn(); 	 
		
	}
	
	
}


?>