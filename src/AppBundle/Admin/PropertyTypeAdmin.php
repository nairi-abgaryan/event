<?php

namespace AppBundle\Admin;

use AppBundle\Entity\PropertyType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PropertyTypeAdmin extends AbstractAdmin
{
    /**
     * @var string image name
     */
    public $data = '';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var PropertyType $object */
        $object = $this->getSubject();
        $photoHelper = $this->getConfigurationPool()
            ->getContainer()->get('app.admin_helper')
            ->getPhotoHelper($object->getImage());

        $formMapper
            ->add('name')
            ->add('limitDays')
            ->add('image', 'sonata_media_type', [
                'provider' => 'sonata.media.provider.image',
                'context' => 'default',
                'help' => $photoHelper,
            ])
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('limitDays')
        ;
    }
}
