<?php

namespace PinterestLike\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('email', 'email');
        $builder->add('subject');
        $builder->add('body', 'textarea', array('attr' => array('rows' => 4)));
    }

    public function getName()
    {
        return 'pinterestlike_core_contact';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PinterestLike\CoreBundle\Entity\Contact',
            'cascade_validation' => true,
            'csrf_protection' => false,
        ));
    }
}