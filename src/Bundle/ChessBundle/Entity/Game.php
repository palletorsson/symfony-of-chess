<?php
	namespace Bundle\ChessBundle\Entity;

	class Game{
			
			
		protected $turn = 'w';
		
		private $board = array(
			'a8' => 9820,
			'b8' => 9822,
			'c8' => 9821,
			'd8' => 9819,
			'e8' => 9818,
			'f8' => 9821,
			'g8' => 9822,
			'h8' => 9820,
			
			'a7' => 9823,
			'b7' => 9823,
			'c7' => 9823,
			'd7' => 9823,
			'e7' => 9823,
			'f7' => 9823,
			'g7' => 9823,
			'h7' => 9823,
			
			'a6' => 0,
			'b6' => 0,
			'c6' => 0,
			'd6' => 0,
			'e6' => 0,
			'f6' => 0,
			'g6' => 0,
			'h6' => 0,
			
			'a5' => 0,
			'b5' => 0,
			'c5' => 0,
			'd5' => 0,
			'e5' => 0,
			'f5' => 0,
			'g5' => 0,
			'h5' => 0,
			
			'a4' => 0,
			'b4' => 0,
			'c4' => 0,
			'd4' => 0,
			'e4' => 0,
			'f4' => 0,
			'g4' => 0,
			'h4' => 0,
			
			'a3' => 0,
			'b3' => 0,
			'c3' => 0,
			'd3' => 0,
			'e3' => 0,
			'f3' => 0,
			'g3' => 0,
			'h3' => 0,

			'a2' => 9817,
			'b2' => 9817,
			'c2' => 9817,
			'd2' => 9817,
			'e2' => 9817,
			'f2' => 9817,
			'g2' => 9817,
			'h2' => 9817,

			'a1' => 9814,
			'b1' => 9816,
			'c1' => 9815,
			'd1' => 9813,
			'e1' => 9812,
			'f1' => 9815,
			'g1' => 9816,
			'h1' => 9814,
		);
		
		private	$pieces = array(
			9820 => 'b_rook', 
			9822 => 'b_bishop', 
			9819 => 'b_knight', 
			9821 => 'b_queen', 
			9819 => 'b_king', 
			9823 => 'b_pawn',
			9814 => 'w_rook', 
			9815 => 'w_bishop', 
			9816 => 'w_knight',
			9817 => 'w_knight',  
			9813 => 'w_king', 
			9813 => 'w_queen', 
			9812 => 'w_pawn'
		);
		
		public function __construct(){
			
		}
		public function updateBoard($oldPos, $newPos, $piece){
			$this -> board[$oldPos] = 0;
			$this -> board[$newPos] = $piece;
		}
		
		public function getPieceAtPosition($pos){
			return $this -> board[$position];
		}
		
		public function getColor($code){
			return $this->pieces[$code]; 
		}
		
		public function move($themove){
					
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
			
			return TRUE;
		}
		
	}

?>