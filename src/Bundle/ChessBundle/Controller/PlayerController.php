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
			
		public function login_checkAction(){
	    	//print_r($_POST);
			$player = $_POST['players']['player'];
			$password = md5($_POST['players']['password']);
			//echo $player." ".$password."<br/>";
	
			$em = $this -> getDoctrine()-> getEntityManager();
			$playerdb = $em -> getRepository('BundleChessBundle:Player')
					        -> getPlayer($player);
			
			$playerdb -> setLoginstatus(1);
			persist($playerdb);
			flush();
			
			//passwordcheck
			if(md5(($playerdb -> getSalt1() . $password . $playerdb -> getSalt2())) == $playerdb -> getPassword()){
				return $this->forward('BundleChessBundle:Player:loggedin', array(  //den här skickar vidare till PlayerController loggedinAction med en 
				'player' => $player												   //player parameter
				));
			}else{
				return $this->forward('BundleChessBundle:Game:index', array(
					'message1'=> 'The username or password is invalid, try again.'
				));
			}						

		}

		public function registernewplayerAction(){
			$player = $_POST['players']['player'];
			if(!isset($_POST['players']['player2'])){
				$player2 = 'player2';
			};
			
			$password = md5($_POST['players']['password']);

			$em = $this -> getDoctrine()-> getEntityManager();
			$playerdb = $em -> getRepository('BundleChessBundle:Player')
					        -> findOneByPlayer($player);
			
			if($playerdb){
				return $this->forward('BundleChessBundle:Game:index', array(
					'message2'=> 'This username is already taken, please choose another one.'
				));
			}else {
				return $this->forward('BundleChessBundle:Player:newplayer', array(  //den här skickar vidare till PlayerController loggedinAction med en 
					  'player' => $player												   //player parameter
					, 'player2' => $player2
					, 'password' => $password
				));	
			}
		}

		public function newplayerAction($player,$player2,$password){
			//print_r($_POST);

			$playerdb = new Player();
			$playerdb -> setPassword(md5(($playerdb -> getSalt1() . $password . $playerdb -> getSalt2())));		 
			$playerdb -> setPlayer($player);
			$playerdb -> setPlayer2($player2);
			$playerdb -> setLoginstatus(1);

			$em = $this -> getDoctrine()-> getEntityManager();
			$em -> persist($playerdb);
			$em -> flush();
	
			$playerFriend = new Friend();
		    $form = $this->createForm(new EnquiryType2(), $playerFriend);
		    $request = $this->getRequest();

	    	return $this->render('BundleChessBundle:Game:newplayer.html.twig', array(
	    		'player1' => $player,
	    		'form' => $form->createView()
		));
		
	}

	public function loggedinAction($player){
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
}


?>