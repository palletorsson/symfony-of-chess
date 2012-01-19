<?php
    
    
    function checkMove($piece, $from, $to){
    	
		function negToPos($number){
			if ($number < 0) {
				return $number * -1;
			}
			else{
				return $number;
			};
		}
		
		
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
			if(substr($from, 1,1) == 7){
				if($to == 6 || $to == 5){
					return true;
				}
			}
			else if($to == $from - 1){
				return true;
			}
			else if(false){//här ska går diagonalt för att döda
				return true;
			}
			else {
				return false;	
			}
			
		}
		//white pawn
		if($piece == 9817){
			if(substr($from, 1,1) == 2){
				if($to == 3 || $to == 4){
					return true;
				}
			}
			else if($to == $from + 1){
				return true;
			}
			else if(false){//här ska går diagonalt för att döda
				return true;
			}
			else {
				return false;	
			}
		}
		//rook
		if($piece == 9820 || $piece == 9814){
			//kolla om toret har flyttat sig på ett av leden
			if($yPosToInt[substr($to, 0,1)] != $yPosToInt[substr($from, 0,1)] xor substr($to, 1,1) != substr($from, 1,1)){
				return true;
			}
		}
		//bishop
		if($piece == 9821 || $piece == 9815){
			$yStep = negToPos($yPosToInt[substr($to, 0, 1)] - $yPosToInt[substr($from, 0, 1)]);//räknar antal y leds steg
			$xStep = negToPos(substr($to, 1, 1) - substr($from, 1, 1));//räknar antal x leds steg
			
			//om det är lika många steg i båda riktningarna är det en diagonal förflyttning
			if($yStep == $xStep){
				return true;
			}
			else {
				return false;
			}
		}
		//knight
		if($piece == 9822 || $piece == 9816){
			
		}
		//queen
		if($piece == 9819 || $piece == 9813){
			
		}
		//king
		if($piece == 9818 || $piece == 9812){
			
		}
		
		
		
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
?>