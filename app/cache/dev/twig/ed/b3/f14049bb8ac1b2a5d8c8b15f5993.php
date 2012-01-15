<?php

/* BundleChessBundle:Game:index.html.twig */
class __TwigTemplate_edb3f14049bb8ac1b2a5d8c8b15f5993 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "BundleChessBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "<script type=\"text/javascript\">

// stores the reference to the XMLHttpRequest object
var xmlHttp = createXmlHttpRequestObject();
// retrieves the XMLHttpRequest object
function createXmlHttpRequestObject() {
\t// will store the reference to the XMLHttpRequest object
\tvar xmlHttp;
\t// if running Internet Explorer
\tif(window.ActiveXObject) {
\t\ttry {
\t\t\txmlHttp = new ActiveXObject(\"Microsoft.XMLHTTP\");
\t\t}
\t\tcatch (e) {
\t\txmlHttp = false;
\t\t}
\t}
\t// if running Mozilla or other browsers
\telse {
\t\ttry {
\t\txmlHttp = new XMLHttpRequest();
\t\t}
\t\tcatch (e) {
\t\txmlHttp = false;
\t}
}

// return the created object or display an error message
if (!xmlHttp)
\talert(\"Error creating the XMLHttpRequest object.\");
else
\treturn xmlHttp;
}
\t
function dragStart(event) {
\tevent.dataTransfer.effectAllowed = 'move';
\tevent.dataTransfer.setData(\"Text\", event.target.getAttribute('id'));
}

function dragOver(event) {
\treturn false;
}

function drop(event) {
var from = event.dataTransfer.getData(\"Text\");
var to = event.target.getAttribute('id');
var txt = from+\"-\"+to;
event.preventDefault(); // Consider using `event.preventDefault` instead
var text = document.createTextNode(from+\"-\"+to);
\t// proceed only if the xmlHttp object isn't busy
if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0) {
\t// retrieve the name typed by the user on the form
\ttext = encodeURIComponent(txt);
\t// execute the /Entity/Game.php page from the server
\txmlHttp.open(\"GET\", \"http://localhost/symfony-of-chess/src/Bundle/ChessBundle/Entity/Game.php?text=\" + txt, true);
\t// define the method to handle server responses
\txmlHttp.onreadystatechange = handleServerResponse;
\t// make the server request
\txmlHttp.send(null);
}
// else
// if the connection is busy, try again after one second
// setTimeout('drop()', 1000);

return false;
}


// executed automatically when a message is received from the server
function handleServerResponse()\t{
\t// move forward only if the transaction has completed
\tif (xmlHttp.readyState == 4) {
\tconsole.log('server working'); 
\t// status of 200 indicates the transaction completed successfully
\t\tif (xmlHttp.status == 200) {
\t\t// extract the XML retrieved from the server
\t\txmlResponse = xmlHttp.responseXML;

\t\t// obtain the document element (the root element) of the XML structure
\t\txmlDocumentElement = xmlResponse.documentElement;
\t\t// get the text message, which is in the first child of
\t\t// the the document element
\t\tmove = xmlDocumentElement.firstChild.data;
\t\t// update the client display using the data received from the server
\t\tdocument.getElementById(\"moves\").innerHTML = move;
\t\t// now update the board
\t\tvar from = move.substring(0,2);
\t\tconsole.log(to);
\t\tvar to = move.substring(3,5);
\t\tconsole.log(from);
\t\tvar element = document.getElementById(from);
\t\tconsole.log(element);\t\t
\t\tvar target = document.getElementById(to);
\t\t
\t\t
\t\ttarget.innerHTML = element.innerHTML; // Moving piece to new cell
\t\tconsole.log(element.innerHTML);
\t\telement.innerHTML = \"\"; // Clearing old cell\t\t
\t\t// restart sequence
\t\t// setTimeout('process()', 1000);
\t\t}
\t\t// a HTTP status different than 200 signals an error
\t\telse {
\t\t\talert(\"There was a problem accessing the server: \" +
\t\t\txmlHttp.statusText);
\t\t}
\t}
}

</script>\t
\t
\t<!-- ******************************************************************** -->
\t<!-- The content below is for demonstration of some common HTML5 elements  -->
\t<!-- orginal code found at http://www.buryknightschess.org.uk/play-chess/ -->
\t
\t<div id=\"board\" ondragstart=\"dragStart(event);\" ondragover=\"return dragOver(event);\" ondrop=\"return drop(event);\" >
\t
\t\t
\t<ul>
\t\t<div id=\"coord\" class=\" 5 dsq\" ><span class=\"label\">8</span></div>

\t\t<li id=\"A8\"  draggable=\"true\">&#9820;</li>
\t\t<li id=\"B8\" class=\"5 dsq\" draggable=\"true\">&#9822;</li>
\t\t<li id=\"C8\"  draggable=\"true\">&#9821;</li>
\t\t<li id=\"D8\" class=\"5 dsq\" draggable=\"true\">&#9819;</li>
\t\t<li id=\"E8\"  draggable=\"true\">&#9818;</li>
\t\t<li id=\"F8\"class=\"5 dsq\" draggable=\"true\">&#9821;</li>
\t\t<li id=\"G8\"  draggable=\"true\">&#9822;</li>\t
\t\t<li id=\"H8\"class=\"5 dsq\"  draggable=\"true\">&#9820;</li>
\t</ul>
\t\t
\t\t
\t<ul>
\t\t<div id=\"coord\" class=\" 5 dsq\" ><span class=\"label\">7</span></div>

\t\t<li id=\"A7\"  draggable=\"true\">&#9823; </li>
\t\t<li id=\"B7\"  draggable=\"true\">&#9823;</li>
\t\t<li id=\"C7\"class=\"5 dsq\"  draggable=\"true\">&#9823;</li>
\t\t<li id=\"D7\" draggable=\"true\" >&#9823; </li>
\t\t<li id=\"E7\" class=\"5 dsq\" draggable=\"true\">&#9823;</li>
\t\t<li id=\"F7\" draggable=\"true\" >&#9823; </li>
\t\t<li id=\"G7\" class=\"5 dsq\"  draggable=\"true\">&#9823;</li>\t
\t\t<li id=\"H7\" draggable=\"true\" >&#9823;</li>

\t</ul>

\t\t\t
\t<ul>
\t\t<div id=\"coord\"class=\"5 dsq\"><span class=\"label\">6</span></div>
\t\t<li id=\"A6\"draggable=\"true\" ></li>
\t\t<li id=\"B6\"class=\"5 dsq\"draggable=\"true\"></li>\t
\t\t<li id=\"C6\"draggable=\"true\"></li>\t
\t\t<li id=\"D6\"class=\"5 dsq\"draggable=\"true\"></li>\t
\t\t<li id=\"E6\"draggable=\"true\"></li>\t
\t\t<li id=\"F6\"class=\"5 dsq\"draggable=\"true\" ></li>\t
\t\t<li id=\"G6\"draggable=\"true\"></li>\t
\t\t<li id=\"H6\"class=\"5 dsq\"draggable=\"true\" ></li>\t
\t</ul>

\t\t
\t<ul>
\t\t<div id=\"coord\" class=\" 5 dsq\"><span class=\"label\">5</span></div>

\t\t<li id=\"A5\"draggable=\"true\"></li>
\t\t<li id=\"B5\"draggable=\"true\"></li>
\t\t<li id=\"C5\"class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"D5\"draggable=\"true\"></li>
\t\t<li id=\"E5\"class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"F5\"draggable=\"true\"></li>
\t\t<li id=\"G5\"class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"H5\"draggable=\"true\"></li>
\t</ul>
\t\t\t\t
\t<ul>
\t\t<div id=\"coord\" class=\"5 dsq\"><span class=\"label\">4</span></div>\t

\t\t<li id=\"A4\"draggable=\"true\"></li>
\t\t<li id=\"B4\"class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"C4\"draggable=\"true\"></li>
\t\t<li id=\"D4\"class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"E4\"draggable=\"true\"></li>
\t\t<li id=\"F4\"class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"G4\"draggable=\"true\"></li>
\t\t<li id=\"H4\"class=\"5 dsq\"draggable=\"true\"></li>
\t</ul>
\t\t\t\t
\t<ul>
\t\t<div id=\"coord\" class=\"5 dsq\"><span class=\"label\">3</span></div>\t\t
\t\t<li id=\"A3\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"B3\"draggable=\"true\"></li>
\t\t<li id=\"C3\"class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"D3\"draggable=\"true\"></li>
\t\t<li id=\"E3\"class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"F3\"draggable=\"true\"></li>
\t\t<li id=\"G3\"class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"H3\"draggable=\"true\"></li>
\t</ul>
\t\t\t\t
\t<ul>
\t<div id=\"coord\" class=\" 5 dsq\"><span class=\"label\">2</span></div>\t\t
\t\t<li id=\"A2\"  draggable=\"true\">&#9817;</li>
\t\t<li id=\"B2\"class=\"5 dsq\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"C2\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"D2\"class=\"5 dsq\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"E2\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"F2\"class=\"5 dsq\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"G2\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"H2\"class=\"5 dsq\" draggable=\"true\">&#9817;</li>
\t</ul>
\t
\t<ul>

\t\t<div id=\"coord\" class=\" 5 dsq\"><span class=\"label\">1</span></div>\t\t
\t\t<li id=\"A1\"class=\" 5 dsq\" draggable=\"true\">&#9814;</li>
\t\t<li id=\"B1\" draggable=\"true\">&#9816;</li>
\t\t<li id=\"C1\"class=\" 5 dsq\" draggable=\"true\">&#9815;</li>
\t\t<li id=\"D1\" draggable=\"true\">&#9813;</li>
\t\t<li id=\"E1\"class=\" 5 dsq\" draggable=\"true\">&#9812;</li>
\t\t<li id=\"F1\" draggable=\"true\">&#9815;</li>
\t\t<li id=\"G1\"class=\" 5 dsq\" draggable=\"true\">&#9816;</li>
\t\t<li id=\"H1\" draggable=\"true\">&#9814;</li>

\t</ul>
\t\t<div id=\"coord_bottom_bar\" class=\" 5 dsq\">\t
\t
\t        <div id=\"coord_bottom_bar_no\">  <span class=\"coordbot_dsq\">A</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">B</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">C</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">D</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">E</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">F</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">G</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">H</span></div>
\t</ul>
\t\t\t\t\t
\t<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-1.4.2.min.js\">
        </script>

";
    }

    public function getTemplateName()
    {
        return "BundleChessBundle:Game:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
