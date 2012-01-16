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
	var to = event.target.getAttribute('id');
	var txt = from+"-"+to;
	var piece = document.getElementById(from).innerHTML;
	console.log(piece);
	event.preventDefault(); // Consider using `event.preventDefault` instead
	var text = document.createTextNode(from+"-"+to);
	// we can add the code for the piece and send it to the server. 
	// proceed only if the xmlHttp object isn't busy
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) {
		// retrieve the name typed by the user on the form
		text = encodeURIComponent(txt);
		// execute the /Entity/Game.php page from the server
		xmlHttp.open("GET", "http://localhost/symfony-of-chess/src/Bundle/ChessBundle/Entity/Game.php?text=" + txt, true);
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
			xmlResponse = xmlHttp.responseXML;
			// obtain the document element (the root element) of the XML structure
			xmlDocumentElement = xmlResponse.documentElement;
			// get the text message, which is in the first child of game.php
			move = xmlDocumentElement.firstChild.data;
			// update the client display using the data received from the server
			// now update the board
			// if (move.lenght < 6) {
				document.getElementById("moves").innerHTML = move;
				var from = move.substring(0,2);
				var to = move.substring(3,5);
				var element = document.getElementById(from);
				var target = document.getElementById(to);
				target.innerHTML = element.innerHTML; // Moving piece to new cell
				element.innerHTML = ""; // Clearing old cell	
			// } else {	
			// document.getElementById("moves").innerHTML = move;
			// }
		}
		// a HTTP status different than 200 signals an error
		else {
			alert("There was a problem accessing the server: " +
			xmlHttp.statusText);
		}
	}
}
