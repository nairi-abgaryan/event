<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('owner')
            ->add('category')
            ->add('latitude')
            ->add('longitude')
            ->add('state')
            ->add('zipCode')
            ->add('price')
            ->add('overview')
            ->add('units')
            ->add('kitchen')
            ->add('beds')
            ->add('baths')
            ->add('halfBaths')
            ->add('sqFt')
            ->add('lotSqFt')
            ->add('builtIn')
            ->add('priceSqFt')
            ->add('lastSold')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'csrf_protection' => false,
        ]);
    }
}
