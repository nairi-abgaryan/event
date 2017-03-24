<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Property;
use AppBundle\Entity\PropertyProduct;
use AppBundle\Repository\PropertyProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class PropertyProductManager
{
    /**
     * @var PropertyProductRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PropertyProductRepository constructor.
     *
     * @param PropertyProductRepository $repository
     * @param EntityManager          $em
     */
    public function __construct(PropertyProductRepository $repository, EntityManager $em)
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
     * @param Property $property
     * @return  QueryBuilder
     */
    public function findByProperty(Property $property)
    {
        $qb = $this->repository->createQueryBuilder('property_category')
                ->where("property_category.property = :property")
                ->setParameter("property", $property)
                ->getQuery()
                ->execute();

        return $qb;
    }

    /**
     * @return PropertyProduct
     */
    public function create()
    {
        return new PropertyProduct();
    }

    /**
     * @param PropertyProduct $product
     *
     * @return mixed
     */
    public function persist(PropertyProduct $product)
    {
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}

