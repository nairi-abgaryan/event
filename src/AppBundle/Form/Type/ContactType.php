<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Property;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
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
                ],
                "required" => false
            ])
            ->add('category', EntityType::class, [
                "class" => 'AppBundle\Entity\PropertyCategory',
                "multiple" => true,
                'expanded' => true,
                "required" => false,
            ])
            ->add('start', DateType::class, array(
                'label' => 'false',
                "widget" => "single_text",
                "input" =>"datetime",
                "required" => false
            ))
            ->add('end', DateType::class, array(
                'label' => 'false',
                "widget" => "single_text",
                "input" =>"datetime",
                "required" => false
            ))
            ->add('propertyType', ChoiceType::class, [
                'choices'  => array(
                    'Ապրանք' => 1,
                    'Աշխատանք' => 2,
                    'Ծառաություն' => 3,
                ),
                "label"=>false,
                "required" => false
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => "AppBundle\Entity\Property",
            'csrf_protection' => false,
        ]);
    }
}
