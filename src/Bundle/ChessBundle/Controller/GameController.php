<?php
// src/Bundle/ChessBundle/Controller/GameController.php

namespace Bundle\ChessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
	public function indexAction()
    {
        return $this->render('BundleChessBundle::index.html.twig');
    }

    public function gameAction()
    {
        return $this->render('BundleChessBundle:Game:index.html.twig');
    }



}
