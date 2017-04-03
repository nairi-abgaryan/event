<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\PropertyProduct;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PropertyProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('property', EntityType::class, [
                "class" => 'AppBundle\Entity\Property',
                "constraints" => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('name')
            ->add('count')
            ->add('type')
            ->add('image', FileType::class, [
                'constraints' => [
                    new Assert\File(['maxSize' => '8M']),
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
            'csrf_protection' => false,
            'data_class' => PropertyProduct::class,
        ]);
    }
}
