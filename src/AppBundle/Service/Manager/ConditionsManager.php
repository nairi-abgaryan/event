<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Conditions;
use AppBundle\Repository\ConditionsRepository;
use Doctrine\ORM\EntityManager;

class ConditionsManager
{
    /**
     * @var ConditionsRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ContactManager constructor.
     *
     * @param ConditionsRepository $repository
     * @param EntityManager  $em
     */
    public function __construct(ConditionsRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param $id
     *
     * @return object|null|Conditions
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|Conditions
     */
    public function findOneBy($criteria = [])
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAll()
    {
        $qb = $this->repository->createQueryBuilder('conditions');

        return $qb;
    }

    /**
     * @return Conditions
     */
    public function create()
    {
        return new Conditions();
    }
}

