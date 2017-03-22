<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\PriceProduct;
use AppBundle\Repository\PriceProductRepository;
use Doctrine\ORM\EntityManager;

class PriceProductManager
{
    /**
     * @var PriceProductRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PropertyProductRepository constructor.
     *
     * @param PriceProductRepository $repository
     * @param EntityManager          $em
     */
    public function __construct(PriceProductRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAll()
    {
        $qb = $this->repository->createQueryBuilder('price_product');

        return $qb;
    }

    /**
     * @return PriceProduct
     */
    public function create()
    {
        return new PriceProduct();
    }

    /**
     * @param PriceProduct $product
     *
     * @return PriceProduct
     */
    public function persist(PriceProduct $product)
    {
        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}

