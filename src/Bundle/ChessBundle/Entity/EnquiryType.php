<?php
// src/Blogger/BlogBundle/Form/EnquiryType.php

namespace Bundle\ChessBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('player1');
        $builder->add('player2');
		$builder->add('savedgame');
    }

    public function getName()
    {
        return 'contact';
    }
}