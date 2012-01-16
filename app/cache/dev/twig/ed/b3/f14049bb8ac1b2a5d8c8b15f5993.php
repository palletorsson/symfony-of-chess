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
        echo "\t
\t<!-- ******************************************************************** -->
\t<!-- The content below is for demonstration of some common HTML5 elements  -->
\t<!-- orginal code found at http://www.buryknightschess.org.uk/play-chess/ -->
\t
\t<div id=\"board\" ondragstart=\"dragStart(event);\" ondragover=\"return dragOver(event);\" ondrop=\"return drop(event);\" >
\t\t\t
\t<ul>
\t\t<div id=\"coord\" class=\" 5 dsq\" ><span class=\"label\">8</span></div>

\t\t<li id=\"A8\" draggable=\"true\">&#9820;</li>
\t\t<li id=\"B8\" class=\"5 dsq\" draggable=\"true\">&#9822;</li>
\t\t<li id=\"C8\" draggable=\"true\">&#9821;</li>
\t\t<li id=\"D8\" class=\"5 dsq\" draggable=\"true\">&#9819;</li>
\t\t<li id=\"E8\" draggable=\"true\">&#9818;</li>
\t\t<li id=\"F8\" class=\"5 dsq\" draggable=\"true\">&#9821;</li>
\t\t<li id=\"G8\" draggable=\"true\">&#9822;</li>\t
\t\t<li id=\"H8\"class=\"5 dsq\" draggable=\"true\">&#9820;</li>
\t</ul>
\t<ul>
\t\t<div id=\"coord\" class=\"5 dsq\" ><span class=\"label\">7</span></div>

\t\t<li id=\"A7\" draggable=\"true\">&#9823; </li>
\t\t<li id=\"B7\" draggable=\"true\">&#9823;</li>
\t\t<li id=\"C7\" class=\"5 dsq\" draggable=\"true\">&#9823;</li>
\t\t<li id=\"D7\" draggable=\"true\">&#9823; </li>
\t\t<li id=\"E7\" class=\"5 dsq\" draggable=\"true\">&#9823;</li>
\t\t<li id=\"F7\" draggable=\"true\" >&#9823; </li>
\t\t<li id=\"G7\" class=\"5 dsq\" draggable=\"true\">&#9823;</li>\t
\t\t<li id=\"H7\" draggable=\"true\" >&#9823;</li>

\t</ul>
\t<ul>
\t\t<div id=\"coord\"class=\"5 dsq\"><span class=\"label\">6</span></div>

\t\t<li id=\"A6\" draggable=\"true\"></li>
\t\t<li id=\"B6\" class=\"5 dsq\" draggable=\"true\"></li>\t
\t\t<li id=\"C6\" draggable=\"true\"></li>\t
\t\t<li id=\"D6\" class=\"5 dsq\" draggable=\"true\"></li>\t
\t\t<li id=\"E6\" draggable=\"true\"></li>\t
\t\t<li id=\"F6\" class=\"5 dsq\" draggable=\"true\" ></li>\t
\t\t<li id=\"G6\" draggable=\"true\"></li>\t
\t\t<li id=\"H6\" class=\"5 dsq\" draggable=\"true\" ></li>\t
\t</ul>

\t\t
\t<ul>
\t\t<div id=\"coord\" class=\" 5 dsq\"><span class=\"label\">5</span></div>

\t\t<li id=\"A5\" draggable=\"true\"></li>
\t\t<li id=\"B5\" draggable=\"true\"></li>
\t\t<li id=\"C5\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"D5\" draggable=\"true\"></li>
\t\t<li id=\"E5\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"F5\" draggable=\"true\"></li>
\t\t<li id=\"G5\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"H5\" draggable=\"true\"></li>
\t</ul>
\t\t\t\t
\t<ul>
\t\t<div id=\"coord\" class=\"5 dsq\"><span class=\"label\">4</span></div>\t

\t\t<li id=\"A4\" draggable=\"true\"></li>
\t\t<li id=\"B4\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"C4\" draggable=\"true\"></li>
\t\t<li id=\"D4\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"E4\" draggable=\"true\"></li>
\t\t<li id=\"F4\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"G4\" draggable=\"true\"></li>
\t\t<li id=\"H4\" class=\"5 dsq\"draggable=\"true\"></li>
\t</ul>
\t\t\t\t
\t<ul>
\t\t<div id=\"coord\" class=\"5 dsq\"><span class=\"label\">3</span></div>\t\t
\t\t
\t\t<li id=\"A3\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"B3\" draggable=\"true\"></li>
\t\t<li id=\"C3\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"D3\" draggable=\"true\"></li>
\t\t<li id=\"E3\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"F3\" draggable=\"true\"></li>
\t\t<li id=\"G3\" class=\"5 dsq\"draggable=\"true\"></li>
\t\t<li id=\"H3\" draggable=\"true\"></li>
\t</ul>
\t\t\t\t
\t<ul>
\t\t<div id=\"coord\" class=\" 5 dsq\"><span class=\"label\">2</span></div>\t\t

\t\t<li id=\"A2\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"B2\" class=\"5 dsq\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"C2\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"D2\" class=\"5 dsq\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"E2\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"F2\" class=\"5 dsq\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"G2\" draggable=\"true\">&#9817;</li>
\t\t<li id=\"H2\" class=\"5 dsq\" draggable=\"true\">&#9817;</li>
\t</ul>
\t
\t<ul>

\t\t<div id=\"coord\" class=\" 5 dsq\"><span class=\"label\">1</span></div>\t\t

\t\t<li id=\"A1\" class=\"5 dsq\" draggable=\"true\">&#9814;</li>
\t\t<li id=\"B1\" draggable=\"true\">&#9816;</li>
\t\t<li id=\"C1\" class=\"5 dsq\" draggable=\"true\">&#9815;</li>
\t\t<li id=\"D1\" draggable=\"true\">&#9813;</li>
\t\t<li id=\"E1\"class=\"5 dsq\" draggable=\"true\">&#9812;</li>
\t\t<li id=\"F1\" draggable=\"true\">&#9815;</li>
\t\t<li id=\"G1\" class=\"5 dsq\" draggable=\"true\">&#9816;</li>
\t\t<li id=\"H1\" draggable=\"true\">&#9814;</li>

\t</ul>
\t\t<div id=\"coord_bottom_bar\" class=\" 5 dsq\">\t
\t
\t    <div id=\"coord_bottom_bar_no\">  <span class=\"coordbot_dsq\">A</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">B</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">C</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">D</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">E</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">F</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">G</span></div>
\t\t<div id=\"coord_bottom_bar_no\">\t<span class=\"coordbot_dsq\">H</span></div>
\t</ul>
\t
\t<script type=\"text/javascript\" src=\"";
        // line 128
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/Bundle/ChessBundle/js/events.js"), "html", null, true);
        echo "\"></script>
 \t<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-1.4.2.min.js\"></script>

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
