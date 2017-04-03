<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Contact;
use AppBundle\Repository\PrivacyRepository;
use Doctrine\ORM\EntityManager;

class PrivacyManager
{
    /**
     * @var PrivacyRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ContactManager constructor.
     *
     * @param PrivacyRepository $repository
     * @param EntityManager      $em
     */
    public function __construct(PrivacyRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param $id
     *
     * @return object|null|Contact
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|Contact
     */
    public function findOneBy($criteria = [])
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $qb = $this->repository->findAll();

        return $qb;
    }

    /**
     * @return Contact
     */
    public function create()
    {
        return new Contact();
    }
}

