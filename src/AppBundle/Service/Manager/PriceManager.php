<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Price;
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

