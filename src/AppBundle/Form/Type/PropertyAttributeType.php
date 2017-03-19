<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\PropertyAttribute;
use AppBundle\Form\Extension\Base64FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PropertyAttributeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('property')
            ->add('condition')
            ->add('type')
            ->add('imageFile', Base64FileType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\File(['maxSize' => '4M']),
                    new Assert\Image(),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertyAttribute::class,
            'csrf_protection' => false,
        ]);
    }
}
