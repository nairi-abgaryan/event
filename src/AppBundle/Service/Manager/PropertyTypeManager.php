<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\PropertyType;
use AppBundle\Repository\PropertyTypeRepository;
use Doctrine\ORM\EntityManager;

class PropertyTypeManager
{
    /**
     * @var PropertyTypeRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PropertyTypeManager constructor.
     *
     * @param PropertyTypeRepository $repository
     * @param EntityManager          $em
     */
    public function __construct(PropertyTypeRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @return object|null|PropertyType
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }
}
