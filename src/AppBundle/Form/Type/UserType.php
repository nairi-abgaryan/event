<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
                'label' => false,
            ])
            ->add('plainPassword', PasswordType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => false,
            ])
            ->add('phoneNumber', TextType::class, [
                "required" => false,
                'label' => false
            ])
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => false,
            ])
            ->add('companyName', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => false,
            ])
            ->add('businessAddress', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => false,
            ])
            ->add('legalAddress', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                "required" =>false,
                'label' => false,
            ])
            ->add('tin', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'label' => false,
            ])
            ->add('description', TextareaType::class,[
                'label' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => User::class
        ]);
    }
}
