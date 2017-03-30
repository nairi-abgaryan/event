<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

class PropertyAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
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
            ])
            ->add('insurance',ChoiceType::class, [
                'choices'  => array(
                    'Այո' => true,
                    'Ոչ' => false,
                ),
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
                "required" => false
            ])
            ->add('start', DateType::class, [
                "label" => false
            ])
            ->add('end',  DateType::class, [
                "label" => false
            ])
            ->add('actived',ChoiceType::class, [
                'choices'  => array(
                    'Այո' => true,
                    'Ոչ' => false,
                ),
                "label"=>"Ակտիվացնել"
            ]);
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add("id")
            ->add("start")
            ->add("end")
            ->add("type")
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier("id")
            ->addIdentifier("type")
            ->add("start")
            ->add("end")
            ->add("file",null, array('template' => 'AppBundle:admin:list_image.html.twig'))
        ;
    }
}
