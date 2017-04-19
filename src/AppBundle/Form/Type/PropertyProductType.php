<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\ProductType;
use AppBundle\Entity\PropertyProduct;
use Sonata\MediaBundle\Form\Type\MediaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('count')
            ->add('type', EntityType::class, [
                "class" => ProductType::class
            ])
            ->add('name')
            ->add('image', MediaType::class, [
                "required" => false,
                'provider' => 'sonata.media.provider.image',
                'context' => 'default',
            ])
        ;
        $builder->get('image')->remove('unlink');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertyProduct::class,
            'csrf_protection' => false,
        ]);
    }
}
