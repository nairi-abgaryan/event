<?php

namespace AppBundle\Service\Manager;

use AppBundle\Entity\File;
use AppBundle\Entity\User;
use AppBundle\Repository\FileRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    /**
     * @var FileRepository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var string
     */
    private $uploadsDir;

    /**
     * ImageManager constructor.
     *
     * @param FileRepository $repository
     * @param EntityManager   $em
     * @param string          $rootDir
     */
    public function __construct(FileRepository $repository, EntityManager $em, $rootDir)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->uploadsDir = $rootDir . '/../web/uploads/files/';
    }

    /**
     * @param $id
     *
     * @return object|null|File
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|File
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
        $qb = $this->repository->createQueryBuilder('file');

        return $qb;
    }

    /**
     * @return File
     */
    public function create()
    {
        return new File();
    }

    /**
     * @param UploadedFile $file
     * @param User         $owner
     * @param File        $oldImage
     *
     * @return File
     */
    public function upload(UploadedFile $file, User $owner, File $oldImage = null)
    {
        $image =  $this->create();

        $image->setOwner($owner);
        $path = md5(uniqid($file->getClientOriginalName(), true)).".". $file->getClientOriginalExtension();
        $file->move($this->uploadsDir, $path);
        $image->setPath($path);
        $image->setFile($file);

        return $this->persist($image);
    }

    /**
     * @param File $image
     */
    public function uploadFromAdmin(File $image)
    {
        $oldImage = ($image->getPath()) ? $image : null;
        $image->setPath($this->upload($image->getFile(), $image->getOwner(), $oldImage)->getPath());
    }

    /**
     * @param File $image
     *
     * @return File
     */
    public function persist(File $image)
    {
        $this->em->persist($image);
        $this->em->flush();

        return $image;
    }
}
