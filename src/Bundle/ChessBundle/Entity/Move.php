<?php
namespace Bundle\ChessBundle\Entity;



	class Move{
			
		protected $turn;
		protected $board = array();
				
		private	$pieces = array(
			9820 => 'b_rook', 
			9821 => 'b_bishop', 
			9822 => 'b_knight', 
			9819 => 'b_queen', 
			9818 => 'b_king', 
			9823 => 'b_pawn',
			9814 => 'w_rook', 
			9815 => 'w_bishop', 
			9816 => 'w_knight',  
			9812 => 'w_king', 
			9813 => 'w_queen', 
			9817 => 'w_pawn'
		);		
		
		public function __construct($gameboard,$whosturn){
			$this -> board = $gameboard;
			$this -> turn = $whosturn;
		}
		
		public function getColor($code){
			return $this->pieces[$code]; 
		}
		
		public function updateBoard($move,$board){
			$from = strtolower(substr($move,0,2)); 
			$to = strtolower(substr($move,3,2));
			$current_piece = $board[$from];

			$board[$from] = 0;
			$board[$to] = $current_piece;
			
			return $board;
			
		}
		
		private function checkPattern($move){
			
		}
		public function move($themove){
			if(!isset($this -> board) || !isset($this -> turn)) {
				throw $this -> createNotFoundException('Unable to find gameboard or turn.');
			}

			//gör först!
			$pattern = "/^[A-H]{1}+[0-9]{1}[-][A-H]{1}+[0-9]{1}/";
			if (preg_match($pattern, $themove)) {
				$from = strtolower(substr($themove,0,2)); 
				$to = strtolower(substr($themove,3,2));
			}else{
				return FALSE;
			}	

			
			//forsätt här
			$current_piece = $this -> board[$from];
			$piece_color = substr($this -> pieces[$current_piece],0,1);
			
			//Här ändrar vi på vems tur det är
			if($this -> turn == 'w' && $piece_color == 'w'){
				$this -> turn = 'b';
			}else if($this -> turn == 'b' && $piece_color == 'b'){
				$this -> turn = 'w';
			}else{
				//echo "Det är inte din tur!";
				return FALSE;
			}
			/*
			if(!checkMove($current_piece, $from, $to, $board)){
				return FALSE;
			}
			 * 
			 */
			
			//uppdatera arrayen
			return TRUE;
		}
		
	}

?>