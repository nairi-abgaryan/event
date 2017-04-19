<?php

namespace AppBundle\Service\Manager;

use AppBundle\Repository\ProductTypeRepository;
use Doctrine\ORM\EntityManager;

class ProductTypeManager
{
    /**
     * @var ProductTypeRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PropertyProductRepository constructor.
     *
     * @param ProductTypeRepository $repository
     * @param EntityManager          $em
     */
    public function __construct(ProductTypeRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAll()
    {
        $qb = $this->repository->createQueryBuilder('property_category');

        return $qb;
    }

    /**
     * @return mixed
     */
    public function find($id)
    {
        $qb = $this->repository->find($id);

        return $qb;
    }
}

