<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Property;
use AppBundle\Form\Extension\Base64FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PropertyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, [
                "class" => 'AppBundle\Entity\PropertyType',
                "constraints" => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('category', EntityType::class, [
                "class" => 'AppBundle\Entity\PropertyCategory',
                "constraints" => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('financing', ChoiceType::class, [
                'choices'  => array(
                    'Կանխիկ' => true,
                    'Անկանխիկ' => false,
                ),
                "label"=>false
            ])
            ->add('insurance',ChoiceType::class, [
                'choices'  => array(
                    'Այո' => true,
                    'Ոչ' => false,
                ),
                "label"=>false
            ])
            ->add('shipment')
            ->add('advance')
            ->add('budget', IntegerType::class, [
                "label" =>false
            ])
            ->add('overview', TextareaType::class, [
                "label" => false
            ])
            ->add('filePdf', FileType::class, [
                'constraints' => [
                    new Assert\File(['maxSize' => '4M']),
                ],
            ])
            ->add('start', DateType::class, [
                "label" => false
            ])
            ->add('end',  DateType::class, [
                "label" => false
            ])
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
