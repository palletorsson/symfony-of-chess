$(document).ready(function(){

var a = document.getElementById("startoldgame");
a.onclick = startoldGame();
}
   
function startoldGame() {
	var oldgameid = prompt('Enter the gameid: ', 1);
		 
	$.getJSON('oldgame/'+oldgameid, function(data) {						
		console.log(data); 
		var gameboard = data.gameboard;
		$.each(gameboard, function(key, val) {
			if (val != "0"){ 
				$('#'+key.toUpperCase()).html('&#' + val +';');
			}
			if (val == '0') {
				$('#'+key.toUpperCase()).html('');
			}	
		});
		
		var player1 = data.player1;
        $('#player1').html(player1);             
        
        var player2 = data.player2;
        $('#player2').html(player2);  
        
        var whitedraws = data.whitedraws;
		$.each(whitedraws, function(key, val) {
			var piece =  val.substring(0,3);
			var move = '&#' + val.substring(3) +';';
			$('#whitemoves').append(piece + ' ' + val);
		});	
		
		var blackdraws = data.blackdraws;
		var piece =  val.substring(0,3);
		var move = '&#' + val.substring(3) +';';
		$('#blackmoves').append(piece + ' ' + val);
	
		var hitpieces = data.hitpieces; 
		$.each(hitpieces, function(key, val) {
			var hitp = '&#' + val +';';
			$('#x_piece').append(hitp + ' ');
		});	
		});	                 
	
		
	retrieveTurnStatus(gameid);		
}

