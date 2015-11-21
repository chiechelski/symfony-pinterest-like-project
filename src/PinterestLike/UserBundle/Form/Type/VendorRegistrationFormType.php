<?php

namespace PinterestLike\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VendorRegistrationFormType extends RegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'hidden', array('value' => 'vendor'));
    }
}