<?php

/* BundleChessBundle:Default:index.html.twig */
class __TwigTemplate_582dd742e00bc2f6c6f14324d45c197d extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "Hello ";
        echo twig_escape_filter($this->env, $this->getContext($context, "name"), "html", null, true);
        echo "!
";
    }

    public function getTemplateName()
    {
        return "BundleChessBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
