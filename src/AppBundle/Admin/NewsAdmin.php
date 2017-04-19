<?php

namespace AppBundle\Admin;

use AppBundle\Entity\News;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;

class NewsAdmin extends AbstractAdmin
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
        /** @var News $object */
        $object = $this->getSubject();
        $photoHelper = $this->getConfigurationPool()
            ->getContainer()->get('app.admin_helper')
            ->getPhotoHelper($object->getImage());

        $formMapper
            ->add('description')
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
        $datagridMapper->add('id');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('image');
    }
}
