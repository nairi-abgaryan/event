<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\News;
use AppBundle\Repository\NewsRepository;
use Doctrine\ORM\EntityManager;

class NewsManager
{
    /**
     * @var NewsRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PropertyTypeManager constructor.
     *
     * @param NewsRepository $repository
     * @param EntityManager          $em
     */
    public function __construct(NewsRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $qb = $this->repository->createQueryBuilder('news')
            ->getQuery()
            ->getResult();

        return $qb;
    }

    /**
     * @param $id
     *
     * @return object|null|News
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }
}
