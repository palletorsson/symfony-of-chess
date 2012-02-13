<?php
// src/Blogger/BlogBundle/Form/EnquiryType.php

namespace Bundle\ChessBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EnquiryType2 extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('player2','text',array('label' =>'Player 2: '));
        
    }

    public function getName()
    {
        return 'players';
    }
}