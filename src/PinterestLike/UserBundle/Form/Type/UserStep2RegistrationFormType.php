<?php

namespace PinterestLike\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserStep2RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $years = range(date('Y'), date('Y') - 80);
        $yearsWedding = range(date('Y'), date('Y') + 10);

        // setting up wedding data
        $weddingDate = null;
        if ($options['data']->getWedding()) {
            $weddingDate = $options['data']->getWedding()->getWeddingDate();
        }

        $builder
            ->add(
                'firstName',
                'text',
                array(
                    'required'  => true,
                    'label'     => 'Name',
                    'attr'      => array(
                        'class'       => 'form-control',
                        'placeholder' => 'First Name'
                    )
                )
            )
            ->add(
                'lastName',
                'text',
                array(
                    'required' => true,
                    'attr'     => array(
                        'class'       => 'form-control',
                        'placeholder' => 'Last Name'
                    )
                )
            )
            ->add('dateOfBirth', 'birthday',
                array(
                    'required'  => false,
                    'widget'    => 'choice',
                    'format'    => 'dd/MM/yyyy',
                    'years'     => $years,
                    'empty_value' => array(
                        'year' => 'Year',
                        'month' => 'Month',
                        'day' => 'Day'
                    )
                )
            )
            ->add('weddingDate', 'date',
                array(
                    'required'  => false,
                    'widget'    => 'choice',
                    'mapped'    => false,
                    'data'      => $weddingDate,
                    'format'    => 'dd/MM/yyyy',
                    'years'     => $yearsWedding,
                    'empty_value' => array(
                        'year' => 'Year',
                        'month' => 'Month',
                        'day' => 'Day'
                    )
                )
            )
            ->add('gender', 'choice',
                array(
                    'required' => true, 'choices' => array('m' => 'Male', 'f' => 'Female'), 'expanded' => true
                )
            );
    }

    public function getName()
    {
        return 'user';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PinterestLike\UserBundle\Entity\User',
            'cascade_validation' => true,
            'csrf_protection' => false,
        ));
    }
}