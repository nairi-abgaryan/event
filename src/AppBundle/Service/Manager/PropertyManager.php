<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Property;
use AppBundle\Repository\PropertyRepository;
use Doctrine\ORM\EntityManager;

class PropertyManager
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PropertyManager constructor.
     *
     * @param PropertyRepository $repository
     * @param EntityManager      $em
     */
    public function __construct(PropertyRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param $id
     *
     * @return object|null|Property
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|Property
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
        $qb = $this->repository->createQueryBuilder('property');

        return $qb;
    }

    /**
     * @return Property
     */
    public function create()
    {
        return new Property();
    }

    /**
     * @param Property $property
     *
     * @return Property
     */
    public function persist(Property $property)
    {
        $this->em->persist($property);
        $this->em->flush();

        return $property;
    }
}
