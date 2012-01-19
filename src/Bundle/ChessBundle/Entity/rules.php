<?php
    
    function checkMove($piece, $from, $to){
    	
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
		function xySteps(){
			$xystep = array(
			'y' => negToPos($yPosToInt[substr($to, 0, 1)] - $yPosToInt[substr($from, 0, 1)]),//räknar antal y leds steg
			'x' => negToPos(substr($to, 1, 1) - substr($from, 1, 1))//räknar antal x leds steg
			);
			return $xystep;
		}
		
		function checkCollision($moveOverArray){
			foreach ($moveOverArray as $node) {
				if($board[$node] != 0){
					return false;
				}
			}
			return true;
		}
		
		function makeMoveOverArray($from, $to){
				
			if(($yPosToInt[substr($from, 0, 1)] - $yPosToInt[substr($to, 0, 1)]) < 0){
				$y = 1;
			}
			else{
				$y = -1;
			}
			
			if((substr($to, 1, 1) - substr($from, 1, 1)) < 0){
				$x = 1;
			}
			else{
				$x = -1;
			}
			
			$moveOverAttay = array();
			$from = array_search(($yPosToInt[substr($from, 0, 1)] + $y), $yPosToInt) . (substr($from, 1, 1) + $x);
			
			while($from != $to){
				$moveOverAttay[] = $from;
				$from = "" . array_search(($yPosToInt[substr($from, 0, 1)] + $y), $yPosToInt) . (substr($from, 1, 1) + $x);
			}
			return $moveOverAttay;
		}
		
		function checkTo($piece, $to){
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
		
    	//black pawn
		if($piece == 9823){
			//här ska går diagonalt för att döda
			if(substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] + 1)) || substr($to, 0, 1) == array_search(($yPosToInt[substr($from, 0, 1)] - 1))){//här ska går diagonalt för att döda
				if(substr($to, 1, 1) == (substr($from, 1, 1)) - 1){
					if(checkTo($piece, $to)){
						return true;
					}
				}
			}
			//drag för bondens ifrån startposion
			else if(substr($from, 1,1) == 7 && array_search(substr($from, 0,1)) == array_search(substr($to, 0,1))){
				if(substr($to, 1,1) == 6 || substr($to, 1,1) == 5){
					if(checkCollision(makeMoveOverArray($from, $to))){
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
					if(checkTo($piece, $to)){
						return true;
					}
				}
			}
			//drag för bondens ifrån startposion
			else if(substr($from, 1,1) == 2 && array_search(substr($from, 0,1)) == array_search(substr($to, 0,1))){
				if(substr($to, 1,1) == 3 || substr($to, 1,1) == 4){
					if(checkCollision(makeMoveOverArray($from, $to))){
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
			$xyarray = xySteps();
			//om en rikning är noll får andra vara hur lång som helst
			if($xyarray["y"] == 0 || $xyarray["x"] == 0){
				if(checkCollision(makeMoveOverArray($from, $to))){
					if(checkTo($piece, $to)){
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
			$xyarray = xySteps();
			
			//om det är lika många steg i båda riktningarna är det en diagonal förflyttning
			if($xyarray["y"] == $xyarray["x"]){
				if(checkCollision(makeMoveOverArray($from, $to))){
					if(checkTo($piece, $to)){
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
			$xyarray = xySteps();
			if(($xyarray["x"] == 1 && $xyarray["y"] == 2) || ($xyarray["x"] == 2 && $xyarray["y"] == 1)){
				if(checkTo($piece, $to)){
					return true;
				}
			}
			else{
				return false;
			}
		}
		//queen
		if($piece == 9819 || $piece == 9813){
			$xyarray = xySteps();
			if($xyarray["x"] == $xyarray["y"] || ($xyarray["x"] == 0 xor $xyarray["y"] == 0)){
				if(checkCollision(makeMoveOverArray($from, $to))){
					if(checkTo($piece, $to)){
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
			$xyarray = xySteps();
			//om det är lika många steg i båda riktningarna är det en diagonal förflyttning
			if($xyarray["y"] <= 1 && $xyarray["x"] <= 1){
				if(checkCollision(makeMoveOverArray($from, $to))){
					if(checkTo($piece, $to)){
						return true;
					}
				}
			}
			else {
				return false;
			}
		}
    }
    
?>