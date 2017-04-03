<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Favorite;
use AppBundle\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManager;

class FavoriteManager
{
    /**
     * @var FavoriteRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * FavoriteManager constructor.
     *
     * @param FavoriteRepository $repository
     * @param EntityManager      $em
     */
    public function __construct(FavoriteRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param $id
     *
     * @return object|null|Favorite
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|Favorite
     */
    public function findOneBy($criteria = [])
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @param string $id
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findBy($id)
    {
        return $this->repository->createQueryBuilder('favorite')->where("favorite.owner=$id");
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAll()
    {
        $qb = $this->repository->createQueryBuilder('favorite');

        return $qb;
    }

    /**
     * @return Favorite
     */
    public function create()
    {
        return new Favorite();
    }

    /**
     * @param Favorite $favorite
     *
     * @return Favorite
     */
    public function persist(Favorite $favorite)
    {
        $this->em->persist($favorite);
        $this->em->flush();

        return $favorite;
    }

    /**
     * @param Favorite $favorite
     *
     * @return string
     */
    public function remove(Favorite $favorite)
    {
        $this->em->remove($favorite);
        $this->em->flush();

        return "Removed item";
    }

}
