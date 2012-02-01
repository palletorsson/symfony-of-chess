<?php
namespace Bundle\ChessBundle\Entity;




	class Move{
		
		
		
		//-------------------------------------------------------
		
		
		function checkMove($piece, $from, $to, $board){
    	
		
		//array för att konvertera bokstav till siffra för beräkning och logiska vilkor
		$yPosToInt = array(
			'a' => 1,
			'b' => 2,
			'c' => 3,
			'd' => 4,
			'e' => 5,
			'f' => 6,
			'g' => 7,
			'h' => 8,
		);
		
		//funktion som returnar inskickat tal som posetivt oavset om det var negativt eller posetivt
		function negToPos($number){
			if ($number < 0) {
				return $number * -1;
			}
			else{
				return $number;
			};
		}
		
		//funktion som retrunar en array med antal steg i både x och y led
		function xySteps($from, $to, $yPosToInt){
			$xystep = array(
			'y' => negToPos($yPosToInt[substr($to, 0, 1)] - $yPosToInt[substr($from, 0, 1)]),//räknar antal y leds steg
			'x' => negToPos(substr($to, 1, 1) - substr($from, 1, 1))//räknar antal x leds steg
			);
			return $xystep;
		}
		
		function checkCollision($moveOverArray, $board){
			foreach ($moveOverArray as $node) {
				if($board[$node] != 0){
					return false;
				}
			}
			return true;
		}
		
		function makeMoveOverArray($from, $to, $yPosToInt){
				
			if(($yPosToInt[substr($from, 0, 1)] - $yPosToInt[substr($to, 0, 1)]) < 0){
				$y = 1;
			}
			else if(($yPosToInt[substr($from, 0, 1)] - $yPosToInt[substr($to, 0, 1)]) == 0){
				$y = 0;
			}
			else{
				$y = -1;
			}
			
			if((substr($to, 1, 1) - substr($from, 1, 1)) < 0){
				$x = -1;
			}
			else if((substr($to, 1, 1) - substr($from, 1, 1)) == 0){
				$x = 0;
			}
			else{
				$x = 1;
			}
			
			$moveOverAttay = array();
			
			$from = array_search(($yPosToInt[substr($from, 0, 1)] + $y), $yPosToInt) . (substr($from, 1, 1) + $x);
			
			while($from != $to){
				$moveOverAttay[] = $from;
				$tempFrom = array_search(($yPosToInt[substr($from, 0, 1)] + $y), $yPosToInt) . (substr($from, 1, 1) + $x);
				$from = $tempFrom;
				
			}
			return $moveOverAttay;
		}
		
		function checkTo($piece, $to, $board){//kollar om den slår vän eller motståndare
			if($board[$to] != 0){
				//kollar om pjäs är vit
				if($piece >= 9812 && $piece <= 9817 ){
					if($board[$to] >= 9812 && $board[$to] <= 9817 ){
						return false;
					}
				}
				//kollar om pjäs är svart
				else if($piece >= 9818 && $piece <= 9823 ){
					if($board[$to] >= 9818 && $board[$to] <= 9823 ){
						return false;
					}
				}
			}
			return true;
		}
		
		//kollar om pos är hotad att blir slagen. Behöver $piece som en kung för att avgöra färg return true om pos kan bli slagen
		function checkChess($pos, $piece, $yPosToInt, $board){
			
			//hämtar alla rutor en häst kan gå till utifrån pos
			function checkKnight($pos, $yPosToInt){
				$moveToArray = array();
				$tempArray = array();
				
				//gör ett negativt tal till noll
				function negativToZero($int){
					if($int < 0){
						$int = 0;
					}
					return $int;
				}
				
				//$knightTo = ($yPosToInt[substr($pos, 0, 1)] + 2)
				$tempArray[] = (($yPosToInt[substr($pos, 0, 1)] + 2) . (substr($pos, 1, 1) + 1));
				
				$tempArray[] = (($yPosToInt[substr($pos, 0, 1)] + 1) . (substr($pos, 1, 1) + 2));
				
				$tempArray[] = (negativToZero($yPosToInt[substr($pos, 0, 1)] - 2) . (substr($pos, 1, 1) + 1));
				
				$tempArray[] = (negativToZero($yPosToInt[substr($pos, 0, 1)] - 1) . (substr($pos, 1, 1) + 2));
				
				$tempArray[] = (($yPosToInt[substr($pos, 0, 1)] + 2) . negativToZero(substr($pos, 1, 1) - 1));
				
				$tempArray[] = (($yPosToInt[substr($pos, 0, 1)] + 1) . negativToZero(substr($pos, 1, 1) - 2));
				
				$tempArray[] = (negativToZero($yPosToInt[substr($pos, 0, 1)] - 2) . negativToZero(substr($pos, 1, 1) - 1));
				
				$tempArray[] = (negativToZero($yPosToInt[substr($pos, 0, 1)] - 1) . negativToZero(substr($pos, 1, 1) - 2));
				
				
				foreach ($tempArray as $value) {
					if(substr($value, 0, 1) > 0 && substr($value, 0, 1) < 9){
						if(substr($value, 1, 1) > 0 && substr($value, 1, 1) < 9){
							$moveToArray[] = (array_search(substr($value, 0, 1), $yPosToInt)) . substr($value, 1, 1);
						}
					}
				}
				
				return $moveToArray;
			}
			
			function checkUp($pos, $color, $board){
				$x = substr($pos, 1, 1);
				$x++;
				while ($x <= 8) {
					$y = substr($pos, 0, 1);
					if($board[$y . $x] != 0){
						if($color == "white"){
							
							if($board[$y . $x] == 9820 || $board[$y . $x] == 9819 ){
								return true;
								}
						}
						else if($color == "black"){
							if($board[$y . $x] == 9814 || $board[$y . $x] == 9813 ){
								return true;
							}
						}
						else{
							return false;
						}
					}
					
					$x++;
				}
			}
			
			function checkDown($pos, $color, $board){
				$x = substr($pos, 1, 1);
				$x--;
				while ($x >= 1) {
					$y = substr($pos, 0, 1);
					if($board[$y . $x] != 0){
						if($color == "white"){
							if($board[$y . $x] == 9820 || $board[$y . $x] == 9819 ){
								return true;
							}
					}
						else if($color == "black"){
							if($board[$y . $x] == 9814 || $board[$y . $x] == 9813 ){
								return true;
							}
						}
					}
					
					$x--;
				}
				return false;
			}
			
			function checkRight($pos, $color, $yPosToInt, $board){
				$y = $yPosToInt[substr($pos, 0, 1)];
				$y++;
				while ($y <= 8) {
					$x = substr($pos, 1, 1);
					$yAsString = array_search($y, $yPosToInt);
					if($board[$yAsString . $x] != 0){
						if($color == "white"){
							if($board[$yAsString . $x] == 9820 || $board[$yAsString . $x] == 9819 ){
								return true;
							}
					}
					else if($color == "black"){
						if($board[$yAsString . $x] == 9814 || $board[$yAsString . $x] == 9813 ){
							return true;
						}
					}
					}
					
					$y++;
				}
				return false;
			}
			
			function checkLeft($pos, $color, $yPosToInt, $board){
				$y = $yPosToInt[substr($pos, 0, 1)];
				$y--;
				while ($y >= 1) {
					$x = substr($pos, 1, 1);
					$yAsString = array_search($y, $yPosToInt);
					if($board[$yAsString . $x] != 0){
						if($color == "white"){
							if($board[$yAsString . $x] == 9820 || $board[$yAsString . $x] == 9819 ){
								return true;
							}
					}
					else if($color == "black"){
						if($board[$yAsString . $x] == 9814 || $board[$yAsString . $x] == 9813 ){
							return true;
						}
					}
					}
					
					$y--;
				}
				return false;
			}
			
			function checkUpRight($pos, $color, $yPosToInt, $board){
				$y = $yPosToInt[substr($pos, 0, 1)];
				$x = substr($pos, 1, 1);
				$y++;
				$x++;
				
				//kollar efter bonde på först steget
				if($color == "white" && ($y <= 8 && $x <= 8)){
						
						$yAsString = array_search($y, $yPosToInt);
						if($board[$yAsString . $x] == 9823){
							return true;
						}
					}
				
				while ($y <= 8 && $x <= 8) {
					$yAsString = array_search($y, $yPosToInt);
					if($board[$yAsString . $x] != 0){
						if($color == "white"){
							if($board[$yAsString . $x] == 9821 || $board[$yAsString . $x] == 9819 ){
								return true;
							}
						}
						else if($color == "black"){
							if($board[$yAsString . $x] == 9815 || $board[$yAsString . $x] == 9813 ){
								return true;
							}
						}
					}
					$y++;
					$x++;
				}
				return false;
			}
			
			function checkUpLeft($pos, $color, $yPosToInt, $board){
				$y = $yPosToInt[substr($pos, 0, 1)];
				$x = substr($pos, 1, 1);
				$y--;
				$x++;
				
				//kollar efter bonde på först steget
				if($color == "white"  && ($y >= 1 && $x <= 8)){
						$yAsString = array_search($y, $yPosToInt);
						if($board[$yAsString . $x] == 9823){
							return true;
						}
					}
				
				while ($y >= 1 && $x <= 8) {
					$yAsString = array_search($y, $yPosToInt);
					if($board[$yAsString . $x] != 0){
						if($color == "white"){
							if($board[$yAsString . $x] == 9821 || $board[$yAsString . $x] == 9819 ){
								return true;
							}
						}
						else if($color == "black"){
							if($board[$yAsString . $x] == 9815 || $board[$yAsString . $x] == 9813 ){
								return true;
							}
						}
					}
					$y--;
					$x++;
				}
				return false;
			}
			
			function checkDownRight($pos, $color, $yPosToInt, $board){
				$y = $yPosToInt[substr($pos, 0, 1)];
				$x = substr($pos, 1, 1);
				$y++;
				$x--;
				
				//kollar efter bonde på först steget
				if($color == "black"  && ($y <= 8 || $x >= 1)){
						
						$yAsString = array_search($y, $yPosToInt);
						if($board[$yAsString . $x] == 9817){
							return true;
						}
					}
				
				while ($y <= 8 && $x >= 1) {
					$yAsString = array_search($y, $yPosToInt);
					if($board[$yAsString . $x] != 0){
						if($color == "white"){
							if($board[$yAsString . $x] == 9821 || $board[$yAsString . $x] == 9819 ){
								return true;
							}
						}
						else if($color == "black"){
							if($board[$yAsString . $x] == 9815 || $board[$yAsString . $x] == 9813 ){
								return true;
							}
						}
					}
					$y++;
					$x--;
				}
				return false;
			}
			
			function checkDownLeft($pos, $color, $yPosToInt, $board){
				$y = $yPosToInt[substr($pos, 0, 1)];
				$x = substr($pos, 1, 1);
				$y--;
				$x--;
				
				//kollar efter bonde på först steget
				if($color == "black"  && ($y >= 1 && $x >= 1)){
						
						$yAsString = array_search($y, $yPosToInt);
						if($board[$yAsString . $x] == 9817){
							return true;
						}
					}
				
				while ($y >= 1 && $x >= 1 ) {
					$yAsString = array_search($y, $yPosToInt);
					if($board[$yAsString . $x] != 0){
						if($color == "white"){

							if($board[$yAsString . $x] == 9821 || $board[$yAsString . $x] == 9819 ){
								return true;
							}
						}
						else if($color == "black"){
	
							if($board[$yAsString . $x] == 9815 || $board[$yAsString . $x] == 9813 ){
								return true;
							}
						}
					}
					$y--;
					$x--;
				}
				return false;
			}
			
			
			
			
			$color = "";
			if($piece == 9812){
				$color = "white";
			}
			else if($piece == 9818){
				$color = "black";
			}
			else{
			
				return false;
			}
			
			
			$knightMoves = checkKnight($pos, $yPosToInt);
			
			foreach($knightMoves as $move){
				
				if($color == "white"){
					
					if($board[$move] == 9822){
						return true;
					}
				}
				if($color == "black"){
					
					if($board[$move] == 9816){
						return true;
					}
				}
			}
			
			if(checkUp($pos, $color, $board)){
				return true;
			}
			if(checkDown($pos, $color, $board)){
				return true;
			}
			if(checkRight($pos, $color, $yPosToInt, $board)){
				return true;
			}
			if(checkLeft($pos, $color, $yPosToInt, $board)){
				return true;
			}
			if(checkUpRight($pos, $color, $yPosToInt, $board)){
				return true;
			}
			if(checkUpLeft($pos, $color, $yPosToInt, $board)){
				return true;
			}
			if(checkDownRight($pos, $color, $yPosToInt, $board)){
				return true;
			}
			if(checkDownLeft($pos, $color, $yPosToInt, $board)){
				return true;
			}
			// "King can't move into chess."
			$error = 205; 
			return $error;
		}

		
		
		
    	//black pawn
		if($piece == 9823){
			//här ska går diagonalt för att döda
			if(substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] + 1), $yPosToInt) || substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] - 1), $yPosToInt)){//här ska går diagonalt för att döda
				if(substr($to, 1, 1) == (substr($from, 1, 1)) - 1){
					if(checkTo($piece, $to, $board)){
						if(!$board[$to] == 0){
							if (substr($to, 1, 1) == 1){
								return 101;//kröna bonde till dam
							}
							else{
								return 100;
							}
						}
						else{
							return 202;
						}
					}
					else{
						return 204;
					}
					
				}
				else{
					return 202;
				}
			}
			//drag för bondens ifrån startposion
			else if(substr($from, 1,1) == 7 && substr($from, 0,1) == substr($to, 0,1)){
				if(substr($to, 1,1) == 6 || substr($to, 1,1) == 5){
					if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
						if($board[$to] == 0){
							return 100;
						}
						else{
							return 202;
						}
					}
					else{
						return 203;
					}
				}
				else{
					return 202;
				}
			}
			
			// vanligt drag när bonden går ett steg framåt
			else if(substr($to, 1, 1) == (substr($from, 1, 1)) - 1 && array_search($yPosToInt[substr($from, 0,1)], $yPosToInt) == array_search($yPosToInt[substr($to, 0,1)], $yPosToInt)){
				if($board[$to] == 0){
					if (substr($to, 1, 1) == 1){
						return 101;//kröna bonde till dam
					}
					else{
						return 100;
					}
				}
				else{
					return 202;
				}
			}
			else {
				return 202;	
			}
		}
		//white pawn
		if($piece == 9817){
			//här ska går diagonalt för att döda
			if(substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] + 1), $yPosToInt) || substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] - 1), $yPosToInt)){//här ska går diagonalt för att döda
				if(substr($to, 1, 1) == (substr($from, 1, 1)) + 1){
					if(checkTo($piece, $to, $board)){
						if(!$board[$to] == 0){
							if (substr($to, 1, 1) == 8){
								return 101;//kröna bonde till dam
							}
							else{
								return 100;
							}
						}
						else{
							return 202;
						}
					}
					else{
						return 204;
					}
					
				}
				else{
					return 202;
				}
			}
			//drag för bondens ifrån startposion
			else if(substr($from, 1,1) == 2 && substr($from, 0,1) == substr($to, 0,1)){
				if(substr($to, 1,1) == 3 || substr($to, 1,1) == 4){
					if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
						if($board[$to] == 0){
							return 100;
						}
						else{
							return 202;
						}
					}
					else{
						return 203;
					}
				}
				else{
					return 202;
				}
			}
			
			
			// vanligt drag när bonden går ett steg framåt
			else if(substr($to, 1, 1) == (substr($from, 1, 1)) + 1 && array_search($yPosToInt[substr($from, 0,1)], $yPosToInt) == array_search($yPosToInt[substr($to, 0,1)], $yPosToInt)){
				if($board[$to] == 0){
					if (substr($to, 1, 1) == 8){
						return 101;//kröna bonde till dam
					}
					else{
						return 100;
					}
				}
				else{
					return 202;
				}
			}
			else {
				return 202;	
			}
		}
		//rook
		if($piece == 9820 || $piece == 9814){
			$xyarray = xySteps($from, $to ,$yPosToInt);
			//om en rikning är noll får andra vara hur lång som helst
			if($xyarray["y"] == 0 || $xyarray["x"] == 0){
				if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
					if(checkTo($piece, $to, $board)){
						return true;
					}
					else{
						return 204;
					}
				}
				else{
					return 203;
				}
			}
			else {
				return 202;
			}
		}
		//bishop
		if($piece == 9821 || $piece == 9815){
			$xyarray = xySteps($from, $to ,$yPosToInt);
			
			//om det är lika många steg i båda riktningarna är det en diagonal förflyttning
			if($xyarray["y"] == $xyarray["x"]){
				if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
					if(checkTo($piece, $to, $board)){
						return true;
					}
					else{
						return 204;
					}
				}
				else{
					return 203;
				}
			}
			else {
				return 202;
			}
		}
		//knight
		if($piece == 9822 || $piece == 9816){
			$xyarray = xySteps($from, $to ,$yPosToInt);
			if(($xyarray["x"] == 1 && $xyarray["y"] == 2) || ($xyarray["x"] == 2 && $xyarray["y"] == 1)){
				if(checkTo($piece, $to, $board)){
					return true;
				}
				else{
					return 204;
				};
			}
			else{
				return 202;
			}
		}
		//queen
		if($piece == 9819 || $piece == 9813){
			$xyarray = xySteps($from, $to ,$yPosToInt);
			if($xyarray["x"] == $xyarray["y"] || ($xyarray["x"] == 0 xor $xyarray["y"] == 0)){
				if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
					if(checkTo($piece, $to, $board)){
						return true;
					}
					else{
						return 204;
					}
				}
				else{
					return 203;
				}
			}
			else{
				return 202;
			}
			
		}
		//king
		if($piece == 9818 || $piece == 9812){
			$xyarray = xySteps($from, $to ,$yPosToInt);
			//om det är lika många steg i båda riktningarna är det en diagonal förflyttning
			if($xyarray["y"] <= 1 && $xyarray["x"] <= 1){
				if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
					if(checkTo($piece, $to, $board)){
						if(checkChess($to, $piece, $yPosToInt, $board)){
							return 100;
						}
						else{
							return 205;
						}
					}
					else{
						return 204;
					}
				}
				else{
					return 203;
				}
			}
			else {
				return 202;
			}
		}
    }
    
	
	
	//*********************************************************************************************************//
	
			
		/*
		if(checkMove('9816','b1','a3')){
			echo("funkarhar hurra</br>");
		}
		else{
			echo "buuuuuuuuuuuu</br>";
		}
	
		if(checkMove('9821','c8','a6')){
			echo("funkarhar hurra</br>");
		}
		else{
			echo "buuuuuuuuuuuu</br>";
		}
		if(checkMove('9817','b2','b3')){
			echo("funkarhar hurra</br>");
		}
		else{
			echo "buuuuuuuuuuuu</br>";
		}
		if(checkMove('9817','c2','c4')){
			echo("funkarhar hurra</br>");
		}
		else{
			echo "buuuuuuuuuuuu</br>";
		}
		
		if(checkMove('9813','d1','b3')){
			echo("funkarhar hurra</br>");
		}
		else{
			echo "buuuuuuuuuuuu</br>";
		}
		if(checkMove('9813','d1','d5')){
			echo("funkarhar hurra</br>");
		}
		else{
			echo "buuuuuuuuuuuu</br>";
		}
		if(checkMove('9813','d1','e2')){
			echo("funkarhar hurra</br>");
		}
		else{
			echo "buuuuuuuuuuuu</br>";
		}
		
		if(checkMove('9816','b1','c3')){
			echo("funkarhar hurra</br>");
		}
		else{
			echo "buuuuuuuuuuuu</br>";
		}
		if(checkMove('9816','b1','a3')){
			echo("funkarhar hurra</br>");
		}
		else{
			echo "buuuuuuuuuuuu</br>";
		}
	*/
		
		
		
		
		
		
		
		
		
		//-------------------------------------------------------
		
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
		private function checkPattern($themove){
			$pattern = "/^[A-H]{1}+[0-9]{1}[-][A-H]{1}+[0-9]{1}/";
			if (preg_match($pattern, $themove)) {
				$from = strtolower(substr($themove,0,2)); 
				$to = strtolower(substr($themove,3,2));
				$fromtoarray = array($from, $to);
			}else{
				// "wrong syntax"
				$error = 201; 
				return $error;
			}	
			return $fromtoarray;
		}
			
		public function checkTurn($current_piece) {
			$piece_color = substr($this -> pieces[$current_piece],0,1);
			if($this -> turn == 'w' && $piece_color == 'w'){
				$this -> turn = 'b';
			}else if($this -> turn == 'b' && $piece_color == 'b'){
				$this -> turn = 'w';
			}else{
				return false;
			}	
			return TRUE;
		}
			
		public function move($themove){
			if(!isset($this -> board) || !isset($this -> turn)) {
				throw $this -> createNotFoundException('Unable to find gameboard or turn.');
			}
			
			// kolla syntax ta mar to och from
			$fromto = $this->checkPattern($themove); 
			$from = $fromto[0];
			$to = $fromto[1];
			
			// hämta pjäs nummer
			$current_piece = $this -> board[$from];
	
			// Kolla om det är rätt färg som drar
			if(!$this->checkTurn($current_piece)) {
				// "It's not your turn."
				$error_202 = 201;
				return $error_202;
			} else if(!$this->checkMove($current_piece, $from, $to, $this -> board)) {
				// "This move is against the game rules."
				$error_203 = 202;
				return $error_203;
			}
			//uppdatera arrayen
			return TRUE;	
			
		}
	}
?>
