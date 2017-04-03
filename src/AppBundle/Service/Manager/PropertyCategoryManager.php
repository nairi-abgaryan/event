<?php

namespace AppBundle\Service\Manager;

use AppBundle\Repository\PropertyCategoryRepository;
use Doctrine\ORM\EntityManager;

class PropertyCategoryManager
{
    /**
     * @var PropertyCategoryRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PropertyCategoryRepository constructor.
     *
     * @param PropertyCategoryRepository $repository
     * @param EntityManager          $em
     */
    public function __construct(PropertyCategoryRepository $repository, EntityManager $em)
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
     * @param array $criteria
     *
     * @return mixed
     */
    public function findBy($criteria = [])
    {
        $qb = $this->repository->createQueryBuilder("property_category");

        $qb->select("property_category.id")->where($qb->expr()->in("property_category.id", $criteria));
        $result = $qb->getQuery()->getResult();

        return $result;
    }
}
