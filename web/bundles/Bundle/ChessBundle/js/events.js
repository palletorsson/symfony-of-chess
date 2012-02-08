// stores the reference to the XMLHttpRequest object
var xmlHttp = createXmlHttpRequestObject()
	, whosturn = 'w'
	, piece
	, move;

$(document).ready(function(){
	$('#start a').click(function(){
		var answer = confirm('A new game will be started, please save this game first unless you want to lose it. Continue?');
		if(answer){
			return true;
		}else{
			return false;
		}
	});
	
	$('.whiteturn').html('Your turn');
	
	$('#savegame').click(function(){
		var currentgameid = document.getElementById('thegameid').innerHTML;
		alert('This game is saved with a game id of ' + currentgameid);
	});

});


function addHighlight(color){
	if(color == 'w'){
		$('.whiteturn').html('Your turn');
		$('.blackturn').html('');
	}else if(color == 'b'){
		$('.blackturn').html('Your turn');
		$('.whiteturn').html('');
	}
}
// retrieves the XMLHttpRequest object
function createXmlHttpRequestObject() {
	// will store the reference to the XMLHttpRequest object
	var xmlHttp;
	// if running Internet Explorer
	if(window.ActiveXObject) {
		try {
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e) {
			xmlHttp = false;
		}
	}
	// if running Mozilla or other browsers
	else {
		try {
			xmlHttp = new XMLHttpRequest();
		}
		catch (e) {
			xmlHttp = false;
		}
	}
	
	// return the created object or display an error message
	if (!xmlHttp)
		alert("Error creating the XMLHttpRequest object.");
	else
		return xmlHttp;
}
	
function dragStart(event) {
	event.dataTransfer.effectAllowed = 'move';
	event.dataTransfer.setData("Text", event.target.getAttribute('id'));
}

function dragOver(event) {
	return false;
}

function getHit(whatcell){ //funktion för att ta vara på utslagna pjäser
	if(whatcell.innerHTML != ''){ //Den här raden lägger till ett x om man slår ut någon
		var x_piece = whatcell.innerHTML;
		move += 'x';
		document.getElementById("x_piece").innerHTML += x_piece + " ";
	}
}

function updateTurn(whatpiece, whatmove){
	if(whosturn == 'w'){
		document.getElementById("whiteprint").innerHTML += whatpiece + whatmove + "<br />";
		whosturn = 'b'
		addHighlight('b');
	}else{
		document.getElementById("blackprint").innerHTML +=  whatpiece + whatmove + "<br />";
		whosturn = 'w'
		addHighlight('w');
	}
}

function drop(event) {
	event.preventDefault(); // Consider using `event.preventDefault` instead
	var from = event.dataTransfer.getData("Text");
	var to = event.target.getAttribute('id');
	piece = document.getElementById(from).innerHTML;
	var gameid = document.getElementById('thegameid').innerHTML;
	var txt = from + "-" + to + gameid;
	var text = document.createTextNode(from+"-"+to);
	// we can add the code for the piece and send it to the server. 
	// proceed only if the xmlHttp object isn't busy
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) {
		// retrieve the name typed by the user on the form
		text = encodeURIComponent(txt);
		//alert(txt);
		xmlHttp.open('GET', 'move/'+txt, true);
		//	$.post("/move",{ str: text },function( data ){
		//	},"json" );	
		// define the method to handle server responses
		xmlHttp.onreadystatechange = handleServerResponse;
		// make the server request
		xmlHttp.send(null);
	}
	return false;
}
// executed automatically when a message is received from the server
function handleServerResponse()	{
	// move forward only if the transaction has completed
	if (xmlHttp.readyState == 4) {
	// status of 200 indicates the transaction completed successfully
		if (xmlHttp.status == 200) {
			// extract the XML retrieved from the server						
			xmlDoc = xmlHttp.responseXML; 
			// obtain the document element (the root element) of the XML structure
			//console.log(xmlDoc);
			// get the text message, which is in the first child of game.php
			// obtain the document element (the root element) of the XML structure
			xmlDocumentElement = xmlDoc.documentElement;
			// get the text message, which is in the first child of
			// the the document element
			move = xmlDocumentElement.firstChild.data;
			//alert(move);	
			var errormsg = 	{
							 "201" : "It's not your turn."
							,"202" : "This move is against the game rules."
							,"203" : "Another piece in the way"
							,"204" : "You cannot move there."
							,"204" : "You can not move on a friendly piece."
							,"205" : "King can't move into chess."
							};
			
			if (move > 200) {
				msg =  errormsg[move];
				document.getElementById("error").innerHTML = msg;
				$('#error').html(msg).fadeIn("slow");
				$('#error').fadeOut(3000);
			} 
			else if (move.substring(0,3) == 101) {
				var from = move.substring(3,5);	 
				var to = move.substring(6,8);
				var element = document.getElementById(from);
				var target = document.getElementById(to);
				getHit(target);
				var p = element.innerHTML;				 
				if (move.substring(8,9) == "w") { 
					target.innerHTML = "&#9819;"; // Make it a Queen
				} else {
					target.innerHTML = "&#9813;"; // Make it a Queen
				}	
				element.innerHTML = ""; // Clearing old cell
				updateTurn(piece,move);
			}
			else {
				// update the client display using the data received 
				
				var from = move.substring(0,2); 
				var to = move.substring(3,5);
				var element = document.getElementById(from);
				var target = document.getElementById(to);
				getHit(target);
			 	target.innerHTML = element.innerHTML; // Moving piece to new cell
				element.innerHTML = ""; // Clearing old cell	
				updateTurn(piece, move);
			}
		}
		// a HTTP status different than 200 signals an error
		else {
			alert("There was a problem accessing the server: " +
			xmlHttp.statusText);
		}
	}
}
