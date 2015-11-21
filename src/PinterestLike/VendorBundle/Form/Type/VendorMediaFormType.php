<?php

namespace PinterestLike\VendorBundle\Form\Type;

use \Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PinterestLike\VendorBundle\Form\Type\VendorImageType;
use PinterestLike\VendorBundle\Form\Type\VendorVideoType;

class VendorMediaFormType extends AbstractType
{
    private $em;
    public function __construct(\Doctrine\ORM\EntityManager $em, $type = 'images')
    {
        $this->em = $em;
        $this->type = $type;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categories = $this->getCategoryOptions();
        $colours = $this->getColourOptions();

        // aux values
        $builder
            ->add(
                'description',
                'textarea',
                array(
                    'required' => false,
                    'mapped' => false
                )
            )
            ->add(
                'category',
                'choice',
                array(
                    'choices' => $categories,
                    'required' => false,
                    'mapped' => false
                )
            )
            ->add(
                'colour',
                'choice',
                array(
                    'choices' => $colours,
                    'required' => false,
                    'mapped' => false
                )
            )
            ->add(
                'remove',
                'hidden',
                array(
                    'required' => false,
                    'mapped' => false
                )
            );

        if ($this->type == 'videos' || $this->type == 'both') {
            $builder
                ->add(
                    'videos',
                    'collection',
                    array(
                        'type' => new VendorVideoType($this->em)
                    )
                )
                /*->add(
                    'videoUrl',
                    'text'
                )*/;
        }

        if ($this->type == 'images' || $this->type == 'both') {
            $builder
                ->add(
                    'images',
                    'collection',
                    array(
                        'type' => new VendorImageType($this->em)
                    )
                );
        }
    }

    public function getCategoryOptions()
    {
        $categories = array(
            '' => 'Choose Category'
        );

        $repository = $this->em->getRepository('PinterestLikeVendorBundle:Category');
        $results = $repository->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $categories[$result->getId()] = $result->getName();
        }

        return $categories;
    }

    public function getColourOptions()
    {
        $colours = array(
            '' => 'Choose Colour'
        );

        $repository = $this->em->getRepository('PinterestLikeVendorBundle:Colour');
        $results = $repository->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();

        foreach ($results as $result) {
            $colours[$result->getId()] = $result->getName();
        }

        return $colours;
    }

    public function getName()
    {
        return 'vendor_' . $this->type;
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