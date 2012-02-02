window.onload = function() {  
	var a = document.getElementById("startoldgame");
    
    a.onclick = function() {
	$.getJSON('oldgame/1', function(data) {						
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
			$('#whitemoves').append(val);
		});	
		
		var blackdraws = data.blackdraws;
		$.each(blackdraws, function(key, val) {
			$('#blackmoves').append(val);
		});	
		
		                         
		
	});
    }
}; 
