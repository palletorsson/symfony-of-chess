<?php
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
		
		function checkChess($pos, $piece, $yPosToInt, $board){
			
			function checkKnight($pos, $yPosToInt){//hämtar alla rutor en häst kan gå till utifrån pos
				$moveToArray = array();
				$tempArray = array();
				
				function negativToZero($int){//gör ett negativt tal till noll
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
			
			return false;
		}

		
		
    	//black pawn
		if($piece == 9823){
			//här ska går diagonalt för att döda
			if(substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] + 1), $yPosToInt) || substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] - 1), $yPosToInt)){//här ska går diagonalt för att döda
				if(substr($to, 1, 1) == (substr($from, 1, 1)) - 1){
					if(checkTo($piece, $to, $board)){
						if(!$board[$to] == 0){
							return true;
						};
							
					}
				}
			}
			//drag för bondens ifrån startposion
			else if(substr($from, 1,1) == 7 && substr($from, 0,1) == substr($to, 0,1)){
				if(substr($to, 1,1) == 6 || substr($to, 1,1) == 5){
					if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
						if($board[$to] == 0){
							return true;
						}
					}
				}
			}
			
			// vanligt drag när bonden går ett steg framåt
			else if(substr($to, 1, 1) == (substr($from, 1, 1)) - 1 && array_search(substr($from, 0,1), $yPosToInt) == array_search(substr($to, 0,1), $yPosToInt)){
				if($board[$to] == 0){
					return true;
				}
			}
			
			else {
				return false;	
			}
		}
		//white pawn
		if($piece == 9817){
			//här ska går diagonalt för att döda
			if(substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] + 1), $yPosToInt) || substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] - 1), $yPosToInt)){//här ska går diagonalt för att döda
				if(substr($to, 1, 1) == (substr($from, 1, 1)) + 1){
					if(checkTo($piece, $to, $board)){
						if(!$board[$to] == 0){
							return true;
						};
					}
				}
			}
			//drag för bondens ifrån startposion
			else if(substr($from, 1,1) == 2 && substr($from, 0,1) == substr($to, 0,1)){
				if(substr($to, 1,1) == 3 || substr($to, 1,1) == 4){
					if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
						if($board[$to] == 0){
							return true;
						}
					}
				}
			}
			
			// vanligt drag när bonden går ett steg framåt
			else if(substr($to, 1, 1) == (substr($from, 1, 1)) + 1 && array_search(substr($from, 0,1), $yPosToInt) == array_search(substr($to, 0,1), $yPosToInt)){
				if($board[$to] == 0){
					return true;
				}
			}
			else {
				return false;	
			}
		}
		//rook
		if($piece == 9820 || $piece == 9814){
			$xyarray = xySteps($from, $to ,$yPosToInt);
			//om en rikning är noll får andra vara hur lång som helst
			if($xyarray["y"] == 0 || $xyarray["x"] == 0){
				if(checkCollision(makeMoveOverArray($from, $to), $board)){
					if(checkTo($piece, $to, $board)){
						return true;
					}
				}
			}
			else {
				return false;
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
				}
			}
			else {
				return false;
			}
		}
		//knight
		if($piece == 9822 || $piece == 9816){
			$xyarray = xySteps($from, $to ,$yPosToInt);
			if(($xyarray["x"] == 1 && $xyarray["y"] == 2) || ($xyarray["x"] == 2 && $xyarray["y"] == 1)){
				if(checkTo($piece, $to, $board)){
					return true;
				}
			}
			else{
				return false;
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
				}
			}
			else{
				return false;
			}
			
		}
		//king
		if($piece == 9818 || $piece == 9812){
			$xyarray = xySteps($from, $to ,$yPosToInt);
			//om det är lika många steg i båda riktningarna är det en diagonal förflyttning
			if($xyarray["y"] <= 1 && $xyarray["x"] <= 1){
				if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
					if(checkTo($piece, $to, $board)){
						return true;
					}
				}
			}
			else {
				return false;
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
?>