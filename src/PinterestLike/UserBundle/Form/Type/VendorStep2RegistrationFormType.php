<?php

namespace PinterestLike\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VendorStep2RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $years = range(date('Y'), date('Y') - 80);
        $yearsWedding = range(date('Y'), date('Y') + 10);
        
        $builder
            ->add(
                'name',
                'text',
                array(
                    'required'  => true,
                    'label'     => 'Business Name',
                    'attr'      => array(
                        'class'       => 'form-control',
                        'placeholder' => 'Business Name'
                    )
                )
            )
            ->add(
                'contactPerson',
                'text',
                array(
                    'required' => true,
                    'label'     => 'Contact Person',
                    'attr'     => array(
                        'class'       => 'form-control',
                        'placeholder' => 'Contact Person'
                    )
                )
            )
            ->add(
                'phone',
                'text',
                array(
                    'required' => true,
                    'label'     => 'Phone Number',
                    'attr'     => array(
                        'class'       => 'form-control',
                        'placeholder' => 'Phone Number'
                    )
                )
            )
            ->add(
                'mobile',
                'text',
                array(
                    'required' => true,
                    'label'     => 'Mobile Number',
                    'attr'     => array(
                        'class'       => 'form-control',
                        'placeholder' => 'Mobile Number'
                    )
                )
            )
            ->add(
                'address',
                'textarea',
                array(
                    'required' => true,
                    'label'     => 'Address',
                    'attr'     => array(
                        'class'       => 'form-control',
                        'placeholder' => 'Address'
                    )
                )
            )
            ->add(
                'state',
                'text',
                array(
                    'required' => false,
                    'label'     => 'State',
                    'attr'     => array(
                        'class'       => 'form-control',
                        'placeholder' => 'State'
                    )
                )
            )
            ->add('country', 'choice', 
                array(
                    'required' => true, 'choices' => array('SG' => 'Singapore'), 'expanded' => false
                )
            )
            ->add(
                'description',
                'textarea',
                array(
                    'required' => false,
                    'label'     => 'Describe your business/service',
                    'attr'     => array(
                        'class'       => 'form-control',
                        'placeholder' => 'State'
                    )
                )
            )
            ->add(
                'website',
                'text',
                array(
                    'required' => false,
                    'label'     => 'Website',
                    'attr'     => array(
                        'class'       => 'form-control',
                        'placeholder' => 'Website'
                    )
                )
            )
            ->add(
                'logo',
                'hidden',
                array(
                    'required' => false,
                    'attr' => array(
                        'class' => 'logo-path'
                    )
                )
            )
            ->add(
                'file',
                'file',
                array(
                    'error_bubbling' => true,
                    'required' => false,
                    'attr' => array(
                        'class' => 'logo-file',
                        'label'     => 'Your logo',
                        'formnovalidate' => 'formnovalidate',
                        'accept' => '*/*'
                    )
                )
            )
            ;
    }
    
    public function getName()
    {
        return 'vendor';
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