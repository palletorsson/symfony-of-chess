<?php
// src/Blogger/BlogBundle/Form/EnquiryType.php

namespace Bundle\ChessBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('player','text',array('label' =>'Name: '));
        $builder->add('password','password', array('label' => 'Password: '));
        $builder->add('player2','hidden',array('data' =>'John Doe'));
    }

    public function getName()
    {
        return 'players';
    }
}