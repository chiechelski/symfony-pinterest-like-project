<?php

namespace PinterestLike\UserBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VendorImagesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder
            ->add('file','file',array(
                    "attr" => array(
                        "accept" => "image/*",
                        "multiple" => "multiple",
                    )
                ))
            ;
    }
    
    public function getName()
    {
        return '';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PinterestLike\VendorBundle\Entity\Vendor',
            'cascade_validation' => true,
            'csrf_protection' => false,
        ));
    }
}