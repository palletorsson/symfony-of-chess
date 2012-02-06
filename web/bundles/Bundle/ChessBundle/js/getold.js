window.onload = function() {  
	var a = document.getElementById("startoldgame");
    
    a.onclick = function() {
		
		var oldgameid = prompt('Enter the gameid: ', 1);
		
		$.getJSON('oldgame/'+oldgameid, function(data) {						
			console.log(data);
			
			$('#whiteprint').html(' ');
			$('#blackprint').html(' ');
			$('#x_piece').html(' ');
			
			
			var gameboard = data.gameboard;
			$.each(gameboard, function(key, val) {
				if (val != '0'){ 
					$('#'+key.toUpperCase()).html('&#' + val +';');
				}
				if (val == '0') {
					$('#'+key.toUpperCase()).html('');
				}	
			});
			
			var gameid = data.gameid;
			$('#thegameid').html(gameid);
			
			var player1 = data.player1;
	        $('#player1').html(player1);             
	        
	        var player2 = data.player2;
	        $('#player2').html(player2);  
	        
	        var whitedraws = data.whitedraws;
	        $.each(whitedraws, function(key, val) {
				var piece =  '&#' + val.substring(0,4)+';';
				var move = val.substring(4,10) ;
				$('#whiteprint').append(piece + ' ' + move + '<br />');
			});	
			
			var blackdraws = data.blackdraws;
			$.each(blackdraws, function(key, val) {
				var piece = '&#'+val.substring(0,4)+';';
				var move = val.substring(4,10) ;
				$('#blackprint').append(piece + ' ' + move + '<br />');
			});	
				
			var hitpieces = data.hitpieces;
			$.each(hitpieces, function(key, val) {
				$('#x_piece').append('&#'+val+'; ');
			});	
			                         
			
		});
	 }   
}; 
