<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Image;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ImageAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('owner')
            ->add('file', 'file');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('owner');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('owner');
    }

    /**
     * @param mixed $image
     */
    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    /**
     * @param mixed $image
     */
    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    /**
     * @param Image $image
     */
    private function manageFileUpload(Image $image)
    {
        $this->getConfigurationPool()->getContainer()
            ->get('app.image_manager')->uploadFromAdmin($image);
    }
}
