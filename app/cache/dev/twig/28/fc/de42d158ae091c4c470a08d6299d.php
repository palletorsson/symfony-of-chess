<?php

/* BundleChessBundle::layout.html.twig */
class __TwigTemplate_28fcde42d158ae091c4c470a08d6299d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'sidebar' => array($this, 'block_sidebar'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_sidebar($context, array $blocks = array())
    {
        // line 5
        echo "<div id=\"start\">Start-button. </div></br></br>
\t

<div id=\"moves\">Game Moves: </br></br> </div>

";
    }

    public function getTemplateName()
    {
        return "BundleChessBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
