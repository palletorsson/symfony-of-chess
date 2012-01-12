<?php

/* BundleChessBundle:Game:index.html.twig */
class __TwigTemplate_922b7fead6c9ba2c9cee833f5429dd3e extends Twig_Template
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
        echo "\t<div class=\"chessboard\">
\t\t<div class='white' id='a8'></div> 
\t\t<div class='black' id='b8'></div> 
\t\t<div class='white' id='c8'></div> 
\t\t<div class='black' id='d8'></div> 
\t\t<div class='white' id='e8'></div> 
\t\t<div class='black' id='f8'></div> 
\t\t<div class='white' id='g8'></div> 
\t\t<div class='black' id='h8'></div> 
\t\t<div class='black' id='a7'></div> 
\t\t<div class='white' id='b7'></div> 
\t\t<div class='black' id='c7'></div> 
\t\t<div class='white' id='d7'></div> 
\t\t<div class='black' id='e7'></div> 
\t\t<div class='white' id='f7'></div> 
\t\t<div class='black' id='g7'></div> 
\t\t<div class='white' id='h7'></div> 
\t\t<div class='white' id='a6'></div> 
\t\t<div class='black' id='b6'></div> 
\t\t<div class='white' id='c6'></div> 
\t\t<div class='black' id='d6'></div> 
\t\t<div class='white' id='e6'></div> 
\t\t<div class='black' id='f6'></div> 
\t\t<div class='white' id='g6'></div> 
\t\t<div class='black' id='h6'></div> 
\t\t<div class='black' id='a5'></div> 
\t\t<div class='white' id='b5'></div> 
\t\t<div class='black' id='c5'></div> 
\t\t<div class='white' id='d5'></div> 
\t\t<div class='black' id='e5'></div> 
\t\t<div class='white' id='f5'></div> 
\t\t<div class='black' id='g5'></div> 
\t\t<div class='white' id='h5'></div> 
\t\t<div class='white' id='a4'></div> 
\t\t<div class='black' id='b4'></div> 
\t\t<div class='white' id='c4'></div> 
\t\t<div class='black' id='d4'></div> 
\t\t<div class='white' id='e4'></div> 
\t\t<div class='black' id='f4'></div> 
\t\t<div class='white' id='g4'></div> 
\t\t<div class='black' id='h4'></div> 
\t\t<div class='black' id='a3'></div> 
\t\t<div class='white' id='b3'></div> 
\t\t<div class='black' id='c3'></div> 
\t\t<div class='white' id='d3'></div> 
\t\t<div class='black' id='e3'></div> 
\t\t<div class='white' id='f3'></div> 
\t\t<div class='black' id='g3'></div> 
\t\t<div class='white' id='h3'></div> 
\t\t<div class='white' id='a2'></div> 
\t\t<div class='black' id='b2'></div> 
\t\t<div class='white' id='c2'></div> 
\t\t<div class='black' id='d2'></div> 
\t\t<div class='white' id='e2'></div> 
\t\t<div class='black' id='f2'></div> 
\t\t<div class='white' id='g2'></div> 
\t\t<div class='black' id='h2'></div> 
\t\t<div class='black' id='a1'></div> 
\t\t<div class='white' id='b1'></div> 
\t\t<div class='black' id='c1'></div> 
\t\t<div class='white' id='d1'></div> 
\t\t<div class='black' id='e1'></div> 
\t\t<div class='white' id='f1'></div> 
\t\t<div class='black' id='g1'></div> 
\t\t<div class='white' id='h1'></div> 
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
