<?php
namespace Bundle\ChessBundle\Entity;




	class Move{

		private $board = array();
		private $turn;
		private $piece;
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
			$this -> $from = substr($themove,0,2);
			$this -> $to = substr($themove,3,2);
			
			//här konverteras movens bokstav till ett nummer från formet som A1-A2
			$this -> $fromCol = $this -> yPosToInt[substr($themove,0,1)];
			$this -> $fromRow = substr($themove,1,1);
			$this -> $toCol = $this -> yPosToInt[substr($themove,3,1)];
			$this -> $toRow = substr($themove,4,1);
			
			$this -> piece = $gameboard[$this -> from];	
			$this -> hitpiece = $gameboard[$this -> to];
			
			
			$this -> color = substr($this -> pieces[$this->piece], 0, 1);
			$this -> diagonal["col"] = abs($this -> toCol - $this ->fromCol); 
			$this -> diagonal["row"] = abs($this -> toRow - $this ->fromRow); 
		}
		
		//gör ett negativt tal till noll
		private function negativToZero($int){
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

		public function checkUp($kingCol, $kingRow, $color, $board){
			$x = $kingRow;
			$x++;
			while ($x <= 8) {
				$y = $kingCol;
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
		
		public function checkDown($kingRow, $kingCol, $color, $board){
			$x = $kingRow;
			$x--;
			while ($x >= 1) {
				$y = $kingCol;
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
		
		
		public function checkRight($kingCol, $kingRow, $color, $board){
			$y = $kingCol;
			$y++;
			while ($y <= 8) {
				$x = $kingRow;
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
				
				$y++;
			}
			return false;
		}
		
		public function checkLeft($kingCol, $kingRow, $color, $board){
			$y = $kingCol;
			$y--;
			while ($y >= 1) {
				$x = $kingRow;
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
				
				$y--;
			}
			return false;
		}
		
		public function checkUpRight($kingCol, $kingRow, $color, $board){
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
				
				if($board[$y . $x] != 0){
					if($color == "white"){
						if($board[$y . $x] == 9821 || $board[$y . $x] == 9819 ){
							return true;
						}
					}
					else if($color == "black"){
						if($board[$y . $x] == 9815 || $board[$y . $x] == 9813 ){
							return true;
						}
					}
					else{
						return false;
					}
				}
				$y++;
				$x++;
			}
			return false;
		}
		
		public function checkUpLeft($kingCol, $kingRow, $color, $board){
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
				
				if($board[$y . $x] != 0){
					if($color == "white"){
						if($board[$y . $x] == 9821 || $board[$y . $x] == 9819 ){
							return true;
						}
					}
					else if($color == "black"){
						if($board[$y . $x] == 9815 || $board[$y . $x] == 9813 ){
							return true;
						}
					}
					else{
						return false;
					}
				}
				$y--;
				$x++;
			}
			return false;
		}
		
		public function checkDownRight($kingCol, $kingRow, $color, $board){
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
				
				if($board[$y . $x] != 0){
					if($color == "white"){
						if($board[$y . $x] == 9821 || $board[$y . $x] == 9819 ){
							return true;
						}
					}
					else if($color == "black"){
						if($board[$y . $x] == 9815 || $board[$y . $x] == 9813 ){
							return true;
						}
					}
					else{
						return false;
					}
				}
				$y++;
				$x--;
			}
			return false;
		}
		
		public function checkDownLeft($kingCol, $kingRow, $color, $board){
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
				
				if($board[$y . $x] != 0){
					if($color == "white"){

						if($board[$y . $x] == 9821 || $board[$y . $x] == 9819 ){
							return true;
						}
					}
					else if($color == "black"){

						if($board[$y . $x] == 9815 || $board[$y . $x] == 9813 ){
							return true;
						}
					}
					else{
						return false;
					}
				}
				$y--;
				$x--;
			}
			return false;
		}





		/*
		public function checkStraight($row, $col, $color, $board, $pieceB1, $pieceB2, $pieceW1, $pieceW2, $x, $y, $limit){

			$row + $x; //FÖRST +1, SEN -1, SEN 0
			$col + $y; //FÖRST 
			
			if($x != 0){
				while ($row <= $limit) {
					$y = $kingColLetter;
						if($color == "white"){
							if($board[$y . $x] == $pieceB1 || $board[$y . $x] == $pieceB2){  //svart torn, drottning
								return TRUE;
							}
						}
						else if($color == "black"){
							if($board[$y . $x] == $pieceW1 || $board[$y . $x] == $pieceW2){ //vit torn, drottning
								return TRUE;
							}
						}
						else{
							return FALSE;
							}
					}
				$row+$x;
				$col+$y;	
			}
		}
			for($i = $kingCol--; $i <= $kingCol++; $i++){
				for($j = $kingRow--; $j <= $kingRow++; $j++){
					if($board[$i.$j] != 0){
						
					} 
				}
			}
		 * 				
		*/
		//kollar om pos är hotad att blir slagen. Behöver $piece som en kung för att avgöra färg return true om pos kan bli slagen
		public function checkChess($pos, $piece, $board){ //$pos = kingposition $piece=kungens kod $board=nya boarden
			
			//dessa två variabler håller i hela checkChess funktionen
			
			$kingCol = $this -> yPosToInt[substr($pos,0,1)];
			$kingRow = substr($pos,1,1);
			
		
			$color = ""; //kungens färg
			if($piece == 9812){  //vit kung
				$color = "white";
			}
			else if($piece == 9818){ //svart kung
				$color = "black";
			}
			else{
				return false;
			}
			
			
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
			
			if($this -> checkUp($pos, $color, $board)){
				return true;
			}
			if($this -> checkDown($pos, $color, $board)){
				return true;
			}
			if($this -> checkRight($pos, $color, $board)){
				return true;
			}
			if($this -> checkLeft($pos, $color, $board)){
				return true;
			}
			if($this -> checkUpRight($pos, $color, $board)){
				return true;
			}
			if($this -> checkUpLeft($pos, $color, $board)){
				return true;
			}
			if($this -> checkDownRight($pos, $color, $board)){
				return true;
			}
			if($this -> checkDownLeft($pos, $color, $board)){
				return true;
			}
			
			return false;
			
			
			
			
		}

		public function checkMove(){
	    	
			switch($this -> piece){
				case 9823:
				case 9817:
					$this->pawn();
					break;
				case 9820:
				case 9814:
					$this -> rook();
					break;
				case 9821:
				case 9815:
					$this -> bishop();
					break;
				case 9822:
				case 9816:
					$this -> knight();
					break;
				case 9819:
				case 9813:
					$this -> queen();
					break;
				case 9818:
				case 9812:
					$this -> king();
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

		public function makeMoveOverArray(){
			//Kollar riktning på drag
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
			
			//from + 1 eller så, nästa position
			$from = array_search($this->fromCol + $y, $this -> yPosToInt) . $this->fromRow + $x; //genererar ett from i format a3
			
			while($from != $this -> to){
				$moveOverAttay[] = $from;
				$tempFrom = array_search($this->fromCol + $y, $this -> yPosToInt) . $this->fromRow + $x; //nästa steg
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
				if(($this->toRow-$startrow == ($direction || $firstmove))) {//ska bli 1,2,-1,-2

					if($this -> checkCollision($this -> makeMoveOverArray())){  //kolla om man går över nåt man inte får

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
				if($this -> checkCollision($this -> makeMoveOverArray())){ //kolla att man inte går över någon pjäs
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
				if($this -> checkCollision($this -> makeMoveOverArray())){
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
				if($this -> checkCollision($this -> makeMoveOverArray())){
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
				if($this -> checkCollision($this -> makeMoveOverArray())){
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
			$current_piece = $this -> board[$from];
			return $current_piece;
			
		}
		
		public function checkX($move){
			$from = strtolower(substr($move,0,2)); 
			$to = strtolower(substr($move,3,2));
			if($this -> board[$to] != 0){ //Den här raden lägger till ett x om man slår ut någon
				$move = $move.'x';	
			}
			return $move;
		}
			
		public function checkHit($move){
			$from = strtolower(substr($move,0,2)); 
			$to = strtolower(substr($move,3,2));
			if($this -> board[$to] != 0){ //Den här raden lägger till ett x om man slår ut någon
				$x_piece = $this -> board[$to];
				return $x_piece;	
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
			$fromto = $this -> checkPattern($themove); 
			$from = $fromto[0];
			$to = $fromto[1];

			// hämta pjäs nummer
			$current_piece = $this -> board[$from];
			
			// Kolla om det är rätt färg som drar
			if(!$this -> checkTurn($current_piece)) {
				// "It's not your turn."
				$error_201 = 201;
				return $error_201;
			} 
			
			$moveAnswer = $this -> checkMove();
			//echo "moveAnswer :".$moveAnswer;
			
			if($moveAnswer === 100 || $moveAnswer === 101){
					
					$newBoard = $this->board;
					$newBoard[$this -> from] = 0;
					$newBoard[$this-> to] = $this -> current_piece;

					$boardAsInt = array();
					foreach($newBoard as $key => $value){
						$boardAsInt[($this -> yPosToInt[substr($key, 0, 1)]) . substr($key, 1, 1)] = $value;
					}

					//Kolla först om egen kung står i schack
					if($this->turn == "w"){
						$kingPos = array_search(9812, $boardAsInt); //vit kung
						if($this->checkChess($kingPos, 9812, $boardAsInt)){

							$moveAnswer = 205;
						}
					}
					else if($this->turn == "b"){
						$kingPos = array_search(9818, $boardAsInt); //var står svart kung?
						if($this->checkChess($kingPos, 9818, $boardAsInt)){
							$moveAnswer = 205;
						}
					}
				}
			return $moveAnswer; 
		}
		

	}

?>
