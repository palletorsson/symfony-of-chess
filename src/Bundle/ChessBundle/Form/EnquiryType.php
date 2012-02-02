<?php
// src/Blogger/BlogBundle/Form/EnquiryType.php

namespace Bundle\ChessBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('player_1');
        $builder->add('player_2');
		$builder->add('saved_game', 'text');
    }

    public function getName()
    {
        return 'players';
    }
}