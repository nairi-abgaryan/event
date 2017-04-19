<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Property;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Sonata\MediaBundle\Form\Type\MediaType;;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('insurance', ChoiceType::class, [
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
            ->add('file', MediaType::class, [
                "required" => false,
                'provider' => 'sonata.media.provider.file',
                'context' => 'default'
            ])
            ->add('start', DateType::class, array(
                'label' => 'Սկիզբ',
                "widget" => "single_text",
                "input" =>"datetime"
            ))
            ->add('end', DateType::class, array(
                'label' => 'Վերջ',
                "widget" => "single_text",
                "input" =>"datetime"
            ))
            ->add('propertyType', ChoiceType::class, [
                'choices'  => array(
                    'Ապրանք' => "Ապրանք",
                    'Աշխատանք' => "Աշխատանք",
                    'Ծառաություն' => "Ծառաություն",
                ),
                "label"=>false
            ]);
        $builder->get('file')->remove('unlink');
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
