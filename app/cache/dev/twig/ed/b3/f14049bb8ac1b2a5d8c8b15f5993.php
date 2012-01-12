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
        echo "    This is where we put the gameboard
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
