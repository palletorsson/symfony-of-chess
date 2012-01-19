<?php
    
    function checkMove($piece, $from, $to){
    	
		$board = array(
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
			else{
				$y = -1;
			}
			
			if((substr($to, 1, 1) - substr($from, 1, 1)) < 0){
				$x = -1;
			}
			else{
				$x = 1;
			}
			
			$moveOverAttay = array();
			$from = array_search(($yPosToInt[substr($from, 0, 1)] + $y), $yPosToInt) . (substr($from, 1, 1) + $x);
			echo $from. "</br>";
			while($from != $to){
				$moveOverAttay[] = $from;
				$tempFrom = array_search(($yPosToInt[substr($from, 0, 1)] + $y), $yPosToInt) . (substr($from, 1, 1) + $x);
				$from = $tempFrom;
				
			}
			return $moveOverAttay;
		}
		
		function checkTo($piece, $to, $board){
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
		
		
		
    	//black pawn
		if($piece == 9823){
			//här ska går diagonalt för att döda
			if(substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] + 1)) || substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] - 1))){//här ska går diagonalt för att döda
				if(substr($to, 1, 1) == (substr($from, 1, 1)) - 1){
					if(checkTo($piece, $to, $board)){
						return true;
					}
				}
			}
			//drag för bondens ifrån startposion
			else if(substr($from, 1,1) == 7 && array_search(substr($from, 0,1)) == array_search(substr($to, 0,1))){
				if(substr($to, 1,1) == 6 || substr($to, 1,1) == 5){
					if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
						if($board[$to] == 0){
							return true;
						}
					}
				}
			}
			
			// vanligt drag när bonden går ett steg framåt
			else if(substr($to, 1, 1) == (substr($from, 1, 1)) - 1 && array_search(substr($from, 0,1)) == array_search(substr($to, 0,1))){
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
			if(substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] + 1)) || substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] - 1))){//här ska går diagonalt för att döda
				if(substr($to, 1, 1) == (substr($from, 1, 1)) + 1){
					if(checkTo($piece, $to, $board)){
						return true;
					}
				}
			}
			//drag för bondens ifrån startposion
			else if(substr($from, 1,1) == 2 && array_search(substr($from, 0,1)) == array_search(substr($to, 0,1))){
				if(substr($to, 1,1) == 3 || substr($to, 1,1) == 4){
					if(checkCollision(makeMoveOverArray($from, $to, $yPosToInt), $board)){
						if($board[$to] == 0){
							return true;
						}
					}
				}
			}
			
			// vanligt drag när bonden går ett steg framåt
			else if(substr($to, 1, 1) == (substr($from, 1, 1)) + 1 && array_search(substr($from, 0,1)) == array_search(substr($to, 0,1))){
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
				if(checkCollision(makeMoveOverArray($from, $to))){
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
	
	*/
	
	
	
?>