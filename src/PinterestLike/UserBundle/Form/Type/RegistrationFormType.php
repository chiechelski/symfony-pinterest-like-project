<?php

namespace PinterestLike\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('terms', 'checkbox', array('mapped' => false));
        $builder->remove('username');
        $builder->add('username', 'hidden');
        $builder->add('type', 'hidden', array('data' => 'user', 'mapped' => 'true'));
        $builder->add('registrationStep', 'hidden', array('data' => 'step2', 'mapped' => 'true'));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'PinterestLike_user_registration';
    }
}