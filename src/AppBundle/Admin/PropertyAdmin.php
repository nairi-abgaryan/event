<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Property;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class PropertyAdmin extends AbstractAdmin
{

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var Property $object */
        $object = $this->getSubject();
        $photoHelper = $this->getConfigurationPool()
            ->getContainer()->get('app.admin_helper')
            ->getFileHelper($object->getFile());

        $formMapper
            ->add('type', EntityType::class, [
                "class" => 'AppBundle\Entity\PropertyType',
                "constraints" => [
                    new Assert\NotBlank()
                ],
                "label" => "Մրցույթի տեսակը"
            ])
            ->add('category', EntityType::class, [
                "class" => 'AppBundle\Entity\PropertyCategory',
                "constraints" => [
                    new Assert\NotBlank()
                ],
                "label" => "ծառայության տեսակը"
            ])
            ->add('financing', ChoiceType::class, [
                'choices'  => array(
                    'Կանխիկ' => true,
                    'Անկանխիկ' => false,
                ),
                    "label" => "Ֆինանսավորման ձև"
                ]
            )
            ->add('insurance',ChoiceType::class, [
                'choices'  => array(
                    'Այո' => true,
                    'Ոչ' => false,
                ),
                "label" => "Ապահովագրություն"
            ])
            ->add('shipment',TextType::class, [
                "label" => "Առաքում"
            ])
            ->add('advance',IntegerType::class, [
                "label" => "Կանխավճար"
            ])
            ->add('budget', IntegerType::class, [
                "label" => "Մրցույթային բյուջեն"
            ])
            ->add('overview', TextareaType::class, [
                "label" => "Մրցույթի համառոտ բնութագիր"
            ])
            ->add('file',  'sonata_media_type', [
                'provider' => 'sonata.media.provider.file',
                'context' => 'default',
            ])
            ->add('start', DateType::class, [
                "label" => "Սկզիբ"
            ])
            ->add('end',  DateType::class, [
                "label" => "Վերջ"
            ])
            ->add('actived',ChoiceType::class, [
                'choices'  => array(
                    'Այո' => true,
                    'Ոչ' => false,
                ),
                "label"=>"Ակտիվացնել"
            ])
            ->add('product', 'sonata_type_collection',
                array('by_reference' => true, 'btn_add' => false),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            );
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
            ->add("budget")
            ->add("owner")
            ->add("start")
            ->add("end")
            ->add("file",null, array('template' => 'AppBundle:admin:list_image.html.twig'))
            ->add("download",null, array("template"=>":help:download.html.twig"))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('myCustom'); // Action gets added automatically
        $collection->add('view', $this->getRouterIdParameter().'/view');
    }
}
