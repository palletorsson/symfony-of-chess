// stores the reference to the XMLHttpRequest object
var xmlHttp = createXmlHttpRequestObject();
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

function drop(event) {
	var from = event.dataTransfer.getData("Text");
	console.log(from);	
	var to = event.target.getAttribute('id');
	var piece = document.getElementById(from).innerHTML;
	var txt = from+"-"+to;
	event.preventDefault(); // Consider using `event.preventDefault` instead
	var text = document.createTextNode(from+"-"+to);
	// we can add the code for the piece and send it to the server. 
	// proceed only if the xmlHttp object isn't busy
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) {
		// retrieve the name typed by the user on the form
		text = encodeURIComponent(txt);
		xmlHttp.open("GET", "move/"+txt, true);
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
			console.log(xmlDoc);
			// get the text message, which is in the first child of game.php
			// obtain the document element (the root element) of the XML structure
			xmlDocumentElement = xmlDoc.documentElement;
			// get the text message, which is in the first child of
			// the the document element
			move = xmlDocumentElement.firstChild.data;
			
			var errormsg =  {
									 "201" : "It's not your turn."
									,"202" : "This move is against the game rules."
									,"203" : "Another piece in the way"
									,"204" : "You can not move on a frindly piece."
									,"205" : "King can't move into chess."
									};
			if (move > 200) {
				msg =  errormsg[move];
				document.getElementById("error").innerHTML = msg;
				$('#error').hide().fadeIn("slow");
				$('#error').fadeOut(3000);
			} else if (move == 101) {
				var from = txt.substring(0,2); 
				var to = txt.substring(3,5);
				var element = document.getElementById(from);
				var target = document.getElementById(to);
				target.innerHTML = "&#9818;"; // Make it a Queen
				element.innerHTML = ""; // Clearing old cell
			}
			else {
				// update the client display using the data received 
				document.getElementById("moves").innerHTML +=  move + "<br />";
				var from = move.substring(0,2); 
				var to = move.substring(3,5);
				var element = document.getElementById(from);
				var target = document.getElementById(to);
				target.innerHTML = element.innerHTML; // Moving piece to new cell
				element.innerHTML = ""; // Clearing old cell	
			}
		}
		// a HTTP status different than 200 signals an error
		else {
			alert("There was a problem accessing the server: " +
			xmlHttp.statusText);
		}
	}
}
