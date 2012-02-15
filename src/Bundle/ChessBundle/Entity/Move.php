<?php
namespace Bundle\ChessBundle\Entity;




	class Move{

		private $board = array();
		private $turn;
		private $piece;
		private $themove;
		private $from;
		private $to;
		private $fromRow;
		private $fromCol;
		private $toRow;
		private $toCol;
		private $color;
		private $hitpiece;
		private $diagonal = array();
								
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
		
//array för att konvertera bokstav till siffra för beräkning och logiska vilkor
		protected $yPosToInt = array(
			'a' => 1,
			'b' => 2,
			'c' => 3,
			'd' => 4,
			'e' => 5,
			'f' => 6,
			'g' => 7,
			'h' => 8,
		);
		
		public function __construct($gameboard,$whosturn,$themove){
			$this -> board = $gameboard;
			$this -> turn = $whosturn;
			
			$themove = strtolower($themove);
			$this -> themove = $themove;
			$this -> from = substr($themove,0,2);
			$this -> to = substr($themove,3,2);
			
			//här konverteras movens bokstav till ett nummer från formet som A1-A2
			$this -> fromCol = $this -> yPosToInt[substr($themove,0,1)];
			$this -> fromRow = substr($themove,1,1);
			$this -> toCol = $this -> yPosToInt[substr($themove,3,1)];
			$this -> toRow = substr($themove,4,1);
			
			$this -> piece = $gameboard[$this -> from];	
			$this -> hitpiece = $gameboard[$this -> to];
			
			
			$this -> color = substr($this -> pieces[$this->piece], 0, 1);
			$this -> diagonal["col"] = abs($this -> toCol - $this ->fromCol); 
			$this -> diagonal["row"] = abs($this -> toRow - $this ->fromRow); 
		}
		
		//gör ett negativt tal till noll
		public function negativToZero($int){
			if($int < 0){
				$int = 0;
			}
			return $int;
		}
		
		//hämtar alla rutor en häst kan gå till utifrån pos
		public function checkKnight($kingCol,$kingRow){
			$moveToArray = array();
			$tempArray = array();
			
			//alla 8 positioner som en häst kan stå på
			$tempArray[] = (($kingCol + 2) . ($kingRow + 1));
			
			$tempArray[] = (($kingCol + 1) . ($kingRow + 2));
			
			$tempArray[] = ($this -> negativToZero($kingCol - 2) . ($kingRow + 1));
			
			$tempArray[] = ($this -> negativToZero($kingCol - 1) . ($kingRow + 2));
			
			$tempArray[] = (($kingCol + 2) . $this -> negativToZero($kingRow - 1));
			
			$tempArray[] = (($kingCol + 1) . $this -> negativToZero($kingRow - 2));
			
			$tempArray[] = ($this -> negativToZero($kingCol - 2) . $this -> negativToZero($kingRow - 1));
			
			$tempArray[] = ($this -> negativToZero($kingCol - 1) . $this -> negativToZero($kingRow - 2));
			
			
			foreach ($tempArray as $value) {
				if(substr($value, 0, 1) > 0 && substr($value, 0, 1) < 9){ //kolumnen är mindre än 9
					if(substr($value, 1, 1) > 0 && substr($value, 1, 1) < 9){ //raden är mindre än 9
						$moveToArray[] = substr($value, 0, 1) . substr($value, 1, 1);
					}
				}
			}
			
			return $moveToArray;
		}

		public function checkDiagonal($board, $y, $x, $color) {
		
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
			}
			
		public function checkCells($p, $w1, $w2, $b1, $b2, $color) {
			if($p != 0) {
				// echo $p;
					
				if($color == "white") {	
					if ($p <= 9817){
						return 1002;
					}
					else if ($p == $b1 || $p == $b2){
						return 1003;
					} 
					else if ($p >= 9818) {
						return 1002;	
					}
				}
				if($color == "black") {	
					if ($p >= 9818){
						return 1002;
					}
					else if($p == $w1 || $p == $w2){
						return 1003;
					}
					else if ($p <= 9817) {
						return 1002;	
					}
				}
			}else {
			return 1001;	
	
			}
		}	
		public function checkUp($kingRow, $kingCol, $color, $board){
			$x = $kingRow;
			$x++;
			$y = $kingCol;
			while ($x <= 8) {
				$p = $board[$y . $x]; 
				$answer = $this -> checkCells($p, 9814, 9813, 9820, 9819, $color);  
				if ($answer == 1003) {
					return true;
				} else if ($answer == 1002){
					return false;
				} else {
					$x++;
				}
			}
		}
				
		
		public function checkDown($kingRow, $kingCol, $color, $board){
			$x = $kingRow;
			$x--;
			$y = $kingCol;
			while ($x >= 1) {
				$p = $board[$y . $x]; 
				$answer = $this -> checkCells($p, 9814, 9813, 9820, 9819, $color);
				if ($answer == 1003) {
					return true;
				} else if ($answer == 1002){
					return false;
				} else {
					$x--;
				}
			}
			return false;		
		}
		
		
		
		public function checkRight($kingRow, $kingCol, $color, $board){
			$y = $kingCol;
			$y++;
			$x = $kingRow;
			while ($y <= 8) {
				$p = $board[$y . $x]; 
				$answer = $this -> checkCells($p, 9814, 9813, 9820, 9819, $color);
				if ($answer == 1003) {
					return true;
				} else if ($answer == 1002){
					return false;
				} else {
					$y++;
				}
			}
			return false;
		}
		
		public function checkLeft($kingRow, $kingCol, $color, $board){
			$y = $kingCol;
			$y--;
			$x = $kingRow;
			while ($y >= 1) {
				$p = $board[$y . $x]; 
				$answer = $this -> checkCells($p, 9814, 9813, 9820, 9819, $color);
				if ($answer == 1003) {
					return true;
				} else if ($answer == 1002){
					return false;
				} else {
					$y--;
				}
			}
			return false;
		}
		
		public function checkUpRight($kingRow, $kingCol, $color, $board){
			$y = $kingCol;
			$x = $kingRow;
			$y++;
			$x++;
			
			//kollar efter bonde på först steget
			if($color == "white" && ($y <= 8 && $x <= 8)){
					if($board[$y . $x] == 9823){
						return true;
					}
				}
			
			while ($y <= 8 && $x <= 8) {
				$p = $board[$y . $x]; 
				$answer = $this -> checkCells($p, 9815, 9813, 9821, 9819, $color);
				if ($answer == 1003) {
					return true;
				} else if ($answer == 1002){
					return false;
				} else {
					$y++;
					$x++;
				}	
				
			}
			return false;
		}
		
		public function checkUpLeft($kingRow, $kingCol, $color, $board){
			$y = $kingCol;
			$x = $kingRow;
			$y--;
			$x++;
			
			//kollar efter bonde på först steget
			if($color == "white"  && ($y >= 1 && $x <= 8)){
					if($board[$y . $x] == 9823){
						return true;
					}
				}
			
			while ($y >= 1 && $x <= 8) {
				$p = $board[$y . $x];
				$answer = $this -> checkCells($p, 9815, 9813, 9821, 9819, $color);
				if ($answer == 1003) {
					return true;
				} else if ($answer == 1002){
					return false;
				} else {
					$y--;
					$x++;
				}	
			}
			return false;
		}
		
		public function checkDownRight($kingRow, $kingCol, $color, $board){
			$y = $kingCol;
			$x = $kingRow;
			$y++;
			$x--;
			//kollar efter bonde på först steget
			if($color == "black"  && ($y <= 8 || $x >= 1)){
					if($board[$y . $x] == 9817){
						return true;
					}
				}
			
			while ($y <= 8 && $x >= 1) {
				$p = $board[$y . $x]; 
				$answer = $this -> checkCells($p, 9815, 9813, 9821, 9819, $color);
				if ($answer == 1003) {
					return true;
				} else if ($answer == 1002){
					return false;
				} else {
					$y++;
					$x--;
				}
			}
			return false;
		}
		
		public function checkDownLeft($kingRow, $kingCol, $color, $board){
			$y = $kingCol;
			$x = $kingRow;
			$y--;
			$x--;
			
			//kollar efter bonde på först steget
			if($color == "black"  && ($y >= 1 && $x >= 1)){
					if($board[$y . $x] == 9817){
						return true;
					}
				}
			
			while ($y >= 1 && $x >= 1 ) {
				$p = $board[$y.$x];
				$answer = $this -> checkCells($p, 9815, 9813, 9821, 9819, $color);
				if ($answer == 1003) {
					return true;
				} else if ($answer == 1002){
					return false;
				} else {
					$y--;
					$x--;
				}
			}
			return false;
		}
		//kollar om pos är hotad att blir slagen. Behöver $piece som en kung för att avgöra färg return true om pos kan bli slagen
		public function checkChess($pos, $piece, $board, $color){ //$pos = kingposition $piece=kungens kod $board=nya boarden
			
			// dessa två variabler håller i hela checkChess funktionen
			// echo $pos; 
			$kingCol = substr($pos,0,1);
			$kingRow = substr($pos,1,1);
			
			$knightMoves = $this -> checkKnight($kingCol, $kingRow);
			
			foreach($knightMoves as $position){
				if($color == "white"){
					if($board[$position] == 9822){ //svart häst
						return TRUE;
					}
					
				}
				if($color == "black"){
					if($board[$position] == 9816){ //vit häst
						return TRUE;
					}
				
				}
			}
			
			if($this -> checkUp($kingRow, $kingCol, $color, $board)){
				return true;
			}
			if($this -> checkDown($kingRow, $kingCol, $color, $board)){
				return true;
			}
			if($this -> checkRight($kingRow, $kingCol, $color, $board)){
				return true;
			}
			if($this -> checkLeft($kingRow, $kingCol, $color, $board)){
				return true;
			}
			if($this -> checkUpRight($kingRow, $kingCol, $color, $board)){
				return true;
			}
			if($this -> checkUpLeft($kingRow, $kingCol, $color, $board)){
				return true;
			}
			if($this -> checkDownRight($kingRow, $kingCol, $color, $board)){
				return true;
			}
			if($this -> checkDownLeft($kingRow, $kingCol, $color, $board)){
				return true;
			}
			
			return false;
		}

		public function checkMove(){
	    	
			switch($this -> piece){
				case 9823:
				case 9817:
					$answer = $this->pawn();
					return $answer;
					break;
				case 9820:
				case 9814:
					$answer = $this -> rook();
					return $answer;
					break;
				case 9821:
				case 9815:
					$answer = $this -> bishop();
					return $answer;
					break;
				case 9822:
				case 9816:
					$answer = $this -> knight();
					return $answer;
					break;
				case 9819:
				case 9813:
					$answer = $this -> queen();
					return $answer;
					break;
				case 9818:
				case 9812:
					$answer = $this -> king();
					return $answer;
					break;
			}
			
	    	//Pawn-function (BONDE)  9823  9817
				//rook = TORN  	if($piece == 9820 || $piece == 9814){
			
			//bishop = LÖPARE if($piece == 9821 || $piece == 9815){

			//knight = HÄST if($piece == 9822 || $piece == 9816){

			//queen = DROTTNING if($piece == 9819 || $piece == 9813){
			//king = KUNG if($piece == 9818 || $piece == 9812){

	    }	

		public function checkCollision($moveOverArray){
			foreach ($moveOverArray as $node) {
				if($this-> board[$node] != 0){
					return false;
				}
			}
			return true;
		}
/*
		public function makeMoveOverArray($this->from, $this->to, $this->yPosToInt){
			//Kollar riktning på drag
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
			if(($this->diagonal["col"]) < 0){ 
				$y = 1;
			}
			else if(($this->diagonal["col"]) == 0){
				$y = 0;
			}
			else{
				$y = -1;
			}
			
			if(($this->diagonal["row"]) < 0){
				$x = -1;
			}
			else if(($this->diagonal["row"]) == 0){
				$x = 0;
			}
			else{
				$x = 1;
			}
			
			$moveOverAttay = array();
			$fromRow = $this->fromRow;
			$fromCol = $this->fromCol;
			$to = $this -> to;
			//from + 1 eller så, nästa position
			$august = array_search(($fromCol + $y), $yPosToInt).($fromRow + $x); //genererar ett from i format a3
			//echo $august." ".$to;
			
			while($august != ($to)){
				$moveOverAttay[] = $august;
				//echo $august." ";
				
				$fromRow = $fromRow + $x;
				$fromCol = $fromCol + $y;
				$fromColA = array_search(($fromCol),$yPosToInt);
				$august = $fromColA . $fromRow ; //nästa steg
				//echo $august." ". $fromRow." ".$fromCol." END <br/>";
				
				
			}
			return $moveOverAttay;
		}
*/
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

		public function checkTo(){//kollar om den slår vän eller motståndare
			if($this -> hitpiece != 0){
				//kollar om pjäs är vit
				if($this-> color == 'w'){
					if($this-> hitpiece >= 9812 && $this -> hitpiece <= 9817 ){ //intervall med de vita
						return FALSE;
					}
				}
				//kollar om pjäs är svart
				if($this-> color == 'b'){
					if($this -> hitpiece  >= 9818 && $this -> hitpiece <= 9823 ){
						return FALSE;
					}
				}
			}
			return TRUE;
		}

		public function pawn(){
			//här ska går diagonalt för att döda
			if($this -> piece == 9823){
				$direction = - 1;
				$firstmove = -2;
				$startrow = 7;
				$endrow = 1;
			}else if($this -> piece == 9817){
				$direction = 1;
				$firstmove = 2;
				$startrow = 2;
				$endrow = 8;
			}
			//här ska går diagonalt för att döda
			if(($this->toCol == $this -> fromCol + 1) || ($this->toCol == $this -> fromCol - 1)){
				if($this->toRow == $this -> fromRow + $direction){ // ett steg framåt
					if($this -> checkTo()){ //kollar vem som står dit man ska, och stoppar om egen färg
						if($this -> hitpiece != 0){ //inte tom, måste slå ut för att få gå diagonalt
							if ($this -> toRow == $endrow){
								return 101;//kröna bonde till dam
							}else{
								return 100;
							}
						}else{ //hitpiece
							return 202;
						}
					}else{ //checkTo
						return 204;
					}						
				}else{ //ett steg
					return 202;
				}
			} 
			//drag för bondens ifrån startposion
			else if($this->fromRow == $startrow && $this->fromCol == $this->toCol){ //startrad + samma kolumn
				if(($this->toRow-$startrow == $direction) || ($this->toRow-$startrow == $firstmove)) {//ska bli 1,2,-1,-2

					if($this -> checkCollision($this -> makeMoveOverArray($this->from, $this->to, $this->yPosToInt))){  //kolla om man går över nåt man inte får
						if($this -> hitpiece == 0){
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
			else if(($this->toRow == $this->fromRow + $direction) && ($this->fromCol == $this->toCol)){
				if($this->hitpiece == 0){
					if ($this->toRow == $endrow){
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

		public function rook(){
			//om en rikning är noll får andra vara hur lång som helst
			if($this -> diagonal["col"] == 0 || $this->diagonal["row"]== 0){ //här går man rakt, dvs diagonalen är 0
				if($this -> checkCollision($this -> makeMoveOverArray($this->from, $this->to, $this->yPosToInt))){ //kolla att man inte går över någon pjäs
					if($this -> checkTo()){ //kolla att ingen egen står på to
						return 100;
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
	
		public function bishop(){
			//om det är lika många steg i båda riktningarna är det en diagonal förflyttning
			if($this->diagonal["col"]== $this -> diagonal["row"]){
				if($this -> checkCollision($this -> makeMoveOverArray($this->from, $this->to, $this->yPosToInt))){
					if($this -> checkTo()){
						return 100;
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
		
		public function knight(){
			
			if(($this->diagonal["row"]== 1 && $this->diagonal["col"]== 2) || ($this->diagonal["row"]== 2 && $this->diagonal["col"]== 1)){
				if($this -> checkTo()){
					return 100;
				}
				else{
					return 204;
				};
			}
			else{
				return 202;
			}
		}

		public function queen(){
			
			if(($this->diagonal["row"]== $this->diagonal["col"]) || (($this->diagonal["row"]== 0) XOR ($this->diagonal["col"]== 0))){
				if($this -> checkCollision($this -> makeMoveOverArray($this->from, $this->to, $this->yPosToInt))){
					if($this -> checkTo()){
						return 100;
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
		
		public function king(){
			
			//om det är lika många steg i båda riktningarna är det en diagonal förflyttning
			if($this->diagonal["col"]<= 1 && $this->diagonal["row"]<= 1){
				if($this -> checkCollision($this -> makeMoveOverArray($this->from, $this->to, $this->yPosToInt))){
					if($this -> checkTo()){
						return 100;
						/*
						if(!checkChess($to, $piece, $yPosToInt, $board)){
							return 100;
						}
						else{
							return 205;
						}
						*/
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
		
		//-------------------------------------------------------
		
		
		public function getColor($code){
			return $this->pieces[$code]; 
		}
		
		public function getPiece($move){
			$from = strtolower(substr($move,0,2)); 
			$to = strtolower(substr($move,3,2));
			$current_piece = $this -> piece;
			return $current_piece;
			
		}
		
		public function checkX($move){
			$from = strtolower(substr($move,0,2)); 
			$to = strtolower(substr($move,3,2));
			if($this -> hitpiece!= 0){ //Den här raden lägger till ett x om man slår ut någon
				$move = $move.'x';	
			}
			return $move;
		}
			
		public function checkHit($move){
			$from = strtolower(substr($move,0,2)); 
			$to = strtolower(substr($move,3,2));
			if($this -> hitpiece!= 0){ //Den här raden lägger till ett x om man slår ut någon
				
				return $this -> hitpiece;	
			}else{
				return FALSE;
			}
			
		}
		
		
		public function updateBoard($move,$board){
			$from = strtolower(substr($move,0,2)); 
			$to = strtolower(substr($move,3,2));
			$current_piece = $board[$from];

			$board[$from] = 0;
			$board[$to] = $current_piece;
			
			return $board;
			
		}
		
		public function updateBoardCrown($move,$board,$turn){
			$from = strtolower(substr($move,0,2)); 
			$to = strtolower(substr($move,3,2));
			if ($turn == "w") {
				$current_piece = "9813";
			} else { 
				$current_piece = "9819";
			}
				
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
				return TRUE;
			}else if($this -> turn == 'b' && $piece_color == 'b'){
				return TRUE;
			}else{
				return FALSE;
			}	
			
		}
			
		public function move(){
			if(!isset($this -> board) || !isset($this -> turn)) {
				throw $this -> createNotFoundException('Unable to find gameboard or turn.');
			}
			
			// kolla syntax ta mar to och from
			$fromto = $this -> checkPattern($this->themove); 
			$from = $fromto[0];
			$to = $fromto[1];

			// hämta pjäs nummer
			$current_piece = $this -> piece;
			
			// Kolla om det är rätt färg som drar
			if(!$this -> checkTurn($current_piece)) {
				// "It's not your turn."
				return 201;
			} 

			$newBoard = $this->board;
			
			$boardAsInt = array();
			foreach($newBoard as $key => $value){
				$boardAsInt[($this -> yPosToInt[substr($key, 0, 1)]) . substr($key, 1, 1)] = $value;
			}

			
			if($this->turn == "w"){
				$kingPos = array_search(9812, $boardAsInt); //vit kung
				// echo $kingPos; 	
				if($this->checkChess($kingPos, 9812, $boardAsInt, "white")) {  
					
					$moveAnswer2 = $this -> checkMove(); 

					if($moveAnswer2 === 100 || $moveAnswer2 === 101){
					
						$newBoard2 = $this->board;
						$newBoard2[$this -> from] = 0;
						$newBoard2[$this-> to] = $this -> piece;

						$boardAsInt2 = array();
						foreach($newBoard as $key => $value){
							$boardAsInt2[($this -> yPosToInt[substr($key, 0, 1)]) . substr($key, 1, 1)] = $value;
						}
						
						if($this->checkChess($kingPos, 9812, $boardAsInt2, "white")){
							$moveAnswer2 = 206;
						} else {
							return $moveAnswer2;
						}

				}
					
			}
			}
			
			else if($this->turn == "b"){ 
				$kingPos = array_search(9818, $boardAsInt); //var står svart kung?
				if($this->checkChess($kingPos, 9818, $boardAsInt, "black")){ //står den i schack? JA
					$moveAnswer2 = $this -> checkMove();  //validera draget

					if($moveAnswer2 === 100 || $moveAnswer2 === 101){ //draget är ok
					
						$newBoard2 = $this->board; //klona brädan
						$newBoard2[$this -> from] = 0;
						$newBoard2[$this-> to] = $this -> piece;

						$boardAsInt = array(); 
						foreach($newBoard as $key => $value){ //gör om kolumner till siffror för beräkning
							$boardAsInt[($this -> yPosToInt[substr($key, 0, 1)]) . substr($key, 1, 1)] = $value;
						}
						
						if($this->checkChess($kingPos, 9818, $boardAsInt, "black")){ //kolla om man fortf står i schack
							$moveAnswer2 = 206; //JA
						} else {
							return $moveAnswer2; //NEJ, draget godkänns och returneras till controller
						}
					}
				}
			}
			
			
			
			$moveAnswer = $this -> checkMove();
			//echo "moveAnswer :".$moveAnswer;
			
			if($moveAnswer === 100 || $moveAnswer === 101){
					
					$newBoard = $this->board;
					$newBoard[$this -> from] = 0;
					$newBoard[$this-> to] = $this -> piece;

					$boardAsInt = array();
					foreach($newBoard as $key => $value){
						$boardAsInt[($this -> yPosToInt[substr($key, 0, 1)]) . substr($key, 1, 1)] = $value;
					}

					//Kolla först om egen kung står i schack
					
					if($this->turn == "w"){
						$kingPos = array_search(9812, $boardAsInt); //vit kung
						// echo $kingPos; 	
						if($this->checkChess($kingPos, 9812, $boardAsInt, "white")){
							$moveAnswer = 205;
						}
					}
					else if($this->turn == "b"){ 
						$kingPos = array_search(9818, $boardAsInt); //var står svart kung?
						if($this->checkChess($kingPos, 9818, $boardAsInt, "black")){
							$moveAnswer = 205;
						}
					}
					return $moveAnswer; 
				}
			return $moveAnswer; 
		}
	}

?>
