<?php

namespace PinterestLike\VendorBundle\Form\Type;

use \Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VendorImageType extends AbstractType
{
    private $em;
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categories = $this->getCategoryQB();

        $builder
            ->add(
                'description',
                'textarea',
                array(
                    'required' => true
                )
            )
            ->add(
                'category',
                'entity',
                array(
                    'class' => 'PinterestLike\VendorBundle\Entity\Category',
                    'required' => true,
                    'query_builder' => $categories,
                    'empty_value' => 'Choose Category'
                )
            )
            ->add(
                'remove',
                'hidden',
                array(
                    'required' => false,
                    'mapped' => false
                )
            )
            ;
    }

    public function getCategoryQB()
    {
        $repository = $this->em->getRepository('PinterestLikeVendorBundle:Category');
        return $repository->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC');
    }

    public function getName()
    {
        return 'vendor';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PinterestLike\VendorBundle\Entity\VendorImage',
            'cascade_validation' => true,
            'csrf_protection' => false,
        ));
    }
}