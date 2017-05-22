<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Property;
use AppBundle\Entity\PropertyProduct;
use AppBundle\Entity\PropertyType;
use AppBundle\Entity\User;
use AppBundle\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Date;

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
     * @return mixed
     */
    public function findByDate($now, $date)
    {
        return $this->repository->createQueryBuilder('property')
            ->where("property.end >= :now")
            ->andWhere("property.end <= :date")
            ->setParameters(array("date" => $date, "now" => $now))
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function findBy($user)
    {
        return $this->repository->createQueryBuilder('property')
            ->where("property.owner = :owner")
            ->setParameters(array("owner" => $user))
            ->orderBy("property.createdAt", "DESC")
            ->getQuery()
            ->getResult();
    }

    /**
     * @param PropertyType $type
     *
     * @return mixed
     */
    public function findByTypeResultTwo(PropertyType $type)
    {
        return $this->repository->createQueryBuilder('property')
            ->where("property.type = :type")
            ->andWhere("property.actived =:active")
            ->andWhere("property.removed =:notRemoved")
            ->andWhere("property.end >= :date")
            ->setParameters(array(
                "type" => $type,
                "active"=>true,
                "notRemoved" => false,
                "date" => new \DateTime("now")
            ))
            ->orderBy("property.end","DESC")
            ->setMaxResults(2)
            ->getQuery()
            ->execute()
            ;
    }

    /**
     * @param PropertyType $type
     *
     * @return mixed
     */
    public function findByType(PropertyType $type)
    {
        return $this->repository->createQueryBuilder('property')
            ->where("property.type = :type")
            ->andWhere("property.actived =:active")
            ->andWhere("property.removed =:notRemoved")
            ->andWhere("property.end >= :date")
            ->setParameters(array(
                "type" => $type,
                "active"=>true,
                "notRemoved" => false,
                "date" => new \DateTime("now")
            ))
            ->orderBy("property.id","DESC")
            ;
    }

    /**
     * @return mixed
     */
    public function findByCategory($cridantial, $user, $name, $param)
    {
        $qb = $this->repository->createQueryBuilder('property')
                ->where("property.owner = :owner")
                ->andWhere("$cridantial")
                ->setParameters(["$name" => $param, "owner" => $user])
         ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @return mixed
     */
    public function findByFilters($type,$propertyType,$start,$end, $category)
    {
        $qb = $this->repository->createQueryBuilder('property');

        $qb ->where($qb->expr()->in("property.type" ,":type"))
            ->andWhere("property.start >= :start")
            ->andWhere("property.end <= :end")
            ->andWhere("property.actived = :actived")
            ->andWhere("property.removed = :removed")
            ->andWhere($qb->expr()->in("property.propertyType" ,":propertyType"))
            ->andWhere($qb->expr()->in("property.category" ,":category"))
            ->setParameters(array(
                "removed" => 0,
                "actived" => 1,
                "type" => $type,
                "category" => $category,
                "start" => $start,
                "end" => $end,
                "propertyType" => $propertyType
            ))
            ->setMaxResults(50)
        ;

        return $qb->getQuery()->getResult();
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


    /**
     * @param Property $property
     *
     * @return string
     */
    public function remove(Property $property)
    {
        $this->em->remove($property);
        $this->em->flush();

        return "Removed item";
    }
}
