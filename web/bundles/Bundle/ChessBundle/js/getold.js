window.onload = function() {  
	var a = document.getElementById("startoldgame");
    
    a.onclick = function() {
		var answer = confirm('Another game will be loaded, please save this game first unless you want to lose it. Continue?');
		if(!answer){
			return false;
		}else{
		
		var oldgameid = prompt('Enter the gameid: ', 1);
		
		//ajax med json: arg1 skickar ajaxen, arg2 bestämmer hur svaret ska hanteras, data är json-
		//objektet som returneras från servern
		
		$.getJSON('oldgame/'+oldgameid, function(data) {						

			var gameboard = data.gameboard;
	        var whitedraws = data.whitedraws;
			var blackdraws = data.blackdraws;
			var hitpieces = data.hitpieces;

			$('#whiteprint').html('');
			$('#blackprint').html('');
			$('#x_piece').html('');

			$('#thegameid').html(data.gameid);
	        $('#player1').html(data.player1);             
	        $('#player2').html(data.player2);  

			$.each(gameboard, function(key, val) {
				if (val != '0'){ 
					$('#'+key.toUpperCase()).html('&#' + val +';');
				}
				if (val == '0') {
					$('#'+key.toUpperCase()).html('');
				}	
			});
	        
	        $.each(whitedraws, function(key, val) {
				var piece =  '&#' + val.substring(0,4)+';';
				var move = val.substring(4,10) ;
				$('#whiteprint').append(piece + ' ' + move + '<br />');
			});	
			
			$.each(blackdraws, function(key, val) {
				var piece = '&#'+val.substring(0,4)+';';
				var move = val.substring(4,10) ;
				$('#blackprint').append(piece + ' ' + move + '<br />');
			});	
				
			$.each(hitpieces, function(key, val) {
				$('#x_piece').append('&#'+ val +'; ');
			});	
			                         
			
		});
	 }   
}	
}; 
