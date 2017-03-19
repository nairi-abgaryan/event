<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;

class UserManager
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UserManager constructor.
     *
     * @param UserRepository $repository
     * @param EntityManager  $em
     */
    public function __construct(UserRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param $id
     *
     * @return object|null|User
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|User
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
        $qb = $this->repository->createQueryBuilder('user');

        return $qb;
    }

    /**
     * @return User
     */
    public function create()
    {
        return new User();
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function persist(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
