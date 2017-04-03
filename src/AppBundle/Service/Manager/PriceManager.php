<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Price;
use AppBundle\Entity\Property;
use AppBundle\Entity\PropertyProduct;
use AppBundle\Entity\User;
use AppBundle\Repository\PriceRepository;
use Doctrine\ORM\EntityManager;

class PriceManager
{
    /**
     * @var PriceRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PropertyProductRepository constructor.
     *
     * @param PriceRepository $repository
     * @param EntityManager          $em
     */
    public function __construct(PriceRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAll()
    {
        $qb = $this->repository->createQueryBuilder('price');

        return $qb;
    }

    /**
     * @param Property $property
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByProperty(Property $property)
    {
        $qb = $this->repository->createQueryBuilder('price')
            ->where("price.property = :property")
            ->setParameter("property",$property)
            ->orderBy("price.product")
            ->getQuery()
            ->execute()
        ;

        return $qb;
    }

    /**
     * @param PropertyProduct $product
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByProduct(PropertyProduct $product)
    {
        $qb = $this->repository->createQueryBuilder('price')
            ->where("price.product = :product")
            ->setParameter("product",$product)
            ->getQuery()
            ->execute()
        ;

        return $qb;
    }

    /**
     * @param Property $property
     * @return mixed
     */
    public function findByCount(Property $property)
    {
        $qb = $this->repository->createQueryBuilder('price')
            ->select("COUNT(price.id)")
            ->where("price.property = :property")
            ->setParameter("property",$property)
            ->getQuery()
            ->getSingleResult()
        ;

        return $qb;
    }

    /**
     * @param Property $property
     * @param User $owner
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByPropertyOwner(Property $property, User $owner)
    {
        $qb = $this->repository->createQueryBuilder('price')
            ->where("price.property = :property")
            ->andWhere("owner = :owner")
            ->setParameters(array("property" => $property, "owner" => $owner))
            ->getQuery()
            ->execute()
        ;

        return $qb;
    }

    /**
     * @return Price
     */
    public function create()
    {
        return new Price();
    }

    /**
     * @param Price $product
     *
     * @return Price
     */
    public function persist(Price $product)
    {
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}

