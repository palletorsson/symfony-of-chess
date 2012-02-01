<?php
// src/Blogger/BlogBundle/Form/EnquiryType.php

namespace Bundle\ChessBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('p1');
        $builder->add('p2');
    }

    public function getName()
    {
        return 'contact';
    }
}