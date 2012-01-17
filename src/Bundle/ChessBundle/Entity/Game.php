<?php
// we'll generate XML output
header('Content-Type: text/xml');
// generate XML header
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
// create the <response> element
echo '<response>';
// retrieve the user name <response> A3-A4 </response>
$string = $_GET['text'];
// $string = strtolower($string);
$pattern = "/^[A-H]{1}+[0-9]{1}[-][A-H]{1}+[0-9]{1}/";
// explode hand check that the input was of avalide type (a4-b6)
// check taht letter and number in right order.
if (preg_match($pattern, $string)) {
   // check if moved farward and return string to board
   if ($string[1]+1 == $string[4]) { 
       $string_array = explode('-', $string);
       $from = $string_array[0]; 
       $to = $string_array[1];
       echo $from.":".$to; 
   } else {
		echo "invalide move";
		return false; // 
   }
   
} else {
    echo "invalide syntax";
    return false; // 
}

// close the <response> element
echo '</response>';

/**
$arr = array(
            array(
                    "pi" => "Black Pawn",
                    "from" => $from,
					"to" => $to,
                  ),
    );

    echo json_encode($arr);

placeras i en klass och en metod 
* 
**/

?>
