<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\Token;
use AppBundle\Repository\TokenRepository;
use Doctrine\ORM\EntityManager;

class TokenManager
{
    /**
     * @var TokenRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UserManager constructor.
     *
     * @param TokenRepository $repository
     * @param EntityManager    $em
     */
    public function __construct(TokenRepository $repository, EntityManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @param $id
     *
     * @return null|object|Token
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return null|object|Token
     */
    public function findOneBy($criteria = [])
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @return Token
     */
    public function create()
    {
        return new Token();
    }

    /**
     * @param Token $token
     *
     * @return Token
     */
    public function persist(Token $token)
    {
        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }

    /**
     * @param Token $token
     */
    public function remove(Token $token)
    {
        $this->em->remove($token);
        $this->em->flush();
    }
}
