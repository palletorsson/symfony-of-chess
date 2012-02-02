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
                            var player1 = data.player1;
                            console.log(player1);
                            $('player1').html(player1);
                            
                            var player2 = data.player2;
                            $('player2').html(player2);
                            
                            });
                    });
          }
}; 
