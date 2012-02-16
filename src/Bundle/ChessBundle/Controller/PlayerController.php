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
			
			$playersalt = new Player();			
			//passwordcheck
			$salt1 = $playersalt->getSalt1();
			$salt2 = $playersalt->getSalt2();
			
			if(md5(($salt1.$password .$salt2)) === $playerdb -> getPassword()){
				$playerdb -> setLoginstatus(1);
				$em -> persist($playerdb);
				$em -> flush();
				return $this->forward('BundleChessBundle:Player:loggedin', array(	//den här skickar vidare till PlayerController loggedinAction med en 
					'player' => $player												//player parameter
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
	
	    	return $this->forward('BundleChessBundle:Player:loggedin', array(
	    		'player' => $player,
			));
	}

	public function loggedinAction($player){
			//skapa ny friend för att rendera ett formulär
			$playerFriend = new Friend();
		    $form = $this->createForm(new EnquiryType2(), $playerFriend);
		    $request = $this->getRequest();
			
			//kolla vilka som har loginstatus 1 i db
			$em = $this -> getDoctrine()-> getEntityManager();
			$playerdb = $em -> getRepository('BundleChessBundle:Player')
				            -> findByLoginstatus(1);
			$playerpending = $em -> getRepository('BundleChessBundle:Player')
				            	 -> findByLoginstatus(2);
			
			$loggedinplayers = array();				   
			foreach($playerdb as $key=>$value){
				if($value->getLoginstatus()== 1){
					$loggedinplayers[] = $value->getPlayer();
				};
			}
			
			$pendingplayers = array();				   
			foreach($playerpending as $key=>$value){
				if($value->getLoginstatus()== 2){
					$pendingplayers[$value->getPlayer()] = $value -> getPendinggame();
				};
			}
			//print_r($pendingplayers);
			

	    	return $this->render('BundleChessBundle:Game:newplayer.html.twig', array(
	    		'player1' => $player,
	    		'form' => $form->createView(),
	    		'loggedinplayers' => $loggedinplayers,
	    		'pendingplayers' => $pendingplayers
			));
	}
	
	public function logoutAction($player1){
	
			$em = $this -> getDoctrine()-> getEntityManager();
			$playerdb = $em -> getRepository('BundleChessBundle:Player')
					        -> getPlayer($player1);
			
			$playerdb -> setLoginstatus(0);
			$em -> persist($playerdb);
			$em -> flush();
			
			return $this->forward('BundleChessBundle:Game:index', array(
				'message1'=> 'You are now logged out, thank you for playing.'
			));			
	}						
}


?>